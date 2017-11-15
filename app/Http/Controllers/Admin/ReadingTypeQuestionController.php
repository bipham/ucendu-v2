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
        $name = $_POST['name_type_question'];
        $level_lesson_id = $_POST['level_lesson_selected'];
        $tip_guide = $_POST['tip_guide'];
        if (!$name || !$level_lesson_id) {
            $message = 'Please fill all input!';
            $result = 'fail';
        }
        else {
            $readingTypeQuestionService = new ReadingTypeQuestionService();
            $result = $readingTypeQuestionService->createNewTypeQuestion($name, $level_lesson_id, $tip_guide);
            if ($result == 'success') {
                $message = 'Create new type question success!';
            }
            else {
                $message = 'This type question is not available!';
            }
        }
        return json_encode(['result' => $result, 'message' => $message]);
    }

    public function getTypeQuestionByLevelLessonId($domain) {
        $level_lesson_id = $_GET['level_lesson_id'];
        $readingTypeQuestionService = new ReadingTypeQuestionService();
        $all_type_questions = $readingTypeQuestionService->getAllTypeQuestionById($level_lesson_id);
        return json_encode(['list_type_questions' => $all_type_questions]);
    }

    public function managerTypeQuestion($domain) {
        $readingTypeQuestionService = new ReadingTypeQuestionService();
        $all_type_questions = $readingTypeQuestionService->getAllTypeQuestion();
        return view('admin.readingManagerTypeQuestion', compact('all_type_questions'));
    }

    public function getEditTypeQuestion($domain, $type_question_id) {
        $readingTypeQuestionService = new ReadingTypeQuestionService();
        $readingLevelLessonService = new ReadingLevelLessonService();
        $all_level_lessons = $readingLevelLessonService->getAllLevelLesson();
        $type_question = $readingTypeQuestionService->getDetailTypeQuestion($type_question_id);
        return view('admin.readingEditTypeQuestion',compact('type_question', 'all_level_lessons'));
    }

    public function updateTypeQuestion($domain, $type_question_id) {
        $name = $_POST['name_type_question'];
        $level_lesson_id = $_POST['level_lesson_selected'];
        $tip_guide = $_POST['tip_guide'];
        if (!$name || !$level_lesson_id) {
            $message = 'Please fill all input!';
            $result = 'fail';
        }
        else {
            $readingTypeQuestionService = new ReadingTypeQuestionService();
            $result = $readingTypeQuestionService->updateTypeQuestion($name, $level_lesson_id, $tip_guide, $type_question_id);
            if ($result == 'success') {
                $message = 'Update type question success!';
            }
            else {
                $message = 'Update type question fail in save db!';
            }
        }
        return json_encode(['result' => $result, 'message' => $message]);
    }
}
