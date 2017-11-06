<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*********************************************************
 *
 *                  ROUTE FOR PUBLIC
 *
 *********************************************************/
Route::pattern('nameDomain', '(www.ucendu-v2.dev|ucendu-v2.dev|www.ucendu-v2.com|ucendu-v2.com|www.ucendu-v2.vn|ucendu-v2.vn)');
// Authentication routes...
Route::get('login', ['as'=>'getLogin', 'uses' => 'Auth\LoginController@getLogin']);
Route::post('login',['as'=>'postLogin','uses'=>'Auth\LoginController@postLogin']);
Route::get('changePassword', ['as'=>'getChangePassword', 'uses' => 'Client\UserController@getChangePassword']);
Route::post('changePassword',['as'=>'postChangePassword','uses'=>'Client\UserController@postChangePassword']);
Route::get('getNotification/{user_id}',['as'=>'getMatchNotification','uses'=>'ReadingNotificationController@getNotification'])->middleware('auth');
Route::get('logout',['as'=>'logout','uses'=>'Auth\LoginController@getLogout'])->middleware('auth');
Route::get('deleteCommentReading/{comment_id}',['as'=>'deleteCommentReading','uses'=>'Admin\ReadingCommentController@deleteCommentReading']);
Route::get('setPublicReadingComment/{comment_id}',['as'=>'setPublicReadingComment','uses'=>'Admin\ReadingCommentController@setPublicReadingComment']);
Route::get('setPrivateReadingComment/{comment_id}',['as'=>'setPrivateReadingComment','uses'=>'Admin\ReadingCommentController@setPrivateReadingComment']);
Route::get('readNotification/{type_noti}--{id}',['as'=>'readNotification','uses'=>'ReadingNotificationController@readNotification']);
Route::get('markAllNotificationAsRead',['as'=>'markAllNotificationAsRead','uses'=>'ReadingNotificationController@markAllNotificationAsRead']);

/*********************************************************
 *
 *                  ROUTE FOR ADMIN MODULE
 *
 *********************************************************/

