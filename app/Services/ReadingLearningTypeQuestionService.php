<?php namespace App\Services;

use App\Models\ReadingLearningTypeQuestion;
use Illuminate\Support\Facades\Auth;

class ReadingLearningTypeQuestionService {
    private $_readingLearningTypeQuestionModel;

    private $_adminId;

    public function __construct()
    {
        $this->_readingLearningTypeQuestionModel = new ReadingLearningTypeQuestion();
        $this->_adminId = Auth::id();
    }

    public function createNewLearningTypeQuestion($type_question_id, $title_section, $step_section, $view_layout, $icon, $content_section, $left_content, $right_content) {
        return $this->_readingLearningTypeQuestionModel->createNewLearningTypeQuestion($type_question_id, $title_section, $step_section, $view_layout, $icon, $content_section, $left_content, $right_content, $this->_adminId);
    }

    public function getLearningOfTypeQuestion($type_question_id) {
        return $this->_readingLearningTypeQuestionModel->getLearningOfTypeQuestion($type_question_id);
    }

    public function getLearningDetail($learning_id) {
        return $this->_readingLearningTypeQuestionModel->getLearningDetail($learning_id);
    }
}
?>