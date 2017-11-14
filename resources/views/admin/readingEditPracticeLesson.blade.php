<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 8/17/2017
 * Time: 2:04 AM
 */
?>

@extends('layout.masterNoMenuAdmin')
@section('meta-title')
    Edit Lesson
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/css/admin/readingUploadNewLesson.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/client/readingSolution.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/admin/readingEditLesson.css')}}">
    {{--    <meta name="csrf-token" content="{{ csrf_token() }}" />--}}
    <script src="/public/libs/ckeditor/ckeditor.js"></script>
@endsection
@section('content')
    <div class="container upload-page-custom container-page-custom" data-idquestion="{!! $last_question_custom_id !!}" data-lesson-id="{!! $lesson->id !!}" data-quiz-id="{!! $lesson->id !!}" data-type-question-id="{!! $lesson->type_question_id !!}">
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
        <div class="preview-lesson">
            <div class="solution-detail panel-container">
                <div class="left-panel-custom panel-left panel-top" id="lesson-highlight-area" data-lessonid="{!! $lesson->id !!}">
                    {!! $lesson->content_highlight !!}
                </div>
                <div class="splitter">
                </div>
                <div class="splitter-horizontal">
                </div>
                <div class="right-panel-custom panel-right panel-bottom active-quiz" id="solution-area" data-quizId="{!! $lesson->id !!}">
                    {!! $lesson->content_answer_quiz !!}
                </div>
            </div>
        </div>
        <div class="control-edit-lesson-area">
            <button type="button" class="btn btn-primary btn-edit-content-lesson btn-custom-edit-lesson" onclick="editContentLesson()">
                <i class="fa fa-pencil-square-o icon-reading-edit-lesson" aria-hidden="true"></i>
                Content
            </button>
            <button type="button" class="btn btn-success btn-edit-quiz-lesson btn-custom-edit-lesson" onclick="editQuizLesson()">
                <i class="fa fa-pencil-square-o icon-reading-edit-lesson" aria-hidden="true"></i>
                Quiz
            </button>
        </div>
        <!-- Edit Content Lesson Area-->
        <div class="edit-content-lesson hidden">
            <div class="edit-content">
                <textarea name="editor_lesson" id="contentLesson">
                {!! $lesson->content_lesson !!}
            </textarea>
                <script>
                    CKEDITOR.replace( 'editor_lesson' );
                </script>
                <div class="control-edit-lesson-content">
                    <button type="button" class="btn btn-success btn-next-edit-highlight btn-edit-custom" onclick="editHighlightLesson()">
                        Next
                    </button>
                </div>
            </div>
            <div class="row edit-highlight hidden">
                <div class="col-md-8 card highlight-sandbox">
                    <div class="card-header">
                        <h3 class="text-left">
                            Highlight đáp án!
                        </h3>
                    </div>
                    <div class="card-block">
                        <div id="sandbox">
                            {!! $lesson->content_highlight !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 card remove-tool-area">
                    <div class="card-header">
                        <h3 class="text-left">
                            Remove highlight!
                        </h3>
                    </div>
                    <div class="card-block hl-btn-content-area remove-highlight-area">

                    </div>
                </div>
                <div class="control-edit-lesson-highlight">
                    <button type="button" class="btn btn-success btn-back-edit-content btn-edit-custom" onclick="stepEditContentLesson()">
                        Prev
                    </button>
                    <button type="button" class="btn btn-danger btn-save-edit-lesson btn-edit-custom" onclick="updateContentLesson()">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <!-- Edit Quiz Lesson Area-->
        <div class="edit-quiz-lesson hidden">
            <div class="edit-quiz">
                <textarea name="editor_quiz" id="quizLesson">
                {!! $lesson->content_quiz !!}
            </textarea>
                <script>
                    CKEDITOR.replace( 'editor_quiz' );
                </script>
                <div class="control-edit-lesson-content">
                    <button type="button" class="btn btn-success btn-next-edit-answer btn-edit-custom" onclick="">
                        Next
                    </button>
                </div>
            </div>
            <div class="row edit-answer hidden">
                <div class="page-upload row">
                    <div class="inner-page-upload panel-container col-md-8">
                        <div class="upload-left-panel-custom panel-left upload-panel-top card highlight-sandbox col-md-8">
                            <div class="card-header">
                                <h3 class="text-left">
                                    Highlight đáp án!
                                </h3>
                            </div>
                            <div class="card-block">
                                <div id="sandbox-quiz">
                                    {!! $lesson->content_highlight !!}
                                </div>
                            </div>
                        </div>
                        <div class="splitter">
                        </div>
                        <div class="splitter-horizontal">
                        </div>
                        <div class="upload-right-panel-custom panel-right upload-panel-bottom active-quiz card preview-content-quiz">
                            <div class="card-header">
                                <h3 class="text-left">
                                    Nội dung câu hỏi:
                                </h3>
                            </div>
                            <div class="card-block">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 card answer-key-area">
                        <div class="card-header">
                            <h3 class="text-left">
                                Đáp án:
                            </h3>
                        </div>
                        <div class="card-block">
                            <div class="answer-area">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-step-area">
                    <button type="button" class="btn btn-success btn-back-edit-quiz btn-edit-custom">
                        Prev
                    </button>
                    <button type="button" class="btn btn-success btn-next-preview-edit btn-edit-custom">
                        Next
                    </button>
                </div>
            </div>
            <div class="row preview-edit-lesson hidden">
                <div class="col-md-6 card preview-post">
                    <div class="card-header">
                        <h3 class="text-left">
                            Noi dung Post!
                        </h3>
                    </div>
                    <div class="card-block">
                        <div id="pr-post">
                            {!! $lesson->content_highlight !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 card preview-quiz">
                    <div class="card-header">
                        <h3 class="text-left">
                            Noi dung Quiz!
                        </h3>
                    </div>
                    <div class="card-block">
                        <div id="pr-quiz">

                        </div>
                    </div>
                </div>
                <div class="control-step-area">
                    <button type="button" class="btn btn-success btn-back-edit-answer btn-edit-custom">
                        Prev
                    </button>
                    <button type="submit" class="btn btn-danger btn-update-quiz-lesson btn-edit-custom">
                        Save
                    </button>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
    <script src="{{asset('public/js/admin/readingEditLesson.js')}}"></script>
    <script src="{{asset('public/js/client/readingCommentFunctions.js')}}"></script>
    <script src="{{asset('public/js/admin/readingEditPracticeFunctions.js')}}"></script>
    <script src="{{asset('public/js/admin/readingHighlight.js')}}"></script>
    <script src="{{asset('public/js/client/readingSolutionDetail.js')}}"></script>
@endsection