<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\User;

trait NotificationTrait
{
    /**
     * Send notification to a user
     */
    public function sendNotification(User $user, string $type, string $title, string $message, array $data = []): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => json_encode($data),
        ]);
    }

    /**
     * Send notification to multiple users
     */
    public function sendNotificationToMany(array $userIds, string $type, string $title, string $message, array $data = []): void
    {
        $notifications = [];
        foreach ($userIds as $userId) {
            $notifications[] = [
                'user_id' => $userId,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => json_encode($data),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Notification::insert($notifications);
    }
}
