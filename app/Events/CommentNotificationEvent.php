<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $title;
    public $message;
    public $username;
    public $avatar;
    public $comment;
    public $room;
    public $time_code;

    public function __construct($title, $message, $username, $avatar, $comment, $room, $time_code)
    {
        $this->title = $title;
        $this->message = $message;
        $this->username = $username;
        $this->avatar = $avatar;
        $this->comment = $comment;
        $this->room = $room;
        $this->time_code = $time_code;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('room-'.$this->room);
    }
}
