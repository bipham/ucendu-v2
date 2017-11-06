<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReadingLevelLessonService;
use App\Services\ReadingTypeQuestionService;
use Illuminate\Support\Facades\Input;

class ReadingTypeQuestionController extends Controller
{
    public function getCreateNewTypeQuestion($domain) {
        $readingLevelLessonService = new ReadingLevelLessonService();
        $all_level_lessons = $readingLevelLessonService->getAllLevelLesson();
        return view('admin.readingCreateNewTypeQuestion', compact('all_level_lessons'));
    }

    public function postCreateNewTypeQuestion($domain) {
        $name = Input::get('name');
        $level_lesson_id = Input::get('level_lesson');
        if (!$name || !$level_lesson_id) {
            $message = ['flash_level'=>'danger message-custom','flash_message'=>'Please fill all input!'];
        }
        else {
            $readingTypeQuestionService = new ReadingTypeQuestionService();
            $result = $readingTypeQuestionService->createNewTypeQuestion($name, $level_lesson_id);
            if ($result == 'success') {
                $message = ['flash_level'=>'success message-custom','flash_message'=>'Create new type question success!'];
            }
            else {
                $message = ['flash_level'=>'danger message-custom','flash_message'=>'This type question is not available!'];
            }
        }
        return redirect('createNewTypeQuestion')->with($message);
    }

    public function getTypeQuestionByLevelLessonId($domain) {
        $level_lesson_id = $_GET['level_lesson_id'];
        $readingTypeQuestionService = new ReadingTypeQuestionService();
        $all_type_questions = $readingTypeQuestionService->getAllTypeQuestionById($level_lesson_id);
        return json_encode(['list_type_questions' => $all_type_questions]);
    }
}
