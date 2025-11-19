<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;

class FcmService
{
    public function send($token, $title, $body, $data = [])
    {
        $credentialsFile = config('firebase.credentials.file');

        if (!file_exists($credentialsFile)) {
            $error = 'Firebase credentials file not found at: ' . $credentialsFile;
            Log::error('FCM Send Failed: ' . $error);
            return $error;
        }

        try {
            $factory = (new Factory)->withServiceAccount($credentialsFile);
            $messaging = $factory->createMessaging();

            $messageData = array_merge([
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ], $data);

            $message = [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $messageData,
            ];

            return $messaging->send($message);
        } catch (\Throwable $th) {
            Log::error('FCM Send Failed: ' . $th->getMessage());
            return $th->getMessage();
        }
    }
}
