<?php namespace App\Services;

use App\Events\TestCommentEvent;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification;

class ReadingNotificationService {
    private $_notificationModel;
    private $_userId;

    public function __construct()
    {
        $this->_notificationModel = new Notification();
        $this->_userId = Auth::id();
    }

    public function pushCommentNotification($related_users, $comment) {
        //Save DB:
        foreach ($related_users as $related_user) {
            if ($related_user->id != $this->_userId) {
                event(new TestCommentEvent("Hi, I'm " . Auth::user()->username . " send message to " . $related_user->username . "!", Auth::user(), $related_user->id, time()));
            }
        }
    }
}
?>