<?php

namespace App\Http\Controllers;

use App\Events\TestCommentEvent;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\CommentNotificationEvent;
//use App\Models\User;
use App\Services\ReadingQuestionAnswerLessonService;

class ReadingNotificationController extends Controller
{
    public function getPusher(){
        // gọi ra trang view demo-pusher.blade.php
        return view("client.reading");
    }
    public function fireEvent(){
        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
        $new_comment = $readingQuestionAnswerLessonService->createNewCommentLesson(7, Auth::id(), 0, 'bipro');
        $type_lesson_id = $new_comment->questionLesson->type_lesson_id;
        $level_lesson_id = $new_comment->questionLesson->typeQuestion->levelLesson->level;
        dd($level_lesson_id);
    }

    public function testEvent(){
        Auth::user()->unreadNotifications->where('id', '00f17a9f-8dd1-43e2-a53c-fa261f5f9e19')->markAsRead();
        return "Message has been sent.";
    }

    public function pusherAuth() {

        if ( Auth::user() )
        {
            $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'));
            $socket_id = $_POST['socket_id'];
            $channel_name = $_POST['channel_name'];
            echo $pusher->presence_auth($_POST['channel_name'], $_POST['socket_id'], Auth::id());
        }
        else
        {
            header('', true, 403);
            echo( "Forbidden" );
        }

    }
}
