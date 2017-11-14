<?php

namespace App\Http\Controllers\Client;

use App\Models\ReadingLevelLesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReadingLessonService;
use App\Services\ReadingLearningTypeQuestionService;

class ReadingLessonController extends Controller
{
    public function index($domain, $string_level_lesson)
    {
        $level_lesson_id = getIdFromLink($string_level_lesson);
        $title_current_step = ReadingLevelLesson::find($level_lesson_id)->level;
        $type_question_id_current = 0;
        $lesson_id_current = 0;
        $type_lesson_id = -1;
        return view('client.readingOverview', compact('lesson_id_current', 'level_lesson_id', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
    }

    public function readingLessonDetail($domain, $string_level_lesson, $string_type_lesson, $string_lesson) {
        $level_lesson_id = getIdFromLink($string_level_lesson);
        $type_lesson_id = getIdFromLink($string_type_lesson);
        $lesson_id_current = getIdFromLink($string_lesson);
        $readingLessonService = new ReadingLessonService();
        $lesson = $readingLessonService->getLessonDetailForClientTestById($type_lesson_id, $lesson_id_current);
        $title_current_step = $lesson->title;
        if ($type_lesson_id > 2) {
            $type_question_id_current = 0;
        }
        else {
            $type_question_id_current = $lesson->type_question_id;
        }
        switch ($type_lesson_id) {
            case 1:
                if ($lesson->typeQuestion->level_lesson_id == $level_lesson_id) {
                    return view('client.readingLessonDetail', compact('lesson_id_current', 'level_lesson_id', 'lesson', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
                }
                else {
                    return abort(404);
                }
                break;
            case 2:
                if ($lesson->typeQuestion->level_lesson_id == $level_lesson_id) {
                    return view('client.readingLessonDetail', compact('lesson_id_current', 'level_lesson_id', 'lesson', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
                }
                else {
                    return abort(404);
                }
                break;
            case 3:
                if ($lesson->level_lesson_id == $level_lesson_id) {
                    return view('client.readingViewTestDetail', compact('lesson_id_current', 'level_lesson_id', 'lesson', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
                }
                else {
                    return abort(404);
                }
               break;
            case 4:
                return view('client.readingLessonDetail', compact('lesson_id_current', 'level_lesson_id', 'lesson', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
                break;
        }
    }

    public function getReadingViewLearning($domain, $string_level_lesson, $string_learning) {
        $level_lesson_id = getIdFromLink($string_level_lesson);
        $learning_id_current = getIdFromLink($string_learning);
        $readingLearningTypeQuestionService = new ReadingLearningTypeQuestionService();
        $lesson = $readingLearningTypeQuestionService->getLearningDetail($learning_id_current);
        $title_current_step = $lesson->title;
        if ($type_lesson_id > 2) {
            $type_question_id_current = 0;
        }
        else {
            $type_question_id_current = $lesson->type_question_id;
        }
        switch ($type_lesson_id) {
            case 1:
                if ($lesson->typeQuestion->level_lesson_id == $level_lesson_id) {
                    return view('client.readingLessonDetail', compact('lesson_id_current', 'level_lesson_id', 'lesson', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
                }
                else {
                    return abort(404);
                }
                break;
            case 2:
                if ($lesson->typeQuestion->level_lesson_id == $level_lesson_id) {
                    return view('client.readingLessonDetail', compact('lesson_id_current', 'level_lesson_id', 'lesson', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
                }
                else {
                    return abort(404);
                }
                break;
            case 3:
                if ($lesson->level_lesson_id == $level_lesson_id) {
                    return view('client.readingViewTestDetail', compact('lesson_id_current', 'level_lesson_id', 'lesson', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
                }
                else {
                    return abort(404);
                }
                break;
            case 4:
                return view('client.readingLessonDetail', compact('lesson_id_current', 'level_lesson_id', 'lesson', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
                break;
        }
    }
}