<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $avatar;
    public $username;
    public $lesson_id;
    public $title_lesson;
    public $type_question;
    public $level_lesson;
    public $level_lesson_id;

    public function __construct($avatar, $username, $lesson_id, $title_lesson, $type_question, $level_lesson, $level_lesson_id)
    {
        $this->avatar = $avatar;
        $this->username = $username;
        $this->lesson_id = $lesson_id;
        $this->title_lesson = $title_lesson;
        $this->type_question = $type_question;
        $this->level_lesson = $level_lesson;
        $this->level_lesson_id = $level_lesson_id;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'avatar' => $this->avatar,
            'username' => $this->username,
            'lesson_id' => $this->lesson_id,
            'title_lesson' => $this->title_lesson,
            'type_question' => $this->type_question,
            'level_lesson' => $this->level_lesson,
            'level_lesson_id'=> $this->level_lesson_id
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
