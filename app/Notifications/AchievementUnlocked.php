<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AchievementUnlocked extends Notification
{
    use Queueable;

    protected $achievement;

    public function __construct($achievement)
    {
        $this->achievement = $achievement;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->achievement->title,
            'description' => $this->achievement->description,
            'icon' => $this->achievement->icon,
        ];
    }
}
