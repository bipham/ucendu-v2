<?php namespace App\Services;

use App\Models\ReadingMixTestLesson;
use Illuminate\Support\Facades\Auth;

class ReadingMixTestService {
    private $_readingMixTestLessonModel;

    private $_userId;

    public function __construct()
    {
        $this->_readingMixTestLessonModel = new ReadingMixTestLesson();
        $this->_userId = Auth::id();
    }

    public function getAllMixTestLessons($level_lesson_id) {
        return $this->_readingMixTestLessonModel->getAllMixTestLessons($level_lesson_id);
    }
}
?>