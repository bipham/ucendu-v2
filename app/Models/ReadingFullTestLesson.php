<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReadingFullTestLesson extends Model
{
    protected $table = 'reading_full_test_lessons';

    protected $fillable = ['title', 'level_lesson_id', 'level_user_id', 'image_feature', 'total_questions', 'order_lesson', 'limit_time', 'number_paragraphs', 'admin_responsibility', 'status'];

    public $timestamps = true;

    public function levelLesson()
    {
        return $this->belongsTo('App\Models\ReadingLevelLesson', 'level_lesson_id');
    }

    public function levelUser()
    {
        return $this->belongsTo('App\Models\ReadingLevelUser', 'level_user_id');
    }

    public function fullTestParagraphs()
    {
        return $this->hasMany('App\Models\ReadingParagraphOfFullTest', 'full_test_id');
    }

    public function questionLessons()
    {
        return $this->hasMany('App\Models\ReadingQuestionLesson', 'lesson_id');
    }

    public function getTheLastLessonId() {
        return $this->select('id')->orderBy('id', 'desc')->first();
    }

    public function getListFullTestLessonUploaded($level_lesson_id) {
        return $this->where('level_lesson_id', $level_lesson_id)->where('number_paragraphs', '<', 3)->select('id', 'title')->orderBy('id', 'asc')->get()->all();
    }

    public function getAllOrderFullTestByLevelLessonId($level_lesson_id) {
        return $this->where('level_lesson_id', $level_lesson_id)->where('status', 1)->orderBy('order_lesson','asc')->select('order_lesson')->get()->all();
    }

    public function addNewFullTest($title, $level_lesson_id, $level_user_id, $order_lesson, $limit_time, $admin_responsibility) {
        if ($this->where('level_lesson_id', $level_lesson_id)->where('order_lesson', $order_lesson)->exists()) {
            return 'fail-order';
        }
        else {
            $new_full_test = new ReadingFullTestLesson();
            $new_full_test->level_lesson_id = $level_lesson_id;
            $new_full_test->title = $title;
            $new_full_test->level_user_id = $level_user_id;
            $new_full_test->order_lesson = $order_lesson;
            $new_full_test->limit_time = $limit_time;
            $new_full_test->admin_responsibility = $admin_responsibility;
            $new_full_test->save();
            return $new_full_test->id;
        }
    }

    public function getNumberParagraphOfFullTest($full_test_id) {
        return $this->where('id', $full_test_id)->select('number_paragraphs')->get()->first();
    }

    public function updateNumberParagraphsOfFullTest($full_test_id, $number_paragraphs) {
        return $this->where('id', $full_test_id)->update(['number_paragraphs' => $number_paragraphs, 'updated_at' => Carbon::now()]);
    }

    public function getAllFullTest($level_lesson_id) {
        return $this->where('status', 1)->where('level_lesson_id', $level_lesson_id)->orderBy('order_lesson', 'asc')->select('id', 'title', 'level_user_id', 'order_lesson', 'limit_time', 'total_questions')->get()->all();
    }

    public function getDetailFullTestForClient($lesson_id) {
        return $this->where('status', 1)->where('id', $lesson_id)->select('id', 'title', 'limit_time', 'total_questions', 'number_paragraphs')->get()->first();
    }

    public function getTotalQuestionOfFullTestLesson($lesson_id) {
        return $this->where('id', $lesson_id)->select('total_questions')->get()->first();
    }
}
