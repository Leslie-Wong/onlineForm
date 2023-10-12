<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class SendNotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = User::first();

        // dd($user->notifications);
        // $user->notify(new \App\Notifications\TestNotification('Hello World 123'));
        // Notification::send($user,new \App\Notifications\TestNotification('Hello World'));
        $user->notify(new \App\Notifications\SendNotification([
            'title' => "news",
            'body' => 'Test1 2 3 4',
            'action' => "url",
            "action_title" => "READ",
        ]));
        // dd($user->notifications);
        dd("Sent");
    }
}
