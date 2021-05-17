<?php

namespace App\Channels;

use Berkayk\OneSignal\OneSignalFacade;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class OnesignalWebPushChannel
{

    public function send($notifiable, Notification $notification)
    {
        $player_ids = $notifiable->pushes()->pluck('player_id')->toArray();

        Log::notice('checking..');

        if ($player_ids){
            $n = $notification->toOnesignalWebPush($notifiable);

            $params = array(
                'contents' => [
                    'en' => $n['contents']
                ],
                'headings' => [
                    'en' => $n['headings']
                ],
                'include_player_ids' => $player_ids,
                'url' => $n['url'],
            );

            Log::notice($player_ids);

            OneSignalFacade::sendNotificationCustom($params);
        }
    }
}
