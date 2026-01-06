<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class TestNotificationController extends Controller
{
    public function sendTestNotification(Request $request)
    {
        $userId = $request->input('user_id', auth()->id());

        $notification = Notification::create([
            'user_id' => $userId,
            'title' => 'Test Notification',
            'message' => 'This is a test real-time notification!',
            'type' => 'test',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Test notification sent successfully',
            'notification' => $notification
        ]);
    }
}
