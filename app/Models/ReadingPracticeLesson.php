<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReadingPracticeLesson extends Model
{
    protected $table = 'reading_practice_lessons';

    protected $fillable = ['title', 'level_user_id', 'content_lesson', 'content_highlight', 'image_feature', 'content_quiz', 'content_answer_quiz', 'total_questions', 'order_lesson', 'type_question_id', 'admin_responsibility', 'status'];

    public $timestamps = true;

    public function questionLessons()
    {
        return $this->hasMany('App\Models\ReadingQuestionLesson', 'lesson_id');
    }

    public function typeQuestion()
    {
        return $this->belongsTo('App\Models\ReadingTypeQuestion', 'type_question_id');
    }

    public function levelUser()
    {
        return $this->belongsTo('App\Models\ReadingLevelUser', 'level_user_id');
    }

    public function User()
    {
        return $this->belongsTo('App\User', 'admin_responsibility');
    }

    public function getTheLastLessonId() {
        return $this->select('id')->orderBy('id', 'desc')->first();
    }

    public function addNewPracticeLesson($title, $level_user_id, $content_lesson, $content_highlight, $image_feature, $content_quiz, $content_answer_quiz, $total_questions, $order_lesson, $type_question_id, $admin_responsibility) {
        if ($this->where('type_question_id', $type_question_id)->where('order_lesson', $order_lesson)->exists()) {
            return 'fail-order';
        }
        else {
            $new_reading_lesson = new ReadingPracticeLesson();
            $new_reading_lesson->title = $title;
            $new_reading_lesson->level_user_id = $level_user_id;
            $new_reading_lesson->content_lesson = $content_lesson;
            $new_reading_lesson->content_highlight = $content_highlight;
            $new_reading_lesson->image_feature = $image_feature;
            $new_reading_lesson->content_quiz = $content_quiz;
            $new_reading_lesson->content_answer_quiz = $content_answer_quiz;
            $new_reading_lesson->total_questions = $total_questions;
            $new_reading_lesson->order_lesson = $order_lesson;
            $new_reading_lesson->type_question_id = $type_question_id;
            $new_reading_lesson->admin_responsibility = $admin_responsibility;
            $new_reading_lesson->save();
            return $new_reading_lesson->id;
        }

    }

    public function getAllPracticeLesson() {
        return $this->where('status',1)->orderBy('updated_at','desc')->select('id', 'title', 'level_user_id', 'image_feature', 'order_lesson', 'type_question_id', 'created_at', 'admin_responsibility')->get()->all();
    }

    public function getPracticesByTypeQuestionId($type_question_id) {
        return $this->where('status',1)->where('type_question_id', $type_question_id)->orderBy('order_lesson','asc')->select('id', 'title', 'level_user_id', 'image_feature', 'order_lesson', 'total_questions')->get()->all();
    }

    public function updateTitlePracticeLesson($lesson_id, $title, $admin_responsibility) {
        if ($this->where('id', $lesson_id)->where('title', $title)->exists()) {
            return 'title-not-change';
        }
        else {
            $this->where('id', $lesson_id)->update(['title' => $title, 'admin_responsibility' => $admin_responsibility, 'updated_at' => Carbon::now()]);
            return 'update-success';
        }
    }

    public function updateContentPracticeLesson($lesson_id, $content_lesson, $content_highlight, $admin_responsibility) {
        $this->where('id', $lesson_id)->update(['content_lesson' => $content_lesson, 'content_highlight' => $content_highlight, 'admin_responsibility' => $admin_responsibility, 'updated_at' => Carbon::now()]);
        return 'update-success';
    }

    public function updateQuizPracticeLesson($lesson_id, $content_highlight, $content_quiz, $content_answer_quiz, $total_questions, $admin_responsibility) {
        $this->where('id', $lesson_id)->update(['content_highlight' => $content_highlight, 'content_quiz' => $content_quiz, 'content_answer_quiz' => $content_answer_quiz, 'total_questions' => $total_questions, 'admin_responsibility' => $admin_responsibility, 'updated_at' => Carbon::now()]);
        return 'update-success';
    }

    public function updateLevelUserPracticeLesson($lesson_id, $level_user_id, $admin_responsibility) {
        if ($this->where('id', $lesson_id)->where('level_user_id', $level_user_id)->exists()) {
            return 'level-user-not-change';
        }
        else {
            $this->where('id', $lesson_id)->update(['level_user_id' => $level_user_id, 'admin_responsibility' => $admin_responsibility, 'updated_at' => Carbon::now()]);
            return 'update-success';
        }
    }

    public function updateBasicInfoPracticeLesson($lesson_id, $type_question_id, $order_lesson, $admin_responsibility) {
        if ($this->where('type_question_id', $type_question_id)->where('order_lesson', $order_lesson)->where('status', 1)->exists()) {
            return 'order-fail';
        }
        else {
            $this->where('id', $lesson_id)->update(['type_question_id' => $type_question_id, 'order_lesson' => $order_lesson, 'admin_responsibility' => $admin_responsibility, 'updated_at' => Carbon::now()]);
            return 'update-success';
        }
    }

    public function getAllOrderPracticeLessonByTypeQuestionId($type_question_id) {
        return $this->where('type_question_id', $type_question_id)->where('status', 1)->orderBy('order_lesson','asc')->select('order_lesson')->get()->all();
    }

    public function getDetailPracticeLessonForAdminEdit($lesson_id) {
        return $this->where('status', 1)->where('id', $lesson_id)->select('id', 'content_lesson', 'content_highlight', 'content_quiz', 'content_answer_quiz', 'type_question_id')->get()->first();
    }

    public function getDetailPracticeLessonForClientTest($lesson_id) {
        return $this->where('status', 1)->where('id', $lesson_id)->select('id', 'title', 'content_lesson', 'content_quiz', 'total_questions', 'type_question_id')->get()->first();
    }

    public function getDetailPracticeLessonForClientSolution($lesson_id) {
        return $this->where('status', 1)->where('id', $lesson_id)->select('id', 'title', 'content_highlight', 'content_answer_quiz', 'total_questions', 'type_question_id')->get()->first();
    }

    public function deletePracticeLesson($lesson_id) {
        return $this->where('id', $lesson_id)->update(['status' => 0, 'updated_at' => Carbon::now()]);
    }

    public function getTotalQuestionOfPracticeLesson($lesson_id) {
        return $this->where('id', $lesson_id)->select('total_questions')->get()->first();
    }

    public function getCurrentStepOfPracticeLesson($lesson_id) {
        return $this->where('id', $lesson_id)->select('order_lesson')->get()->first();
    }

    public function checkVipPracticeLesson($lesson_id) {
        return $this->where('id', $lesson_id)->select('level_user_id')->get()->first();
    }
}