Route::group(['domain' => 'admin.{nameDomain}', 'middleware' => ['adminAuth']], function () {
    //************ For Full Test ***************
    Route::get('getListFullTestLessonUploaded/{level_lesson_id}', ['as' => 'getListFullTestLessonUploaded', 'uses' => 'Admin\ReadingFullTestController@getListFullTestLessonUploaded']);
    Route::get('getAllOrderParagraphOfFullTest/{full_test_id}', ['as' => 'getAllOrderParagraphOfFullTest', 'uses' => 'Admin\ReadingFullTestController@getAllOrderParagraphOfFullTest']);
    Route::get('createNewFullTest', ['as' => 'createNewFullTest', 'uses' => 'Admin\ReadingFullTestController@createNewFullTest']);

    //************ For Reading Lesson *************
    Route::get('createNewReadingLesson/{type_lesson_id}',['as'=>'getCreateNewReadingLesson','uses'=>'Admin\ReadingLessonController@getCreateNewReadingLesson']);
    Route::post('createNewReadingLesson/{type_lesson_id}',['as'=>'postCreateNewReadingLesson','uses'=>'Admin\ReadingLessonController@postCreateNewReadingLesson']);

    Route::get('createNewLevelLesson',['as'=>'getCreateNewLevelLesson','uses'=>'Admin\ReadingLevelLessonController@getCreateNewLevelLesson']);
    Route::post('createNewLevelLesson',['as'=>'postCreateNewLevelLesson','uses'=>'Admin\ReadingLevelLessonController@postCreateNewLevelLesson']);

    Route::get('deleteLessonReading/{type_lesson_id}-{lesson_id}',['as'=>'deleteLessonReading','uses'=>'Admin\ReadingLessonController@deleteLessonReading']);

    Route::get('editPracticeLessonReading/{lesson_id}',['as'=>'getEditPracticeLessonReading','uses'=>'Admin\ReadingPracticeController@getEditPracticeLessonReading']);

    Route::post('updateContentLessonReading/{type_lesson_id}-{lesson_id}',['as'=>'updateContentLessonReading','uses'=>'Admin\ReadingLessonController@updateContentLessonReading']);

    Route::post('updateQuizReading/{type_lesson_id}-{lesson_id}',['as'=>'updateQuizReading','uses'=>'Admin\ReadingLessonController@updateQuizReading']);

    Route::get('managerReadingLesson',['as'=>'managerReadingLesson','uses'=>'Admin\ReadingLessonController@managerReadingLesson']);

    Route::post('updateTitleLesson/{type_lesson_id}-{lesson_id}',['as'=>'updateTitleLesson','uses'=>'Admin\ReadingLessonController@updateTitleLesson']);

    Route::post('updateBasicInfoLesson/{type_lesson_id}-{lesson_id}',['as'=>'updateBasicInfoLesson','uses'=>'Admin\ReadingLessonController@updateBasicInfoLesson']);

    Route::post('updateLevelUserLesson/{type_lesson_id}-{lesson_id}',['as'=>'updateLevelUserLesson','uses'=>'Admin\ReadingLessonController@updateLevelUserLesson']);

    //********** For Reading Question *************
    Route::get('createNewTypeQuestion',['as'=>'getCreateNewTypeQuestion','uses'=>'Admin\ReadingTypeQuestionController@getCreateNewTypeQuestion']);
    Route::post('createNewTypeQuestion',['as'=>'postCreateNewTypeQuestion','uses'=>'Admin\ReadingTypeQuestionController@postCreateNewTypeQuestion']);
    Route::get('createNewLearningTypeQuestion',['as'=>'getCreateNewLearningTypeQuestion','uses'=>'Admin\ReadingLearningTypeQuestionController@getCreateNewLearningTypeQuestion']);
    Route::post('createNewLearningTypeQuestion',['as'=>'postCreateNewLearningTypeQuestion','uses'=>'Admin\ReadingLearningTypeQuestionController@postCreateNewLearningTypeQuestion']);
    Route::get('getTypeQuestionByLevelLessonId',['as'=>'getTypeQuestionByLevelLessonId','uses'=>'Admin\ReadingTypeQuestionController@getTypeQuestionByLevelLessonId']);

    //********** For Reading Vocabulary *************
    Route::get('createNewVocabulary',['as'=>'getCreateNewVocabulary','uses'=>'Admin\ReadingVocabularyController@getCreateNewVocabulary']);
    Route::post('createNewVocabulary',['as'=>'postCreateNewVocabulary','uses'=>'Admin\ReadingVocabularyController@postCreateNewVocabulary']);
    Route::post('createNewPhraseWord',['as'=>'postCreateNewPhraseWord','uses'=>'Admin\ReadingVocabularyController@postCreateNewPhraseWord']);

    //********** For Reading Notification + Comments *************/
    Route::get('createNewCate',['as'=>'createNewCate','uses'=>'Admin\CateController@createNewCate']);
//    Route::get('createNewTypeQuiz',['as'=>'createNewTypeQuiz','uses'=>'Admin\TypeQuestionController@createNewTypeQuiz']);
    Route::get('listCommentReading',['as'=>'listCommentReading','uses'=>'Admin\ReadingCommentController@listCommentReading']);

    //********** For Reading User *************/
    Route::get('createNewUser',['as'=>'getCreateNewUser','uses'=>'Admin\UserController@getCreateNewUser']);
    Route::post('createNewUser',['as'=>'postCreateNewUser','uses'=>'Admin\UserController@postCreateNewUser']);
    Route::get('createNewLevelUser',['as'=>'getCreateNewLevelUser','uses'=>'Admin\ReadingLevelUserController@getCreateNewLevelUser']);
    Route::post('createNewLevelUser',['as'=>'postCreateNewLevelUser','uses'=>'Admin\ReadingLevelUserController@postCreateNewLevelUser']);

    //********** For English Story *************/
    Route::get('uploadReadingStory',['as'=>'getUploadReadingStory','uses'=>'Admin\ReadingEnglishStoryController@getUploadReadingStory']);
    Route::post('uploadReadingStory',['as'=>'postUploadReadingStory','uses'=>'Admin\ReadingEnglishStoryController@postUploadReadingStory']);
    Route::post('createNewStory',['as'=>'postCreateNewStory','uses'=>'Admin\ReadingEnglishStoryController@postCreateNewStory']);
    Route::post('createNewChapterOfStory',['as'=>'postCreateNewChapterOfStory','uses'=>'Admin\ReadingEnglishStoryController@postCreateNewChapterOfStory']);
    Route::get('createNewLevelStory',['as'=>'getCreateNewLevelStory','uses'=>'Admin\ReadingEnglishStoryController@getCreateNewLevelStory']);
    Route::post('createNewLevelStory',['as'=>'postCreateNewLevelStory','uses'=>'Admin\ReadingEnglishStoryController@postCreateNewLevelStory']);
    Route::get('createNewGenreStory',['as'=>'getCreateNewGenreStory','uses'=>'Admin\ReadingEnglishStoryController@getCreateNewGenreStory']);
    Route::post('createNewGenreStory',['as'=>'postCreateNewGenreStory','uses'=>'Admin\ReadingEnglishStoryController@postCreateNewGenreStory']);

    //********** For Reading Others *************/
    Route::get('getStepSection',['as'=>'getStepSection','uses'=>'Admin\TypeQuestionController@getStepSection']);
    Route::get('getAllOrdered/{type_lesson_id}-{type_question_id}',['as'=>'getAllOrdered','uses'=>'Admin\ReadingLessonController@getAllOrdered']);
    Route::get('/', function () {
        return view('admin.welcome');
    });
});

