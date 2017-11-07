<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReadingQuestionAndAnswerLesson extends Model
{
    protected $table = 'reading_question_and_answer_lessons';

    protected $fillable = ['question_custom_id', 'user_id', 'reply_comment_id', 'content_cmt', 'status', 'private'];

    public $timestamps = true;

    public function questionLesson()
    {
        return $this->belongsTo('App\Models\ReadingQuestionLesson', 'question_custom_id', 'question_custom_id');
    }

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getAllCommentsOfQuestion($question_custom_id) {
        return DB::table('reading_question_and_answer_lessons')
                    ->rightJoin('users', 'users.id', '=', 'reading_question_and_answer_lessons.user_id')
                    ->where('reading_question_and_answer_lessons.question_custom_id', $question_custom_id)
                    ->where('reading_question_and_answer_lessons.status', '=', 1)
                    ->select(['reading_question_and_answer_lessons.*', 'username' => 'users.username', 'avatar' => 'users.avatar'])
                    ->orderBy('reading_question_and_answer_lessons.created_at','asc')
                    ->get();
    }

    public function getAllComments() {
        return $this->where('status',1)->orderBy('created_at','desc')->get()->all();
    }

    public function createNewCommentLesson($question_custom_id, $user_id, $reply_comment_id, $content_cmt, $private) {
        $new_comment_lesson = new ReadingQuestionAndAnswerLesson();
        $new_comment_lesson->question_custom_id = $question_custom_id;
        $new_comment_lesson->user_id = $user_id;
        $new_comment_lesson->reply_comment_id = $reply_comment_id;
        $new_comment_lesson->content_cmt = $content_cmt;
        $new_comment_lesson->private = $private;
        $new_comment_lesson->save();
        return $new_comment_lesson;
    }
 
    public function getAllRelatedUser($question_custom_id) {
         return DB::table('reading_question_and_answer_lessons')
            ->leftJoin('users', 'reading_question_and_answer_lessons.user_id', '=', 'users.id')
            ->where('reading_question_and_answer_lessons.question_custom_id', $question_custom_id)
            ->where('reading_question_and_answer_lessons.status', 1)
            ->where('users.level_user_id', '>', 1)
            ->groupBy('reading_question_and_answer_lessons.user_id')
            ->select(['reading_question_and_answer_lessons.user_id'])
            ->get();
    }

    public function getAllRelatedAdmins($question_custom_id) {
         return DB::table('reading_question_and_answer_lessons')
            ->leftJoin('users', 'reading_question_and_answer_lessons.user_id', '=', 'users.id')
            ->where('reading_question_and_answer_lessons.question_custom_id', $question_custom_id)
            ->where('reading_question_and_answer_lessons.status', 1)
            ->where('users.level_user_id', 1)
            ->groupBy('reading_question_and_answer_lessons.user_id')
            ->select(['reading_question_and_answer_lessons.user_id'])
            ->get();
    }

    public function setPublicComment($id) {
        return $this->where('id', $id)->update(['private' => 0, 'updated_at' => Carbon::now()]);
    }

    public function setPrivateComment($id) {
        return $this->where('id', $id)->update(['private' => 1, 'updated_at' => Carbon::now()]);
    }

    public function deleteComment($id) {
        return $this->where('id', $id)->update(['status' => 0, 'updated_at' => Carbon::now()]);
    }
}
