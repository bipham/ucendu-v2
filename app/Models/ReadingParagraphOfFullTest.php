<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingParagraphOfFullTest extends Model
{
    protected $table = 'reading_paragraph_of_full_tests';

    protected $fillable = ['full_test_id', 'content_lesson',  'content_highlight', 'content_quiz', 'content_answer_quiz', 'order_paragraph', 'admin_responsibility', 'status'];

    public $timestamps = true;

    public function fullTest()
    {
        return $this->belongsTo('App\Models\ReadingFullTestLesson', 'full_test_id');
    }

    public function getAllOrderParagraphOfFullTest($full_test_id) {
        return $this->where('full_test_id', $full_test_id)->where('status', 1)->select('order_paragraph')->orderBy('order_paragraph', 'asc')->get()->all();
    }

    public function createNewParagraph($full_test_id, $content_lesson, $content_highlight, $content_quiz, $content_answer_quiz, $order_paragraph, $admin_responsibility) {
        if ($this->where('full_test_id', $full_test_id)->where('order_paragraph', $order_paragraph)->exists()) {
            return 'fail-order';
        }
        else {
            $new_paragraph = new ReadingParagraphOfFullTest();
            $new_paragraph->full_test_id = $full_test_id;
            $new_paragraph->content_lesson = $content_lesson;
            $new_paragraph->content_highlight = $content_highlight;
            $new_paragraph->content_quiz = $content_quiz;
            $new_paragraph->content_answer_quiz = $content_answer_quiz;
            $new_paragraph->order_paragraph = $order_paragraph;
            $new_paragraph->admin_responsibility = $admin_responsibility;
            $new_paragraph->save();
            return $new_paragraph->id;
        }
    }

}
