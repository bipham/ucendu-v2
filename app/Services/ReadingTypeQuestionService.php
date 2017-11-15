<?php namespace App\Services;

use App\Models\ReadingTypeQuestion;
use Illuminate\Support\Facades\Auth;

class ReadingTypeQuestionService {
    private $_readingTypeQuestionModel;
    private $_adminId;

    public function __construct()
    {
        $this->_readingTypeQuestionModel = new ReadingTypeQuestion();
        $this->_adminId = Auth::id();
    }

    public function createNewTypeQuestion($name, $level_lesson_id, $tip_guide) {
        return $this->_readingTypeQuestionModel->createNewTypeQuestion($name, $level_lesson_id, $tip_guide, $this->_adminId);
    }

    public function updateTypeQuestion($name, $level_lesson_id, $tip_guide, $type_question_id) {
        return $this->_readingTypeQuestionModel->updateTypeQuestion($name, $level_lesson_id, $tip_guide, $type_question_id, $this->_adminId);
    }

    public function getAllTypeQuestionById($level_lesson_id) {
        return $this->_readingTypeQuestionModel->getAllTypeQuestionById($level_lesson_id);
    }

    public function getAllTypeQuestion() {
        $all_type_questions = $this->_readingTypeQuestionModel->getAllTypeQuestion();
        foreach ($all_type_questions as $index => $type_question) {
            $all_type_questions[$index]->time_ago = timeFormat($type_question->created_at);
        }
        return $all_type_questions;
    }

    public function getDetailTypeQuestion($type_question_id) {
        return $this->_readingTypeQuestionModel->getDetailTypeQuestion($type_question_id);
    }
}
?>