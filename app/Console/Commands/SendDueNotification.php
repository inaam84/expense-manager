<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\InsuranceDueNotification;
use App\Notifications\MOTDueNotification;
use App\Notifications\TaxDueNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendDueNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:due-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for upcoming MOT and Tax due dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        User::with(['vehicles', 'notificationPreferences'])->chunk(50, function ($users) use ($today) {
            foreach ($users as $user) {
                foreach ($user->vehicles as $vehicle) {
                    foreach ($user->notificationPreferences as $preference) {
                        $dueDateField = "{$preference->notification_type}_due_date";
                        
                        if (!isset($vehicle->$dueDateField)) continue; 

                        $notificationDate = Carbon::parse($vehicle->$dueDateField)->subDays($preference->notify_before_days);
                        if ($today->greaterThanOrEqualTo($notificationDate)) {
                            if ($this->shouldSendNotification($preference->frequency, $vehicle->id, $preference->notification_type)) {
                                $user->notify($this->getNotificationInstance($preference->notification_type, $vehicle));
                            }
                        }
                    }
                }
            }
        });

        $this->info('Due date notifications sent successfully.');
    }

    protected function shouldSendNotification($frequency, $vehicleId, $type)
    {
        $lastSentKey = "notification_last_sent:{$type}:{$vehicleId}";
        $lastSent = cache($lastSentKey);

        $now = Carbon::now();
        $shouldSend = false;

        switch ($frequency) {
            case 'daily':
                $shouldSend = !$lastSent || $now->diffInDays($lastSent) >= 1;
                break;
            case 'weekly':
                $shouldSend = !$lastSent || $now->diffInWeeks($lastSent) >= 1;
                break;
        }

        if ($shouldSend) {
            cache([$lastSentKey => $now], now()->addDays(1)); // Cache expiry to avoid duplicate sends
        }

        return $shouldSend;
    }

    protected function getNotificationInstance($type, $vehicle)
    {
        return match ($type) {
            'mot' => new MOTDueNotification($vehicle),
            'tax' => new TaxDueNotification($vehicle),
            'insurance' => new InsuranceDueNotification($vehicle),
            default => null,
        };
    }
}
