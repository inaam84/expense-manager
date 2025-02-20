<?php

namespace App\Http\Controllers;

use App\Models\NotificationPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationPreferenceController extends Controller
{
    public function index()
    {
        $notifyDaysBefore = [];
        for($i = 1; $i <= 50; $i < 10 ? $i++ : $i += 5)
        {
            $notifyDaysBefore[$i] = $i == 1 ? "{$i} day before" : "{$i} days before"; 
        }
        $frequency = [
            'daily' => 'daily',
            'weekly' => 'weekly',
        ];

        $savedPreferences = auth()->user()->notificationPreferences;

        return view('notification_preferences.index', compact('notifyDaysBefore', 'frequency', 'savedPreferences'));
    }

    public function store(Request $request)
    {
        // Manually validating to return JSON response
        $validator = Validator::make($request->all(), [
            'notification_type' => 'required|string',
            'notify_before_days' => 'required|integer',
            'frequency' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        NotificationPreference::updateOrCreate(
            ['user_id' => auth()->id(), 'notification_type' => $request->notification_type],
            ['notify_before_days' => $request->notify_before_days, 'frequency' => $request->frequency]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Notification preference updated successfully'
        ]);
    }
}
