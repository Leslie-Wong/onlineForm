<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Lesliew\LaravelJetinGenerator\Helpers\ApiResponse;

class MeNotificationsController extends Controller
{
    private $api;
    public function __construct(ApiResponse $apiResponse)
    {
        $this->api = $apiResponse;
    }

    /**
     * @param  int  $id  Notification ID
     * @return \Illuminate\Http\Response
     */
    public function read($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['link']);
        }
    }

    /**
     * @param  int  $id  Notification ID
     * @return \Illuminate\Http\Response
     */
    public function unreadFetch()
    {
        try {
            $payload = auth()->user()->notifications()->whereNull('read_at')->get();

            if ($payload) {
                return $this->api->success()
                        ->message("Unread Notifications")
                        ->payload($payload)->send();
            }
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }
}
