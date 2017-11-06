<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingLearningTypeQuestion extends Model
{
    protected $table = 'reading_learning_type_questions';

    protected $fillable = ['type_question_id', 'step_section', 'title_section', 'view_layout', 'icon', 'content_section', 'left_content', 'right_content', 'admin_responsibility', 'status'];

    public $timestamps = true;

    public function typeQuestion()
    {
        return $this->belongsTo('App\Models\ReadingTypeQuestion', 'type_question_id');
    }

    public function questionLearnings()
    {
        return $this->hasMany('App\Models\reading_question_learnings', 'learning_type_question_id');
    }

    public function getLearningOfTypeQuestion($type_question_id) {
        return $this->where('status', 1)->where('type_question_id', $type_question_id)->orderBy('step_section', 'asc')->select('title_section', 'icon', 'step_section')->get()->all();
    }

    public function createNewLearningTypeQuestion ($type_question_id, $title_section, $step_section, $view_layout, $icon, $content_section, $left_content, $right_content, $admin_responsibility) {
        if ($this->where('type_question_id', $type_question_id)->where('title_section', $title_section)->exists()) {
            // level found
            return 'fail-title';
        }
        else if ($this->where('type_question_id', $type_question_id)->where('step_section', $step_section)->exists()) {
            return 'fail-step';
        }
        else {
            $new_learning_type_question = new ReadingLearningTypeQuestion();
            $new_learning_type_question->type_question_id = $type_question_id;
            $new_learning_type_question->title_section = $title_section;
            $new_learning_type_question->step_section = $step_section;
            $new_learning_type_question->view_layout = $view_layout;
            $new_learning_type_question->left_content = $left_content;
            $new_learning_type_question->right_content = $right_content;
            $new_learning_type_question->icon = $icon;
            $new_learning_type_question->content_section = $content_section;
            $new_learning_type_question->admin_responsibility = $admin_responsibility;
            $new_learning_type_question->save();
            return $new_learning_type_question->id;
        }
    }
}