/*********************************************************
 *
 *
 *                  ROUTE FOR CLIENT MODULE
 *
 *
 *
 *********************************************************/
Route::group(['domain'=>'{nameDomain}', 'middleware' => ['clientAuth']], function () {
    Route::get('/', function () {
        return view('client.welcome');
    });
    //Demo:
    Route::post('pusher/auth', 'ReadingNotificationController@pusherAuth');
// gọi ra trang view demo-pusher.blade.php
    Route::get('demo-pusher','ReadingNotificationController@getPusher');
// Truyển message lên server Pusher
    Route::get('fire-event','ReadingNotificationController@fireEvent');
    Route::get('test-event','ReadingNotificationController@testEvent');

    //********** For Reading Solution *************
    Route::get('showComments/{question_id_custom}',['as'=>'showComments','uses'=>'Client\CommentQuestionController@getComments']);
    Route::get('showExplanation/{question_id_custom}',['as'=>'showExplanation','uses'=>'Client\ReadingResultController@getExplanation']);
    Route::post('enterNewComment',['as'=>'enterNewComment','uses'=>'Client\CommentQuestionController@createNewComment']);

    //For Reading English:
    Route::group(['prefix'=>'reading/{level_id}'],function () {
        Route::get('',['as'=>'reading/{level_id}','uses'=>'Client\ReadingLessonController@index']);
        Route::get('readingLesson/{type_lesson_id}/{lesson_id}',                array('as'=>'reading.readingLesson',            'uses'=>'Client\ReadingLessonController@readingLessonDetail'));
        Route::get('getResultReadingLesson/{type_lesson_id}-{lesson_id}',['as'=>'getResultReadingLesson','uses'=>'Client\ReadingResultController@getResultReadingLesson']);
        Route::get('readingViewResultLesson/{type_lesson_id}-{lesson_id}',['as'=>'readingViewResultLesson','uses'=>'Client\ReadingResultController@getReadingViewResultLesson']);
        Route::get('readingViewSolutionLesson/{type_lesson_id}-{lesson_id}',['as'=>'readingViewSolutionLesson','uses'=>'Client\ReadingResultController@getReadingViewSolutionLesson']);
    });

    //For english Story:
    Route::get('vocabularyReading',['as'=>'vocabularyReading','uses'=>'Client\ReadingVocabularyController@getVocabularyReading']);

    Route::group(['prefix'=>'englishStory'],function () {
        Route::get('viewStory/{story}',['as'=>'viewStory','uses'=>'Client\EnglishStoryController@viewStory']);
    });
});
