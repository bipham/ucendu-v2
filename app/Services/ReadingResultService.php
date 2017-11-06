<?php namespace App\Services;

use App\Models\ReadingResultLesson;
use App\Models\ReadingQuestionLesson;
use App\Models\ReadingQuestionLearning;
use App\Models\ReadingStatusLearningOfUser;
use Illuminate\Support\Facades\Auth;

class ReadingResultService
{
    private $_readingResultLessonModel;
    private $_readingQuestionLessonModel;
    private $_readingQuestionLearningModel;
    private $_readingStatusLearningOfUsergModel;
    private $_adminId;

    public function __construct()
    {
        $this->_readingResultLessonModel = new ReadingResultLesson();
        $this->_readingQuestionLessonModel = new ReadingQuestionLesson();
        $this->_readingQuestionLearningModel = new ReadingQuestionLearning();
        $this->_readingStatusLearningOfUsergModel = new ReadingStatusLearningOfUser();
        $this->_adminId = Auth::id();
    }

    public function getResultLesson($type_lesson_id, $lesson_id, $list_answered)
    {
        $correct_answer = [];
        $list_answered_string = '';
        $correct_answer_string = '';
        if ($type_lesson_id == 0) {

        }
        else {
            if ($list_answered != 'emptyList') {
                foreach ($list_answered as $question_custom_id => $answer_key) {
                    $list_answered_string .= $question_custom_id . '-' . $answer_key . '|';
                    $answer_extractly = $this->_readingQuestionLessonModel->getAnswerExtractlyOfQuestion($question_custom_id);
                    $isCorrect = checkAnswerByIdCustom($answer_key, $answer_extractly['answer']);
                    if ($isCorrect) {
                        array_push($correct_answer, $question_custom_id);
                        $correct_answer_string .= $question_custom_id . '|';
                    }
                }
                $number_correct = sizeof($correct_answer);
            }
            else {
                $number_correct = 0;
            }
        }

        //Save DB:
        $this->_readingResultLessonModel->saveReadingResultOfUserId($this->_adminId, $lesson_id, $type_lesson_id, $correct_answer_string, $list_answered_string, $number_correct);
        return $correct_answer;
    }

    public function getHighestScoreLesson($type_lesson_id, $lesson_id) {
        return $highest_score = $this->_readingResultLessonModel->getHighestScorePracticeLesson($this->_adminId, $type_lesson_id, $lesson_id);
    }
}
?>