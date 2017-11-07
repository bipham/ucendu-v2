<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingLevelLesson extends Model
{
    protected $table = 'reading_level_lessons';

    protected $fillable = ['level', 'admin_responsibility', 'status'];

    public $timestamps = true;

    public function typeQuestions()
    {
        return $this->hasMany('App\Models\ReadingTypeQuestion', 'level_lesson_id');
    }

    public function mixTests()
    {
        return $this->hasMany('App\Models\ReadingMixTestLesson', 'level_lesson_id');
    }

    public function fullTests()
    {
        return $this->hasMany('App\Models\ReadingFullTestLesson', 'level_lesson_id');
    }

    public function createNewLevelLesson($level, $admin_responsibility) {
        if ($this->where('level', '=', $level)->exists()) {
            // level found
            return 'fail';
        }
        else {
            $new_level_lesson = new ReadingLevelLesson();
            $new_level_lesson->level = $level;
            $new_level_lesson->admin_responsibility = $admin_responsibility;
            $new_level_lesson->save();
            return 'success';
        }
    }

    public function getAllLevelLesson() {
        return $this->where('status', 1)->get();
    }

    public function getFirstLevelLesson() {
        return $this->where('status', 1)->get()->first();
    }

    public function getLevelLessonById($level_lesson_id) {
        return $this->where('id', $level_lesson_id)->select('id', 'level')->get()->first();
    }
}
