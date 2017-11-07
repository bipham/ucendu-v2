<?php namespace App\Services;

use App\Events\TestCommentEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\ReadingPracticeLesson;
use App\Models\ReadingMiniTestLesson;
use App\Models\ReadingMixTestLesson;
use App\Models\ReadingFullTestLesson;

class ReadingNotificationService {
    private $_readingPracticeLessonModel;
    private $_readingMiniTestLessonModel;
    private $_readingMixTestLessonModel;
    private $_readingFullTestLessonModel;
    private $_notificationModel;
    private $_userId;

    public function __construct()
    {
        $this->_readingPracticeLessonModel = new ReadingPracticeLesson();
        $this->_readingMiniTestLessonModel = new ReadingMiniTestLesson();
        $this->_readingMixTestLessonModel = new ReadingMixTestLesson();
        $this->_readingFullTestLessonModel = new ReadingFullTestLesson();
        $this->_notificationModel = new Notification();
        $this->_userId = Auth::id();
    }

    public function pushCommentNotification($related_users, $comment) {
        $avatar = Auth::user()->find($comment->user_id)->avatar;
        $username = Auth::user()->find($comment->user_id)->username;
        $questionLesson = $comment->questionLesson;
        $type_lesson_id = $questionLesson->type_lesson_id;
        $typeQuestion = $questionLesson->typeQuestion;
        $lesson_id = $questionLesson->lesson_id;
        switch ($type_lesson_id) {
            case 1:
                $level_lesson_id = $typeQuestion->level_lesson_id;
                $level_lesson = $typeQuestion->levelLesson->level;
                $type_question = $typeQuestion->name;
                $title_lesson = $questionLesson->practiceLesson->title;
                break;
            case 2:
                $level_lesson_id = $typeQuestion->level_lesson_id;
                $level_lesson = $typeQuestion->levelLesson->level;
                $type_question = $typeQuestion->name;
                $title_lesson = $questionLesson->miniTest->title;
                break;
            case 3:
                $type_question = '';
                $mixTest = $questionLesson->mixTest;
                $level_lesson = $mixTest->levelLesson->level;
                $level_lesson_id = $mixTest->level_lesson_id;
                $title_lesson = $mixTest->title;
                break;
            case 4:
                $type_question = '';
                $fullTest = $questionLesson->fullTest;
                $level_lesson_id = $fullTest->level_lesson_id;
                $level_lesson = $fullTest->levelLesson->level;
                $title_lesson = $fullTest->title;
                break;
        }
        foreach ($related_users as $related_user) {
            if ($related_user->user_id != $this->_userId) {
                //Save DB:
                $user_received = Auth::user()->find($related_user->user_id);
                $user_received->notify(new \App\Notifications\CommentNotification($avatar, $username, $lesson_id, $title_lesson, $type_question, $level_lesson, $level_lesson_id));
                //Push notification:
                $title = 'New comment from UCENDU!';
                $message = $username . " just replied a comment that you follow!";
//                $url = '/reading/' . $level_lesson . '-level/readingViewSolutionLesson/' . $type_lesson_id . '-' . $lesson_id . 'lesson?question=' . $comment->question_custom_id . '&comment=' . $comment->id;
                event(new TestCommentEvent($title, $message, $username, $avatar, $comment, $related_user->user_id, time()));
            }
        }
    }
}
?>