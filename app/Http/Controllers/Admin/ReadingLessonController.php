<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReadingLessonService;
use App\Services\ReadingLevelLessonService;
use App\Services\ReadingLevelUserService;
use App\Services\ReadingQuestionLessonService;
use App\Services\ReadingTypeQuestionService;
use App\Services\ReadingImageService;
use App\Services\ReadingTypeQuestionDetailOfLessonService;

class ReadingLessonController extends Controller
{
//    Create new lesson:
    public function getCreateNewReadingLesson($domain, $type_lesson_id) {
        $readingLevelLessonService = new ReadingLevelLessonService();
        $all_level_lessons = $readingLevelLessonService->getAllLevelLesson();
        $first_level_lesson_id = $readingLevelLessonService->getFirstLevelLesson();
        $readingTypeQuestionService = new ReadingTypeQuestionService();
        $all_type_questions = $readingTypeQuestionService->getAllTypeQuestionById($first_level_lesson_id->id);
        $readingQuestionLessonServicee = new ReadingQuestionLessonService();
        $last_question_custom_id = $readingQuestionLessonServicee->getTheLastQuestionCustomId();
        $readingLevelUserService = new ReadingLevelUserService();
        $readingLessonService = new ReadingLessonService();
        $all_level_users = $readingLevelUserService->getAllLevelUser();
        $type_lesson_id = getIdFromLink($type_lesson_id);
        switch ($type_lesson_id) {
            case 1:
                return view('admin.readingUploadNewPractice', compact('type_lesson_id', 'last_question_custom_id', 'all_type_questions', 'all_level_lessons', 'all_level_users'));
                break;
            case 2:
                return view('admin.readingUploadNewPractice', compact('type_lesson_id', 'last_question_custom_id', 'all_type_questions', 'all_level_lessons', 'all_level_users'));
                break;
            case 3:
                return view('admin.readingUploadNewMixTest', compact('type_lesson_id', 'last_question_custom_id', 'all_level_lessons', 'all_level_users'));
                break;
            case 4:
                $last_lesson_id = $readingLessonService->getTheLastLessonId($type_lesson_id);
                return view('admin.readingUploadNewFullTest', compact('last_lesson_id', 'type_lesson_id', 'last_question_custom_id', 'all_level_lessons', 'all_level_users'));
                break;
        }
    }

    /**
     * @param ClientUpRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateNewReadingLesson(Request $request, $domain, $type_lesson_id)
    {
        //Get variable:
        $type_lesson_id = getIdFromLink($type_lesson_id);
        $img_url = $_POST['img_url'];
        $img_name_no_ext = $_POST['img_name_no_ext'];
        $img_extension = $_POST['img_extension'];
        $content_lesson = $_POST['content_post'];
        $content_highlight = $_POST['content_highlight'];
        $content_quiz = $_POST['content_quiz'];
        $content_answer_quiz = $_POST['content_answer_quiz'];
        $list_answer = $_POST['list_answer'];
        $title = $_POST['title_post'];
        $type_question_id = $_POST['type_question_id'];
        $level_user_id = $_POST['level_user_id'];
        $lesson_id_create = $_POST['lesson_id'];
        $order_paragraph = $_POST['order_paragraph'];
        $level_lesson_id = $_POST['level_lesson_id'];
        $order_lesson = $_POST['order_lesson'];
        $listKeyword = $_POST['listKeyword'];
        $list_type_questions = $_POST['list_type_questions'];
        $limit_time = $_POST['limit_time'];
        $total_questions = sizeof($list_answer);
        $readingLessonService = new ReadingLessonService();
        $current_lesson_id = $readingLessonService->getTheLastLessonId($type_lesson_id);
        //Function save img:
        if ($img_name_no_ext != '') {
            $readingImageService = new ReadingImageService();
            $image_feature = $readingImageService->saveImageToLocal($type_lesson_id, $img_name_no_ext, $img_url, $img_extension, $current_lesson_id);
        }

        //Save Lesson to DB:
        $lesson_id = $readingLessonService->addNewReadingLesson($level_lesson_id, $lesson_id_create, $order_paragraph, $type_lesson_id, $title, $level_user_id, $content_lesson, $content_highlight, $image_feature = null, $content_quiz, $content_answer_quiz, $total_questions, $order_lesson, $type_question_id, $limit_time);

        //Save questions - answers:
        if ($lesson_id != 'fail-order') {
            foreach ($list_answer as $question_custom_id => $answer) {
                $readingQuestionLessonService = new ReadingQuestionLessonService();
                $readingQuestionLessonService->addNewQuestionLesson($type_lesson_id, $lesson_id, $type_question_id, $question_custom_id, $answer, $listKeyword[$question_custom_id]);
            }

            //Save type question:
            if ($type_lesson_id > 2) {
                foreach ($list_type_questions as $type_question_detail_id) {
                    $readingTypeQuestionDetailOfLessonService = new ReadingTypeQuestionDetailOfLessonService();
                    $readingTypeQuestionDetailOfLessonService->createNewTypeQuestionDetail($lesson_id, $type_lesson_id, $type_question_detail_id);
                }
            }

            $result = 'success';
        }
        else $result = 'fail-order';

        return json_encode(['result' => $result]);
    }
//    /* ------------------------------------------------------------------- */

