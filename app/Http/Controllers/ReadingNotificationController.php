<?php

namespace App\Http\Controllers;

use App\Events\TestCommentEvent;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\CommentNotificationEvent;
use App\Models\User;
use App\Services\ReadingQuestionAnswerLessonService;

class ReadingNotificationController extends Controller
{
    public function getPusher(){
        // gọi ra trang view demo-pusher.blade.php
        return view("client.reading");
    }
    public function fireEvent(){

        event(new CommentNotificationEvent("Hi, I'm Bi send message to you message!"));

        // Truyền message lên server Pusher
        return "Message has been sent.";
    }

    public function testEvent(){
        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
        $related_users = $readingQuestionAnswerLessonService->getAllRelatedUser(7);
        $users = User::all();
dd($related_users);
        foreach ($users as $this_user) {
            if ($this_user->id != Auth::id()) {
                event(new TestCommentEvent("Hi, I'm " . Auth::user()->username . " send message to " . $this_user->username . "!", Auth::user(), $this_user->id, time()));
            }
        }
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
