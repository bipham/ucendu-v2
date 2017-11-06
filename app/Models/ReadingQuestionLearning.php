<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReadingQuestionLearning extends Model
{
    protected $table = 'reading_question_learnings';

    protected $fillable = ['learning_type_question_id', 'type_question_id', 'question_custom_id', 'answer', 'keyword', 'status'];

    public $timestamps = true;

    public function learningTypeQuestion()
    {
        return $this->belongsTo('App\Models\ReadingLearningTypeQuestion', 'learning_type_question_id');
    }

    public function typeQuestion()
    {
        return $this->belongsTo('App\Models\ReadingTypeQuestion', 'type_question_id');
    }

    public function getTheLastQuestionCustomId() {
        return $this->orderBy('question_custom_id', 'desc')->first();
    }

    public function addNewQuestionLearning($learning_type_question_id, $type_question_id, $question_custom_id, $answer, $keyword) {
        if ($this->where('question_custom_id', $question_custom_id)->exists()) {
            $this   ->where('question_custom_id', $question_custom_id)
                    ->update(['answer' => $answer, 'keyword' => $keyword, 'updated_at' => Carbon::now()]);
        }
        else {
            $new_question_learning = new ReadingQuestionLearning();
            $new_question_learning->learning_type_question_id = $learning_type_question_id;
            $new_question_learning->type_question_id = $type_question_id;
            $new_question_learning->question_custom_id = $question_custom_id;
            $new_question_learning->answer = $answer;
            $new_question_learning->keyword = $keyword;
            $new_question_learning->save();
            return 'success';
        }
    }
}
