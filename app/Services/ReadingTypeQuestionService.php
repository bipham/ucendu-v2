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

    public function createNewTypeQuestion($name, $level_lesson_id) {
        return $this->_readingTypeQuestionModel->createNewTypeQuestion($name, $level_lesson_id, $this->_adminId);
    }

    public function getAllTypeQuestionById($level_lesson_id) {
        return $this->_readingTypeQuestionModel->getAllTypeQuestionById($level_lesson_id);
    }
}
?>