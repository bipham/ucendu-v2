<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReadingQuestionAnswerLessonService;

class ReadingCommentController extends Controller
{
    public function managerCommentReading() {
        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
        $all_comments = $readingQuestionAnswerLessonService->getAllComments();
//        dd($all_comments);
        return view('admin.readingManagerComments', compact('all_comments'));
    }

    public function deleteCommentReading($comment_id) {
        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
        $readingQuestionAnswerLessonService->deleteComment($comment_id);
        return json_encode(['result' => $comment_id]);
    }

    public function setPublicReadingComment($comment_id) {
        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
        $readingQuestionAnswerLessonService->setPublicComment($comment_id);
        return json_encode(['result' => $comment_id]);
    }

    public function setPrivateReadingComment($comment_id) {
        $readingQuestionAnswerLessonService = new ReadingQuestionAnswerLessonService();
        $readingQuestionAnswerLessonService->setPrivateComment($comment_id);
        return json_encode(['result' => $comment_id]);
    }

}
