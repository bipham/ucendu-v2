<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingQuestionLesson extends Model
{
    protected $table = 'reading_question_lessons';

    protected $fillable = ['lesson_id', 'type_lesson_id', 'type_question_id', 'question_custom_id', 'answer', 'keyword', 'status'];

    public $timestamps = true;

    public function questionAnswers()
    {
        return $this->hasMany('App\Models\ReadingQuestionAndAnswerLesson.php', 'question_custom_id', 'question_custom_id');
    }

    public function typeQuestion()
    {
        return $this->belongsTo('App\Models\ReadingTypeQuestion', 'type_question_id');
    }

    public function practiceLesson()
    {
        return $this->belongsTo('App\Models\ReadingPracticeLesson', 'lesson_id');
    }

    public function miniTest()
    {
        return $this->belongsTo('App\Models\ReadingMiniTestLesson', 'lesson_id');
    }

    public function mixTest()
    {
        return $this->belongsTo('App\Models\ReadingMixTestLesson', 'lesson_id');
    }

    public function fullTest()
    {
        return $this->belongsTo('App\Models\ReadingFullTestLesson', 'lesson_id');
    }

    public function typeLesson()
    {
        return $this->belongsTo('App\Models\ReadingTypeLesson', 'type_lesson_id');
    }

    public function getTheLastQuestionCustomId() {
        return $this->orderBy('question_custom_id', 'desc')->first();
    }

    public function addNewQuestionLesson($type_lesson_id, $lesson_id, $type_question_id, $question_custom_id, $answer, $keyword) {
        if ($this->where('question_custom_id', $question_custom_id)->exists()) {
            $this->where('question_custom_id', $question_custom_id)
                ->update(['answer' => $answer, 'keyword' => $keyword, 'updated_at' => Carbon::now()]);
            return 'update-success';
        }
        else {
            $new_question_learning = new ReadingQuestionLesson();
            $new_question_learning->lesson_id = $lesson_id;
            $new_question_learning->type_lesson_id = $type_lesson_id;
            $new_question_learning->type_question_id = $type_question_id;
            $new_question_learning->question_custom_id = $question_custom_id;
            $new_question_learning->question_custom_id = $question_custom_id;
            $new_question_learning->answer = $answer;
            $new_question_learning->keyword = $keyword;
            $new_question_learning->save();
            return 'success';
        }
    }

    public function deleteQuestionLesson($type_lesson_id, $lesson_id, $question_custom_id) {
        $this-> where('lesson_id', $lesson_id)
             -> where('type_lesson_id', $type_lesson_id)
             -> where('question_custom_id', $question_custom_id)
             -> delete();
    }

    public function getAnswerExtractlyOfQuestion($question_custom_id) {
        return $this->where('question_custom_id', $question_custom_id)->select('answer')->get()->first();
    }

    public function getExplanation($question_custom_id) {
        return $this->where('question_custom_id', $question_custom_id)->select('keyword')->get()->first();
    }
}
