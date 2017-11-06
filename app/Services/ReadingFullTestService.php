<?php namespace App\Services;

use App\Models\ReadingFullTestLesson;
use App\Models\ReadingParagraphOfFullTest;
use Illuminate\Support\Facades\Auth;

class ReadingFullTestService
{
    private $_readingFullTestLessonModel;
    private $_readingParagraphOfFullTestModel;
    private $_adminId;

    public function __construct()
    {
        $this->_readingFullTestLessonModel = new ReadingFullTestLesson();
        $this->_readingParagraphOfFullTestModel = new ReadingParagraphOfFullTest();
        $this->_adminId = Auth::id();
    }

    public function getListFullTestLessonUploaded($level_lesson_id) {
        return $this->_readingFullTestLessonModel->getListFullTestLessonUploaded($level_lesson_id);
    }

    public function getAllOrderParagraphOfFullTest($full_test_id) {
        return $this->_readingParagraphOfFullTestModel->getAllOrderParagraphOfFullTest($full_test_id);
    }

    public function createNewFullTest($title, $level_lesson_id, $level_user_id, $order_lesson, $limit_time) {
        return $this->_readingFullTestLessonModel->addNewFullTest($title, $level_lesson_id, $level_user_id, $order_lesson, $limit_time, $this->_adminId);
    }
}
?>