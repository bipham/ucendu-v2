<?php namespace App\Services;

use App\Models\ReadingTypeQuestionDetailOfLesson;
use Illuminate\Support\Facades\Auth;

class ReadingTypeQuestionDetailOfLessonService {
    private $_readingTypeQuestionDetailOfLessonModel;
    private $_adminId;

    public function __construct()
    {
        $this->_readingTypeQuestionDetailOfLessonModel = new ReadingTypeQuestionDetailOfLesson();
        $this->_adminId = Auth::id();
    }

    public function createNewTypeQuestionDetail($lesson_id, $type_lesson_id, $type_question_id) {
        return $this->_readingTypeQuestionDetailOfLessonModel->createNewTypeQuestionDetail($lesson_id, $type_lesson_id, $type_question_id);
    }

}
?>