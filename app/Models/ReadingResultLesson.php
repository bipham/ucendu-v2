<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReadingResultLesson extends Model
{
    protected $table = 'reading_result_lessons';

    protected $fillable = ['user_id', 'lesson_id', 'type_lesson_id', 'correct_answer', 'list_answered', 'highest_correct'];

    public $timestamps = true;

    public function saveReadingResultOfUserId($user_id, $lesson_id, $type_question_id, $correct_answer, $list_answered, $number_correct) {
        if ($this->where('user_id', $user_id)->where('lesson_id', $lesson_id)->where('type_lesson_id', $type_question_id)->exists()) {
            $highest_result = $this->where('user_id', $user_id)->where('lesson_id', $lesson_id)->where('type_lesson_id', $type_question_id)->select('highest_correct')->get()->first();
            if ($number_correct >= $highest_result['highest_correct']) {
                $this->where('user_id', $user_id)->where('lesson_id', $lesson_id)->where('type_lesson_id', $type_question_id)-> update(['correct_answer' => $correct_answer, 'list_answered' => $list_answered, 'highest_correct' => $number_correct, 'updated_at' => Carbon::now()]);
            }
            return 'update-success';
        }
        else {
            $new_result = new ReadingResultLesson();
            $new_result->user_id = $user_id;
            $new_result->lesson_id = $lesson_id;
            $new_result->type_lesson_id = $type_question_id;
            $new_result->correct_answer = $correct_answer;
            $new_result->list_answered = $list_answered;
            $new_result->highest_correct = $number_correct;
            $new_result->save();
            return 'success';
        }
    }

    public function getHighestScorePracticeLesson($user_id, $type_lesson_id, $lesson_id) {
        return $this->where('user_id', $user_id)->where('type_lesson_id', $type_lesson_id)->where('lesson_id', $lesson_id)->select('highest_correct', 'correct_answer')->get()->first();
    }
}
