<?php namespace App\Services;

use App\Events\CommentNotificationEvent;
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

    public function pushCommentNotification($related_users, $comment) {
        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
        $comment = $readingQuestionAnswerLessonService->getMoreDetailOfComment($comment);
        foreach ($related_users as $related_user) {
            if ($related_user->user_id != $this->_userId) {
                //Save DB:
                $user_received = Auth::user()->find($related_user->user_id);
                $user_received->notify(new \App\Notifications\CommentNotification($comment));

                //Push notification:
                $title = 'New comment from UCENDU!';
                $message = $comment['username'] . " just replied a comment that you follow!";
                $total_notifications = count($user_received->unreadNotifications);
//                $url = '/reading/' . $level_lesson . '-level/readingViewSolutionLesson/' . $type_lesson_id . '-' . $lesson_id . 'lesson?question=' . $comment->question_custom_id . '&comment=' . $comment->id;
                event(new CommentNotificationEvent($title, $message, $comment['username'], $comment['avatar'], $comment, $related_user->user_id, $total_notifications, time()));
            }
        }
    }

    public function getAllNotifications() {
        $list_notifications =  Auth::user()->notifications;
        return $list_notifications;
    }

    public function markAsReadNotification($id) {
        Auth::user()->unreadNotifications->where('id', $id)->markAsRead();
        return 'success';
    }

    public function markAllAsReadNotification() {
        Auth::user()->unreadNotifications->markAsRead();
        return 'success';
    }
}
?>