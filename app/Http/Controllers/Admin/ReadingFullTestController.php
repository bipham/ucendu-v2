<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReadingFullTestService;
use App\Services\ReadingLessonService;

class ReadingFullTestController extends Controller
{
    public function getListFullTestLessonUploaded($domain, $level_lesson_id)  {
        $readingLessonService = new ReadingLessonService();
        $readingFullTestService = new ReadingFullTestService();
        $all_uploaded_lessons = $readingFullTestService->getListFullTestLessonUploaded($level_lesson_id);
        $all_orders = $readingLessonService->getAllOrderLessonByTypeQuestionId(4, $level_lesson_id);
        return json_encode(['all_uploaded_lessons' => $all_uploaded_lessons, 'all_orders' => $all_orders]);
    }

    public function getAllOrderParagraphOfFullTest($domain, $full_test_id)  {
        $readingFullTestService = new ReadingFullTestService();;
        $all_paragraph_orders = $readingFullTestService->getAllOrderParagraphOfFullTest($full_test_id);
        return json_encode(['all_paragraph_orders' => $all_paragraph_orders]);
    }

    public function createNewFullTest($domain) {
        //Get variables:
        $level_lesson_id = $_GET['level_lesson_id'];
        $title = $_GET['new_title'];
        $level_user_id = $_GET['level_user_id'];
        $order_lesson = $_GET['order_lesson'];
        $limit_time = $_GET['limit_time'];
//        return json_encode(['full_test_id' => 'success']);
        $readingFullTestService = new ReadingFullTestService();
        $full_test_id = $readingFullTestService->createNewFullTest($title, $level_lesson_id, $level_user_id, $order_lesson, $limit_time);
        return json_encode(['full_test_id' => $full_test_id]);
    }
}
