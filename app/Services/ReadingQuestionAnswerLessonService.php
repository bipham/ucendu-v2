<?php namespace App\Services;

use App\Models\ReadingQuestionAndAnswerLesson;
use Illuminate\Support\Facades\Auth;

class ReadingQuestionAnswerLessonService {
    private $_readingQuestionAndAnswerLessonModel;
    private $_userId;

    public function __construct()
    {
        $this->_readingQuestionAndAnswerLessonModel = new ReadingQuestionAndAnswerLesson();
        $this->_userId = Auth::id();
    }

    public function getAllCommentsOfQuestion($question_custom_id) {
        $list_comments = $this->_readingQuestionAndAnswerLessonModel->getAllCommentsOfQuestion($question_custom_id);

        foreach ($list_comments as $list_comment) {
            $list_comment->updated_at = timeFormat($list_comment->updated_at);
        }

        return $list_comments;
    }

    public function getAllComments() {
        $list_comments = $this->_readingQuestionAndAnswerLessonModel->getAllComments();
        foreach ($list_comments as $index => $list_comment) {
            $list_comments[$index] = $this->getMoreDetailOfComment($list_comments[$index]);
        }
        return $list_comments;
    }

    public function createNewCommentLesson($question_custom_id, $user_id, $reply_comment_id, $content_cmt) {
        if ($user_id == $this->_userId) {
            $level_user_id = Auth::user()->level_user_id;
            if ($level_user_id == 1) {
                $private = 0;
            }
            else $private = 1;
            $new_comment = $this->_readingQuestionAndAnswerLessonModel->createNewCommentLesson($question_custom_id, $user_id, $reply_comment_id, $content_cmt, $private);
            return $new_comment;
        }
    }

    public function getAllRelatedUser($question_custom_id) {
        return $this->_readingQuestionAndAnswerLessonModel->getAllRelatedUser($question_custom_id);
    }

    public function getAllRelatedAdmins($question_custom_id) {
        return $this->_readingQuestionAndAnswerLessonModel->getAllRelatedAdmins($question_custom_id);
    }

    public function getMoreDetailOfComment($comment) {
        $questionLesson = $comment->questionLesson;
        $comment->type_lesson_id = $questionLesson->type_lesson_id;
        $typeQuestion = $questionLesson->typeQuestion;
        $comment->lesson_id = $questionLesson->lesson_id;
        switch ($comment->type_lesson_id) {
            case 1:
                $comment->level_lesson_id = $typeQuestion->level_lesson_id;
                $comment->level_lesson = $typeQuestion->levelLesson->level;
                $comment->type_question = $typeQuestion->name;
                $comment->title_lesson = $questionLesson->practiceLesson->title;
                $comment->type_lesson = 'Practice';
                break;
            case 2:
                $comment->level_lesson_id = $typeQuestion->level_lesson_id;
                $comment->level_lesson = $typeQuestion->levelLesson->level;
                $comment->type_question = $typeQuestion->name;
                $comment->title_lesson = $questionLesson->miniTest->title;
                $comment->type_lesson = 'Mini test';
                break;
            case 3:
                $comment->type_question = 'Mix test';
                $mixTest = $questionLesson->mixTest;
                $comment->level_lesson = $mixTest->levelLesson->level;
                $comment->level_lesson_id = $mixTest->level_lesson_id;
                $comment->title_lesson = $mixTest->title;
                $comment->type_lesson = 'Mix test';
                break;
            case 4:
                $comment->type_question = 'Full test';
                $fullTest = $questionLesson->fullTest;
                $comment->level_lesson_id = $fullTest->level_lesson_id;
                $comment->level_lesson = $fullTest->levelLesson->level;
                $comment->title_lesson = $fullTest->title;
                $comment->type_lesson = 'Full test';
                break;
        }
        $comment->time_ago = timeFormat($comment->created_at);
        $comment->username = $comment->User->username;
        $comment->avatar = $comment->User->avatar;
        return collect($comment)->except(['question_lesson', 'user', 'updated_at', 'created_at'])->all();
    }

    public function setPublicComment($comment_id) {
        return $this->_readingQuestionAndAnswerLessonModel->setPublicComment($comment_id);
    }

    public function setPrivateComment($comment_id) {
        return $this->_readingQuestionAndAnswerLessonModel->setPrivateComment($comment_id);
    }

    public function deleteComment($comment_id) {
        return $this->_readingQuestionAndAnswerLessonModel->deleteComment($comment_id);
    }
}
?>