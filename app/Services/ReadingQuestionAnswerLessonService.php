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

    public function getAllCommentsByQuestionCustomId($question_custom_id) {
        $list_comments = $this->_readingQuestionAndAnswerLessonModel->getAllCommentsByQuestionCustomId($question_custom_id);

        foreach ($list_comments as $list_comment) {
            $list_comment->updated_at = timeFormat($list_comment->updated_at);
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
}
?>