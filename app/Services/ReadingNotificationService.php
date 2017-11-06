<?php namespace App\Services;

use App\Events\TestCommentEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ReadingNotificationService {
    private $_notificationModel;
    private $_userId;

    public function __construct()
    {
        $this->_notificationModel = new Notification();
        $this->_userId = Auth::id();
    }

    public function pushCommentNotificationToAdmin($related_admins, $comment) {
        $avatar = Auth::user()->find($comment->user_id)->avatar;
        $username = Auth::user()->find($comment->user_id)->username;
        foreach ($related_admins as $related_admin) {
            if ($related_admin->user_id != $this->_userId) {
                //Save DB:
//                $user_received = Auth::user()->find($related_admin->user_id);
//                $user_received->notify(new \App\Notifications\CommentNotification($comment, $user_received));
                //Push notification:
                $title = 'New comment from UCENDU!';
                $message = $username . " just replied a comment that you follow!";
//                $url = '/reading/' . $level_lesson . '-level/readingViewSolutionLesson/' . $type_lesson_id . '-' . $lesson_id . 'lesson?question=' . $comment->question_custom_id . '&comment=' . $comment->id;
                event(new TestCommentEvent($title, $message, $username, $avatar, $comment, $related_admin->user_id, time()));
            }
        }
    }
}
?>