<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\ReadingQuestionAnswerLessonService;
use App\Services\ReadingNotificationService;
use App\Events\CommentNotificationEvent;
use App\Services\UcenduUserService;

class ReadingNotificationController extends Controller
{
    public function getPusher(){
        // gọi ra trang view demo-pusher.blade.php
        return view("client.reading");
    }
    public function fireEvent(){
//        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
//        $list_notifications = $readingQuestionAnswerLessonService->getAllComments();
        $ucenduUserService = new UcenduUserService();
//        $related_admins = $readingQuestionAnswerLessonService->getAllRelatedAdmins($question_custom_id);
        $all_admins = $ucenduUserService->getAllAdmins();
        dd($all_admins);
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
