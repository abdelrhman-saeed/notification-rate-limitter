<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\UserAlertNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;


class UserNotificationController extends Controller
{
    public function notify(NotificationRequest $request) {

        /** @var \App\Model\User */

        $user = Cache::remember("user:{{$request->user_id}", now()->addMinutes(10),
                    function () use ($request) {
                        return User::findOrFail($request->user_id);
                    });

        $user->notify(new UserAlertNotification($request->message));

        return new JsonResponse([
            'id'        => $request->user_id,
            'message'   => 'Notification sent'
        ]);
    }
}
