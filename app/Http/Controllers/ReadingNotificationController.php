<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\ReadingQuestionAnswerLessonService;
use App\Services\ReadingNotificationService;
use App\Events\CommentNotificationEvent;

class ReadingNotificationController extends Controller
{
    public function getPusher(){
        // gọi ra trang view demo-pusher.blade.php
        return view("client.reading");
    }
    public function fireEvent(){
//        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
//        $list_notifications = $readingQuestionAnswerLessonService->getAllComments();
        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
        $readingNotificationService = new ReadingNotificationService();
//        $new_comment = $readingQuestionAnswerLessonService->createNewCommentLesson($question_custom_id, $user_id, $reply_comment_id, $content_cmt);
        $related_admins = $readingQuestionAnswerLessonService->getAllRelatedAdmins(8);
        $new_comment = $readingQuestionAnswerLessonService->createNewCommentLesson(8, 1, 30, 'ahhihihihiihi');
        $list_notifications = $readingNotificationService->pushCommentNotification($new_comment);
        dd($list_notifications);
        return 'dsaddas';
    }

    public function testEvent(){
        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
        $new_comment = $readingQuestionAnswerLessonService->createNewCommentLesson(8, 1, 30, 'ahhihihihiihi');
        event(new CommentNotificationEvent('dsad', 'dsad', 'dsad 1', 'logo', $new_comment, 1, time()));
        return "Message has been sent.";
    }

    public function getNotification() {
        $readingNotificationService = new ReadingNotificationService();
        $list_notifications = $readingNotificationService->getAllNotifications();
        return json_encode(['list_notis' => $list_notifications]);
    }

    public function readNotification($domain, $id) {
        $readingNotificationService = new ReadingNotificationService();
        $result = $readingNotificationService->markAsReadNotification($id);
        return json_encode(['ok' => $result]);
    }

    public function markAllNotificationAsRead() {
        $readingNotificationService = new ReadingNotificationService();
        $result = $readingNotificationService->markAllAsReadNotification();
        return json_encode(['ok' => $result]);
    }
}
