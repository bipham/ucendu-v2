<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReadingTypeQuestionDetailOfLesson extends Model
{
    protected $table = 'reading_type_question_detail_of_lessons';

    protected $fillable = ['lesson_id', 'type_lesson_id', 'type_question_id', 'total_questions_of_type', 'status'];

    public $timestamps = true;

    public function createNewTypeQuestionDetail($lesson_id, $type_lesson_id, $type_question_id) {
        if ($this->where('lesson_id', $lesson_id)->where('type_lesson_id', $type_lesson_id)->where('type_question_id', $type_question_id)->exists()) {
            $total_questions = $this->where('lesson_id', $lesson_id)->where('type_lesson_id', $type_lesson_id)->where('type_question_id', $type_question_id)->select('total_questions_of_type')->get()->first();
            $new_total_questions = $total_questions['total_questions_of_type'] + 1;
            $this->where('lesson_id', $lesson_id)->where('type_lesson_id', $type_lesson_id)->where('type_question_id', $type_question_id)-> update(['total_questions_of_type' => $new_total_questions, 'updated_at' => Carbon::now()]);
        }
        else {
            $new_detail_question = new ReadingTypeQuestionDetailOfLesson();
            $new_detail_question->lesson_id = $lesson_id;
            $new_detail_question->type_lesson_id = $type_lesson_id;
            $new_detail_question->type_question_id = $type_question_id;
            $new_detail_question->total_questions_of_type = 1;
            $new_detail_question->save();
        }
    }
}
