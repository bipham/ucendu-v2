<?php
/**
 * Created by PhpStorm.
 * User: nobikun1412
 * Date: 10/30/2017
 * Time: 8:07 AM
 */
?>
@extends('layout.masterNoMenuAdmin')
@section('meta-title')
    Upload new mix test!
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/css/admin/readingUploadNewLesson.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/client/readingSolution.css')}}">
    <script src="/public/libs/ckeditor/ckeditor.js"></script>
@endsection
@section('content')
    <div class="container upload-page-custom upload-new-leson-page container-page-custom" data-idquestion="{!! $last_question_custom_id !!}" data-type-lesson-id="{!! $type_lesson_id !!}">
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
        <div class="row step-content-post">
            <div class="card content-post-area card-step-area">
                <div class="card-header">
                    <h3 class="text-left">
                        INPUT CONTENT - Mix Test
                    </h3>
                </div>
                <div class="card-block">
                    <div class="form-content">
                        <div class="form-group">
                            <label for="list_level">
                                Chon level lesson!
                            </label>
                            <select class="form-control" id="list_level" name="list_level" onchange="getAllTypeQuestionByLevelLessonId()">
                                <option value="0">Select level</option>
                                @foreach($all_level_lessons as $level_lesson)
                                    <option value="{!! $level_lesson->id !!}">{!! $level_lesson->level !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="itemname">
                                Tên Bài Viết
                            </label>
                            <input type="text" name="itemname" class="form-control" placeholder="Điền vào đây" required id="itemname">
                        </div>
                        <div class="form-group form-upload-img-custom">
                            <label>Hình Đại Diện</label>
                            <input type="file" name="image-main" onchange="readURL(this);" required id="imgFeature">
                            <img id="image-main-preview" class="img-upload-product hidden-class" src="#" alt="Ảnh" />
                        </div>
                        <div class="form-group">
                            <label for="content">
                                Nội dung
                            </label>
                            <textarea name="editor_post" id="contentPost" rows="10" cols="80">
                            </textarea>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor
                                // instance, using default configuration.
                                CKEDITOR.replace( 'editor_post' );
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="control-step-area">
                <button type="button" class="btn btn-success btn-next-step-quiz btn-custom-step">
                    Next
                </button>
            </div>
        </div>
        {{--Input Question--}}
        <div class="row step-content-quiz hidden-class">
            <div class="card content-quiz-area card-step-area">
                <div class="card-header">
                    <h3 class="text-left">
                        INPUT QUESTION - READING PRACTICE
                    </h3>
                </div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="list_level_users">
                            Chon Level User
                        </label>
                        <select class="form-control" id="list_level_users" name="list_level_users" >
                            @foreach($all_level_users as $level_user)
                                @if($level_user->id > 1)
                                    <option value="{!! $level_user->id !!}">{!! $level_user->level !!}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="show-order">
                            <div class="title-list-order">List ordered</div>
                            <ul class="list-ordered">

                            </ul>
                        </div>
                        <label for="order_lesson">
                            Step section
                        </label>
                        <input type="number" class="form-control" min="1" value="" placeholder="Order 0" id="order_lesson" name="order_lesson" required>
                    </div>
                    <div class="form-group">
                        <label for="limit_time">
                            Limit Time!
                        </label>
                        <input type="number" name="limit_time" class="form-control" required id="limit_time" value="0">
                    </div>
                    <div class="form-group">
                        <label for="content">
                            Nội dung
                        </label>
                        <textarea name="editor_quiz" id="contentQuiz" rows="10" cols="80">
                        </textarea>
                        <script>
                            // Replace the <textarea id="editor1"> with a CKEditor
                            // instance, using default configuration.
                            CKEDITOR.replace( 'editor_quiz' );
                        </script>
                    </div>
                </div>
            </div>
            <div class="control-step-area">
                <button type="button" class="btn btn-success btn-prev-step-post btn-custom-step">
                    Prev
                </button>
                <button type="button" class="btn btn-success btn-next-step-answer btn-custom-step">
                    Next
                </button>
            </div>
        </div>
        <div class="row step-answer-key hidden-class">
            <div class="page-upload row">
                <div class="inner-page-upload panel-container col-md-8">
                    <div class="upload-left-panel-custom panel-left upload-panel-top card highlight-sandbox col-md-8">
                        <div class="card-header">
                            <h3 class="text-left">
                                Highlight đáp án!
                            </h3>
                        </div>
                        <div class="card-block">
                            <div id="sandbox"> </div>
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
                <button type="button" class="btn btn-success btn-prev-step-quiz btn-custom-step">
                    Prev
                </button>
                <button type="button" class="btn btn-success btn-next-step-preview btn-custom-step">
                    Next
                </button>
            </div>
        </div>
        <div class="row step-preview-post hidden-class">
            <div class="col-md-6 card preview-post">
                <div class="card-header">
                    <h3 class="text-left">
                        Noi dung Post!
                    </h3>
                </div>
                <div class="card-block">
                    <div id="pr-post"> </div>
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
                <button type="button" class="btn btn-success btn-prev-step-answer btn-custom-step">
                    Prev
                </button>
                <button type="submit" class="btn btn-danger btn-finish-steps btn-custom-step">
                    Submit
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('public/js/admin/adminCreateNewItemFunctions.js')}}"></script>
    <script src="{{asset('public/js/admin/adminGetDataFunctions.js')}}"></script>
    <script src="{{asset('public/js/admin/readingUploadNewLesson.js')}}"></script>
    <script src="{{asset('public/js/client/readingSolutionDetail.js')}}"></script>
@endsection

