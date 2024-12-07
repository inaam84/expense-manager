<?php

namespace App\Console\Commands;

use App\Models\Auth\AuthenticationLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemoveAuthLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'authlogs:cleanup {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove authentication log entries up to the specified date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = $this->argument('date');

        if(! $this->validateDate($date) || !$this->isBeforeToday($date))
        {
            $this->error('Invalid date. Please ensure the date is in YYYY-MM-DD format and is before today.');

            return 1;
        }

        $parsedDate = Carbon::createFromFormat('Y-m-d', $date)->endOfDay();

        $deleteCount = AuthenticationLog::where('login_at', '<=', $parsedDate)->delete();

        $this->info("Successfully removed {$deleteCount} authentication log entries up to {$date}. ");

        return 0;
    }

    protected function validateDate($date)
    {
        $d = Carbon::createFromFormat('Y-m-d', $date);

        return $d && $d->format('Y-m-d') === $date;
    }

    protected function isBeforeToday($date)
    {
        $d = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();

        return $d->isBefore( Carbon::today() );
    }
}
