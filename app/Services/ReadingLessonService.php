<?php namespace App\Services;

use App\Models\ReadingPracticeLesson;
use App\Models\ReadingMiniTestLesson;
use App\Models\ReadingMixTestLesson;
use App\Models\ReadingFullTestLesson;
use App\Models\ReadingParagraphOfFullTest;
use Illuminate\Support\Facades\Auth;

class ReadingLessonService {
    private $_readingPracticeLessonModel;
    private $_readingMiniTestLessonModel;
    private $_readingMixTestLessonModel;
    private $_readingFullTestLessonModel;
    private $_readingParagraphOfFullTestModel;
    private $_adminId;
    private $_levelUser;

    public function __construct()
    {
        $this->_readingPracticeLessonModel = new ReadingPracticeLesson();
        $this->_readingMiniTestLessonModel = new ReadingMiniTestLesson();
        $this->_readingMixTestLessonModel = new ReadingMixTestLesson();
        $this->_readingFullTestLessonModel = new ReadingFullTestLesson();
        $this->_readingParagraphOfFullTestModel = new ReadingParagraphOfFullTest();
        $this->_adminId = Auth::id();
        $this->_levelUser = Auth::user()->level_user_id;
    }

    public function getTheLastLessonId($type_lesson_id) {
        switch ($type_lesson_id) {
            case 1:
                $last_lesson = $this->_readingPracticeLessonModel->getTheLastLessonId();
                break;
            case 2:
                $last_lesson = $this->_readingMiniTestLessonModel->getTheLastLessonId();
                break;
            case 3:
                $last_lesson = $this->_readingMixTestLessonModel->getTheLastLessonId();
                break;
            case 4:
                $last_lesson = $this->_readingFullTestLessonModel->getTheLastLessonId();
                break;
        }
        if (!$last_lesson) {
            $last_lesson_id = 1;
        }
        else {
            $last_lesson_id = $last_lesson->id + 1;
        }
        return $last_lesson_id;
    }

