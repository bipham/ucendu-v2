<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReadingLessonService;
use App\Services\ReadingResultService;
use App\Services\ReadingStatusLearningOfUserService;
use App\Services\ReadingQuestionLessonService;
use App\Services\ReadingQuestionAnswerLessonService;
use App\Services\UcenduUserService;

class ReadingResultController extends Controller
{
    //Ajax function get result after user submit:
    public function getResultReadingLesson($domain, $level_lesson_id, $type_lesson_id, $lesson_id) {
        $list_answered = $_GET['list_answer'];
        $readingResultService = new ReadingResultService();
        $readingLessonService = new ReadingLessonService();
        //Get correct answer:
        $total_questions = $readingLessonService->getTotalQuestionByLessonId($type_lesson_id, $lesson_id);
        $correct_answer = $readingResultService->getResultLesson($type_lesson_id, $lesson_id, $list_answered);
        return json_encode(['correct_answer' => $correct_answer, 'total_questions' => $total_questions]);
    }

    public function getReadingViewResultLesson($domain, $string_level_lesson, $string_type_lesson, $string_lesson) {
        //Get para:
        $level_lesson_id = getIdFromLink($string_level_lesson);
        $type_lesson_id = getIdFromLink($string_type_lesson);
        $lesson_id_current = getIdFromLink($string_lesson);
        if (!empty($_GET)) {
            $total_questions = $_GET['total_questions'];
            $correct_answer = $_GET['correct_answer'];
            $list_answer = $_GET['list_answer'];
        }
        else {
            $total_questions = 0;
            $correct_answer = [];
            $list_answer = [];
        }
        $correct_answer = json_decode($correct_answer);
        $list_answer = json_decode($list_answer);
        $readingLessonService = new ReadingLessonService();
        $readingStatusLearningOfUserService = new ReadingStatusLearningOfUserService();
        $lesson = $readingLessonService->getLessonDetailForClientSolutionById($type_lesson_id, $lesson_id_current);
        $step_lesson_current = $readingLessonService->getCurrentStepOfLesson($type_lesson_id, $lesson_id_current);
        if ($type_lesson_id > 2) {
            $type_question_id_current = 0;
        }
        else {
            $type_question_id_current = $lesson->type_question_id;
        }
        $readingStatusLearningOfUserService->checkNextStepLesson($level_lesson_id, $type_lesson_id, $type_question_id_current, $correct_answer, $total_questions, $step_lesson_current);

        $title_current_step = $lesson->title;
        if ($lesson->typeQuestion->level_lesson_id == $level_lesson_id) {
            return view('client.readingViewResultLesson', compact('lesson_id_current', 'level_lesson_id', 'lesson', 'correct_answer', 'total_questions', 'list_answer', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
        }
        else {
            return abort(404);
        }
    }

    public function getReadingViewSolutionLesson($domain, $string_level_lesson, $string_type_lesson, $string_lesson) {
        //Get para:
        $level_lesson_id = getIdFromLink($string_level_lesson);
        $type_lesson_id = getIdFromLink($string_type_lesson);
        $lesson_id_current = getIdFromLink($string_lesson);
        $readingLessonService = new ReadingLessonService();
        $lesson = $readingLessonService->getLessonDetailForClientSolutionById($type_lesson_id, $lesson_id_current);
        $title_current_step = $lesson->title;
        $type_question_id_current = $lesson->type_question_id;
        if ($lesson->typeQuestion->level_lesson_id == $level_lesson_id) {
            return view('client.readingViewSolutionLesson', compact('lesson_id_current', 'level_lesson_id', 'lesson', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
        }
        else {
            return abort(404);
        }
    }

    //Ajax get comments + explanation:
    public function getExplanation($domain, $question_custom_id) {
        $readingQuestionLessonService = new ReadingQuestionLessonService();
        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
        $ucenduUserService = new UcenduUserService();

        //Get explanation:
        $explanation = $readingQuestionLessonService->getExplanation($question_custom_id);

        //Get comments:
        $list_comments = $readingQuestionAnswerLessonService->getAllCommentsOfQuestion($question_custom_id);

        $current_user_info = $ucenduUserService->getLevelCurrentUser();

        return json_encode(['explanation' => $explanation, 'list_comments' => $list_comments, 'current_user_info' => $current_user_info]);
    }
}
