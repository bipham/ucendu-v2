<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingTypeQuestion extends Model
{
    protected $table = 'reading_type_questions';

    protected $fillable = ['name', 'level_lesson_id', 'tip_guide', 'admin_responsibility', 'status'];

    public $timestamps = true;

    public function levelLesson()
    {
        return $this->belongsTo('App\Models\ReadingLevelLesson', 'level_lesson_id');
    }

    public function learningTypeQuestions()
    {
        return $this->hasMany('App\Models\ReadingLearningTypeQuestion', 'type_question_id');
    }

    public function questionLearnings()
    {
        return $this->hasMany('App\Models\reading_question_learnings', 'type_question_id');
    }

    public function questionLessons()
    {
        return $this->hasMany('App\Models\ReadingQuestionLesson', 'type_question_id');
    }

    public function practiceLessons()
    {
        return $this->hasMany('App\Models\ReadingPracticeLesson', 'type_question_id');
    }

    public function createNewTypeQuestion($name, $level_lesson_id, $tip_guide, $admin_responsibility) {
        if ($this->where('name', $name)->where('level_lesson_id', $level_lesson_id)->exists()) {
            // Record found
            return 'fail';
        }
        else {
            $new_type_question = new ReadingTypeQuestion();
            $new_type_question->name = $name;
            $new_type_question->level_lesson_id = $level_lesson_id;
            $new_type_question->tip_guide = $tip_guide;
            $new_type_question->admin_responsibility = $admin_responsibility;
            $new_type_question->save();
            return 'success';
        }
    }

    public function getAllTypeQuestionById($level_lesson_id) {
        return $this->where('status', 1)->where('level_lesson_id', $level_lesson_id)->select('name', 'id')->get();
    }
}