    public function addNewReadingLesson($level_lesson_id, $full_test_id, $order_paragraph, $type_lesson_id, $title, $level_user_id, $content_lesson, $content_highlight, $image_feature, $content_quiz, $content_answer_quiz, $total_questions, $order_lesson, $type_question_id, $limit_time) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->addNewPracticeLesson($title, $level_user_id, $content_lesson, $content_highlight, $image_feature, $content_quiz, $content_answer_quiz, $total_questions, $order_lesson, $type_question_id, $this->_adminId);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->addNewMiniTest($title, $level_user_id, $content_lesson, $content_highlight, $image_feature, $content_quiz, $content_answer_quiz, $total_questions, $order_lesson, $type_question_id, $limit_time, $this->_adminId);
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->addNewMixTest($level_lesson_id, $title, $level_user_id, $content_lesson, $content_highlight, $image_feature, $content_quiz, $content_answer_quiz, $total_questions, $order_lesson, $limit_time, $this->_adminId);
                break;
            case 4:
                $number_paragraphs = $this->_readingFullTestLessonModel->getNumberParagraphOfFullTest($full_test_id);
                $number_paragraphs = $number_paragraphs['number_paragraphs'] + 1;
                $this->_readingFullTestLessonModel->updateNumberParagraphsOfFullTest($full_test_id, $number_paragraphs);
                $this->_readingParagraphOfFullTestModel->createNewParagraph($full_test_id, $content_lesson, $content_highlight, $content_quiz, $content_answer_quiz, $order_paragraph, $this->_adminId);
                $result = $full_test_id;
                break;
        }
        return $result;
    }

    public function getAllLesson() {
        $lesson['practice'] = $this->_readingPracticeLessonModel->getAllPracticeLesson();
        $lesson['mini_test'] = $this->_readingMiniTestLessonModel->getAllMiniTest();
        return $lesson;
    }

    public function getAllOrderLessonByTypeQuestionId($type_lesson_id, $type_question_id) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->getAllOrderPracticeLessonByTypeQuestionId($type_question_id);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getAllOrderMiniTestByTypeQuestionId($type_question_id);
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getAllOrderMixTestByLevelLessonId($type_question_id);
                break;
            case 4:
                $result = $this->_readingFullTestLessonModel->getAllOrderFullTestByLevelLessonId($type_question_id);
                break;
        }
        return $result;
    }

    public function updateTitleLesson($type_lesson_id, $lesson_id, $title) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->updateTitlePracticeLesson($lesson_id, $title, $this->_adminId);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getTheLastLessonId();
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getTheLastLessonId();
                break;
            case 4:
                $result = $this->_readingFullTestLessonModel->getTheLastLessonId();
                break;
        }
        return $result;
    }

    public function updateLevelUserLesson($type_lesson_id, $lesson_id, $level_user_id) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->updateLevelUserPracticeLesson($lesson_id, $level_user_id, $this->_adminId);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getTheLastLessonId();
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getTheLastLessonId();
                break;
            case 4:
                $result = $this->_readingFullTestLessonModel->getTheLastLessonId();
                break;
        }
        return $result;
    }

    public function updateBasicInfoLesson($type_lesson_id, $lesson_id, $type_question_id, $order_lesson) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->updateBasicInfoPracticeLesson($lesson_id, $type_question_id, $order_lesson, $this->_adminId);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getTheLastLessonId();
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getTheLastLessonId();
                break;
            case 4:
                $result = $this->_readingFullTestLessonModel->getTheLastLessonId();
                break;
        }
        return $result;
    }

    public function getLessonDetailForAdminById($type_lesson_id, $lesson_id) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->getDetailPracticeLessonForAdminEdit($lesson_id);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getTheLastLessonId();
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getTheLastLessonId();
                break;
            case 4:
                $result = $this->_readingFullTestLessonModel->getTheLastLessonId();
                break;
        }
        return $result;
    }

    public function getLessonDetailForClientTestById($type_lesson_id, $lesson_id) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->getDetailPracticeLessonForClientTest($lesson_id);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getDetailMiniTestForClientTest($lesson_id);
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getDetailMixTestForClientTest($lesson_id);
                break;
            case 4:
                $result['lesson_detail'] = $this->_readingFullTestLessonModel->getDetailFullTestForClient($lesson_id);
                $result['paragraph_detail'] = $this->_readingParagraphOfFullTestModel->getDetailParagraphForClientTest($lesson_id);
                break;
        }
        return $result;
    }

    public function getLessonDetailForClientSolutionById($type_lesson_id, $lesson_id) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->getDetailPracticeLessonForClientSolution($lesson_id);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getDetailMiniTestForClientSolution($lesson_id);
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getDetailMixTestForClientSolution($lesson_id);
                break;
            case 4:
                $result['lesson_detail'] = $this->_readingFullTestLessonModel->getDetailFullTestForClient($lesson_id);
                $result['paragraph_detail'] = $this->_readingParagraphOfFullTestModel->getDetailParagraphForClientSolution($lesson_id);
                break;
        }
        return $result;
    }

    public function updateContentLesson($type_lesson_id, $lesson_id, $content_lesson, $content_highlight) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->updateContentPracticeLesson($lesson_id, $content_lesson, $content_highlight, $this->_adminId);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getTheLastLessonId();
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getTheLastLessonId();
                break;
            case 4:
                $result = $this->_readingFullTestLessonModel->getTheLastLessonId();
                break;
        }
        return $result;
    }

    public function updateQuizLesson($type_lesson_id, $lesson_id, $content_highlight, $content_quiz, $content_answer_quiz, $total_questions) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->updateQuizPracticeLesson($lesson_id, $content_highlight, $content_quiz, $content_answer_quiz, $total_questions, $this->_adminId);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getTheLastLessonId();
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getTheLastLessonId();
                break;
            case 4:
                $result = $this->_readingFullTestLessonModel->getTheLastLessonId();
                break;
        }
        return $result;
    }

    public function getLessonsByTypeQuestionId($type_lesson_id, $type_question_id) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->getPracticesByTypeQuestionId($type_question_id);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getMiniTestByTypeQuestionId($type_question_id);
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getTheLastLessonId();
                break;
            case 4:
                $result = $this->_readingFullTestLessonModel->getTheLastLessonId();
                break;
        }
        return $result;
    }

    public function deleteLesson($type_lesson_id, $lesson_id) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->deletePracticeLesson($lesson_id);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getTheLastLessonId();
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getTheLastLessonId();
                break;
            case 4:
                $result = $this->_readingFullTestLessonModel->getTheLastLessonId();
                break;
        }
        return $result;
    }

    public function getTotalQuestionByLessonId($type_lesson_id, $lesson_id) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->getTotalQuestionOfPracticeLesson($lesson_id);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getTotalQuestionOfMiniTestLesson($lesson_id);
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getTotalQuestionOfMixTestLesson($lesson_id);
                break;
            case 4:
                $result = $this->_readingFullTestLessonModel->getTotalQuestionOfFullTestLesson($lesson_id);
                break;
        }
        return $result['total_questions'];
    }

    public function getCurrentStepOfLesson($type_lesson_id, $lesson_id) {
        switch ($type_lesson_id) {
            case 1:
                $result = $this->_readingPracticeLessonModel->getCurrentStepOfPracticeLesson($lesson_id);
                break;
            case 2:
                $result = $this->_readingMiniTestLessonModel->getTheLastLessonId();
                break;
            case 3:
                $result = $this->_readingMixTestLessonModel->getTheLastLessonId();
                break;
            case 4:
                $result = $this->_readingFullTestLessonModel->getTheLastLessonId();
                break;
        }
        return $result['order_lesson'];
    }

    public function checkVipLesson($type_lesson_id, $lesson_id) {
        switch ($type_lesson_id) {
            case 1:
                $level_user_of_lesson = $this->_readingPracticeLessonModel->checkVipPracticeLesson($lesson_id);
                break;
            case 2:
                $level_user_of_lesson = $this->_readingMiniTestLessonModel->checkVipMiniTestLesson($lesson_id);
                break;
            case 3:
                $level_user_of_lesson = $this->_readingMixTestLessonModel->getTheLastLessonId();
                break;
            case 4:
                $level_user_of_lesson = $this->_readingFullTestLessonModel->getTheLastLessonId();
                break;
        }
        if ($this->_levelUser != 1 && $level_user_of_lesson['level_user_id'] > $this->_levelUser) {
            return true;
        }
        else return false;
    }
}
?>