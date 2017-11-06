<?php namespace App\Services;

use App\Models\ReadingQuestionLearning;

class ReadingQuestionLearningService {
    private $_readingQuestionLearningModel;

    public function __construct()
    {
        $this->_readingQuestionLearningModel = new ReadingQuestionLearning();
    }

    public function getTheLastQuestionCustomId() {
        $last_question_custom = $this->_readingQuestionLearningModel->getTheLastQuestionCustomId();
        if (!$last_question_custom) {
            $last_question_custom_id = 1;
        }
        else {
            $last_question_custom_id = $last_question_custom->question_custom_id + 1;
        }
        return $last_question_custom_id;
    }

    public function addNewQuestionLearning($learning_type_question_id, $type_question_id, $question_custom_id, $answer, $keyword) {
        return $this->_readingQuestionLearningModel->addNewQuestionLearning($learning_type_question_id, $type_question_id, $question_custom_id, $answer, $keyword);
    }
}
?>