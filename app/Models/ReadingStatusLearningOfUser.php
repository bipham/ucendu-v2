<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReadingStatusLearningOfUser extends Model
{
    protected $table = 'reading_status_learning_of_users';

    protected $fillable = ['user_id', 'level_lesson_id', 'type_question_id', 'type_lesson_id', 'step_current', 'status'];

    public $timestamps = true;

    public function getHighestStepLesson($user_id, $level_lesson_id, $type_question_id, $type_lesson_id) {
        return $this->where('user_id', $user_id)->where('level_lesson_id', $level_lesson_id)->where('type_question_id', $type_question_id)->where('type_lesson_id', $type_lesson_id)->select('step_current')->get()->first();
    }

    public function updateHighestStepLesson($user_id, $level_lesson_id, $type_question_id, $type_lesson_id, $highest_step) {
        return $this->where('user_id', $user_id)->where('level_lesson_id', $level_lesson_id)->where('type_question_id', $type_question_id)->where('type_lesson_id', $type_lesson_id)->update(['step_current' => $highest_step, 'updated_at' => Carbon::now()]);
    }

    public function createNewHighestStepLesson($user_id, $level_lesson_id, $type_question_id, $type_lesson_id, $highest_step) {
        $new_highest_step = new ReadingStatusLearningOfUser();
        $new_highest_step->user_id = $user_id;
        $new_highest_step->level_lesson_id = $level_lesson_id;
        $new_highest_step->type_question_id = $type_question_id;
        $new_highest_step->type_lesson_id = $type_lesson_id;
        $new_highest_step->step_current = $highest_step;
        $new_highest_step->save();
    }
}
