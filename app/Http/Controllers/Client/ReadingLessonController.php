<?php

namespace App\Http\Controllers\Client;

use App\Models\ReadingLevelLesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReadingLessonService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

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
        $type_question_id_current = $lesson->type_question_id;
        if ($lesson->typeQuestion->level_lesson_id == $level_lesson_id) {
            return view('client.readingLessonDetail', compact('lesson_id_current', 'level_lesson_id', 'lesson', 'title_current_step', 'type_question_id_current', 'type_lesson_id'));
        }
        else {
            return abort(404);
        }
    }
}