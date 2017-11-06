<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReadingLevelLessonService;
use App\Services\ReadingTypeQuestionService;
use App\Services\ReadingQuestionLearningService;
use App\Services\ReadingLearningTypeQuestionService;

class ReadingLearningTypeQuestionController extends Controller
{
    public function getCreateNewLearningTypeQuestion($domain) {
        $readingLevelLessonService = new ReadingLevelLessonService();
        $all_levels = $readingLevelLessonService->getAllLevelLesson();
        $first_level_lesson_id = $readingLevelLessonService->getFirstLevelLesson();
        $readingTypeQuestionService = new ReadingTypeQuestionService();
        $all_type_questions = $readingTypeQuestionService->getAllTypeQuestionById($first_level_lesson_id->id);
        $readingQuestionLearningService = new ReadingQuestionLearningService();
        $last_question_custom_id = $readingQuestionLearningService->getTheLastQuestionCustomId();
        return view('admin.readingCreateNewLearningTypeQuestion', compact('all_type_questions', 'all_levels', 'last_question_custom_id'));
    }

    public function postCreateNewLearningTypeQuestion($domain) {
        $type_question_id = $_POST['type_question_id'];
        $title_section = $_POST['title_section'];
        $name_icon_section = $_POST['name_icon_section'];
        if ($name_icon_section == '') {
            $name_icon_section = 'fa-cog';
        }
        $content_section = $_POST['content_section'];
        $left_section = $_POST['left_section'];
        $right_section = $_POST['right_section'];
        $step_section = $_POST['step_section'];
        $view_layout = $_POST['view_layout'];
        $list_answer = $_POST['list_answer'];
        $list_type_questions = $_POST['list_type_questions'];
        $listKeyword = $_POST['listKeyword'];
        $readingLearningTypeQuestionService = new ReadingLearningTypeQuestionService();
        $result = $readingLearningTypeQuestionService->createNewLearningTypeQuestion($type_question_id, $title_section, $step_section, $view_layout, $name_icon_section, $content_section, $left_section, $right_section);
        if ($list_answer != 'null') {
            if ($result != 'fail-title' || $result != 'fail-step') {
                $learning_type_question_id = $result;
                foreach ($list_answer as $question_custom_id => $answer) {
                    $readingQuestionLearningService = new ReadingQuestionLearningService();
                    $readingQuestionLearningService->addNewQuestionLearning($learning_type_question_id, $type_question_id, $question_custom_id, $answer, $listKeyword[$question_custom_id]);
                }
            }
        }
        return json_encode(['result' => $result]);
    }
}
