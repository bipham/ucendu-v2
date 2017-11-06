<?php namespace App\Services;

use App\Models\ReadingLevelLesson;
use Illuminate\Support\Facades\Auth;

class ReadingLevelLessonService {
    private $_readingLevelLessonModel;
    private $_adminId;

    public function __construct()
    {
        $this->_readingLevelLessonModel = new ReadingLevelLesson();
        $this->_adminId = Auth::id();
    }

    public function createNewLevelLesson($level) {
        return $this->_readingLevelLessonModel->createNewLevelLesson($level, $this->_adminId);
    }

    public function getAllLevelLesson() {
        return $this->_readingLevelLessonModel->getAllLevelLesson();
    }

    public function getFirstLevelLesson() {
        return $this->_readingLevelLessonModel->getFirstLevelLesson();
    }

    public function getLevelLessonById($level_lesson_id) {
        return $this->_readingLevelLessonModel->getLevelLessonById($level_lesson_id);
    }
}
?>



