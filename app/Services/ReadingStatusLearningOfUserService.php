<?php namespace App\Services;

use App\Models\ReadingStatusLearningOfUser;
use Illuminate\Support\Facades\Auth;

class ReadingStatusLearningOfUserService
{
    private $_readingStatusLearningOfUserModel;
    private $_adminId;

    public function __construct()
    {
        $this->_readingStatusLearningOfUserModel = new ReadingStatusLearningOfUser();
        $this->_adminId = Auth::id();
    }

    public function checkNextStepLesson($level_lesson_id, $type_lesson_id, $type_question_id, $correct_answer, $total_questions, $step_lesson_current) {
        if (sizeof($correct_answer) >= ($total_questions/2)) {
            $highest_step = $this->_readingStatusLearningOfUserModel->getHighestStepLesson($this->_adminId, $level_lesson_id, $type_question_id, $type_lesson_id);
            if ($highest_step == null) {
                $this->_readingStatusLearningOfUserModel->createNewHighestStepLesson($this->_adminId, $level_lesson_id, $type_question_id, $type_lesson_id, $step_lesson_current + 1);
            }
            elseif ($step_lesson_current == $highest_step['step_current']) {
                $this->_readingStatusLearningOfUserModel->updateHighestStepLesson($this->_adminId, $level_lesson_id, $type_question_id, $type_lesson_id, $step_lesson_current + 1);
            }
        }
    }

    public function getHighestStepLessonService($level_lesson_id, $type_question_id, $type_lesson_id) {
        $highest_step = $this->_readingStatusLearningOfUserModel->getHighestStepLesson($this->_adminId, $level_lesson_id, $type_question_id, $type_lesson_id);
        if ($highest_step == null) {
            $highest_step = 1;
        }
        else {
            $highest_step = $highest_step['step_current'];
        }
        return $highest_step;
    }
}
?>