    public function managerReadingLesson() {
        $readingLevelLessonService = new ReadingLevelLessonService();
        $all_level_lessons = $readingLevelLessonService->getAllLevelLesson();
        $readingLessonService = new ReadingLessonService();
        $lessons = $readingLessonService->getAllLesson();
        $readingLevelUserService = new ReadingLevelUserService();
        $all_level_users = $readingLevelUserService->getAllLevelUser();
        return view('admin.readingManagerLessons', compact('lessons', 'all_level_lessons', 'all_level_users'));
    }

    public function updateTitleLesson($domain, $type_lesson_id, $lesson_id) {
        //Get variable:
        $title_lesson = $_POST['title_lesson'];
        $readingLessonService = new ReadingLessonService();
        $result = $readingLessonService->updateTitleLesson($type_lesson_id, $lesson_id, $title_lesson);
        return json_encode(['result' => $result]);
    }

    public function updateLevelUserLesson($domain, $type_lesson_id, $lesson_id) {
        //Get variable:
        $level_user_id = $_POST['level_user_id'];
        $readingLessonService = new ReadingLessonService();
        $result = $readingLessonService->updateLevelUserLesson($type_lesson_id, $lesson_id, $level_user_id);
        return json_encode(['result' => $result]);
    }

    public function updateBasicInfoLesson($domain, $type_lesson_id, $lesson_id) {
        //Get variable:
        $type_question_id = $_POST['type_question_id'];
        $order_lesson = $_POST['order_lesson'];
        $readingLessonService = new ReadingLessonService();
        $result = $readingLessonService->updateBasicInfoLesson($type_lesson_id, $lesson_id, $type_question_id, $order_lesson);
        return json_encode(['result' => $result]);
    }

    public function updateContentLessonReading($domain, $type_lesson_id, $lesson_id) {
        $content_highlight = $_POST['content_highlight_lesson'];
        $content_lesson = $_POST['content_lesson_source'];
        $readingLessonService = new ReadingLessonService();
        $result = $readingLessonService->updateContentLesson($type_lesson_id, $lesson_id, $content_lesson, $content_highlight);
        return json_encode(['result' => $result]);
    }

    public function updateQuizReading($domain, $type_lesson_id, $lesson_id) {
        $content_highlight = $_POST['content_highlight'];
        $content_quiz = $_POST['content_quiz'];
        $content_answer_quiz = $_POST['content_answer_quiz'];
        $list_answer = $_POST['list_answer'];
        $type_question_id = $_POST['type_question_id'];
        $list_Q_old = $_POST['list_Q_old'];
        $listKeyword = $_POST['listKeyword'];
        $total_questions = sizeof($list_answer);

        //Save quiz - answers:
        $readingLessonService = new ReadingLessonService();
        $readingLessonService->updateQuizLesson($type_lesson_id, $lesson_id, $content_highlight, $content_quiz, $content_answer_quiz, $total_questions);

        //Delete old-question:
        $readingQuestionLessonService = new ReadingQuestionLessonService();
        for ($i=0; $i < sizeof($list_Q_old); $i++) {
            $readingQuestionLessonService->deleteQuestionLesson($type_lesson_id, $lesson_id, $list_Q_old[$i]);
        }

        //Save new question:
        foreach ($list_answer as $question_custom_id => $answer) {
            $readingQuestionLessonService->addNewQuestionLesson($type_lesson_id, $lesson_id, $type_question_id, $question_custom_id, $answer, $listKeyword[$question_custom_id]);
        }

        return json_encode(['result' => 'success']);
    }

    public function getAllOrdered($domain, $type_lesson_id, $type_question_id) {
        $readingLessonService = new ReadingLessonService();
        $all_orders = $readingLessonService->getAllOrderLessonByTypeQuestionId($type_lesson_id, $type_question_id);
        return json_encode(['all_orders' => $all_orders]);
    }

    public function deleteLessonReading($domain, $type_lesson_id, $lesson_id) {
        $readingLessonService = new ReadingLessonService();
        $result = $readingLessonService->deleteLesson($type_lesson_id, $lesson_id);
        return json_encode(['result' => 'success']);
    }
}
