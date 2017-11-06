<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 10/11/2017
 * Time: 3:36 PM
 */
?>
@extends('layout.masterNoMenuAdmin')
@section('meta-title')
    Reading - Create New Learning Type Question
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/css/admin/upload.css')}}">
    <script src="/public/libs/ckeditor/ckeditor.js"></script>
@endsection
@section('content')
    <div class="container new-learning-container upload-page-custom" data-idquestion="{!! $last_question_custom_id !!}">
        @include('utils.message')
        {{--@include('errors.input')--}}
        <form role="form" action="{!!url('createNewLearningTypeQuestion')!!}" method="POST">
            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
            <h1 class="title-new-type-action">Create New Learning Type Question</h1>
            <div class="row step-first">
                <div class="form-group">
                    <label for="list_level">
                        Chon level lesson!
                    </label>
                    <select class="form-control" id="list_level" name="list_level" >
                        @foreach($all_levels as $all_level)
                            <option value="{!! $all_level->id !!}">{!! $all_level->level !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="list_type_questions">
                        Chon dạng câu hỏi!
                    </label>
                    <select class="form-control" id="list_type_questions" name="list_type_questions" onchange="getAllTypeQuestionByLevelLessonId()">
                        @foreach($all_type_questions as $type_question)
                            <option value="{!! $type_question->id !!}">{!! $type_question->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="title_section">
                        Title section
                    </label>
                    <input type="text" class="form-control" placeholder="Title section" id="title_section" name="title_section" required>
                </div>
                <div class="form-group">
                    <label for="name_icon_section">
                        Icon section
                    </label>
                    <input type="text" class="form-control" placeholder="fa-cog" id="name_icon_section" name="name_icon_section" required>
                </div>
                <button type="button" class="btn btn-primary btn-next-step-second">
                    Next
                </button>
            </div>
            <div class="row step-second hidden">
                <div class="form-group">
                    <label for="view_layout">
                        View layout
                    </label>
                    <input type="number" class="form-control" min="1" max="2" value="1" placeholder="View layout" id="view_layout" name="view_layout" required>
                </div>
                <div class="form-group">
                    <label for="content_section">
                        Nội dung
                    </label>
                    <textarea id="content_section" rows="10" cols="80" name="content_section"></textarea>
                    <script>
                        CKEDITOR.replace( 'content_section' );
                    </script>
                </div>
                <div class="form-group left-content-group hidden two-layout-content">
                    <label for="left_section">
                        Left content
                    </label>
                    <textarea id="left_section" rows="10" cols="80" name="left_section"></textarea>
                    <script>
                        CKEDITOR.replace( 'left_section' );
                    </script>
                </div>
                <div class="form-group right-content-group hidden two-layout-content">
                    <label for="right_section">
                        Right content
                    </label>
                    <textarea id="right_section" rows="10" cols="80" name="right_section"></textarea>
                    <script>
                        CKEDITOR.replace( 'right_section' );
                    </script>
                </div>
                <div class="btn-area-custom">
                    <button type="button" class="btn btn-primary btn-prev-step-first">
                        Prev
                    </button>
                    <button type="button" class="btn btn-primary btn-next-step-third">
                        Next
                    </button>
                </div>
            </div>
            <div class="row step-third hidden">
                <div class="form-group">
                    <label for="step_section">
                        Step section
                    </label>
                    <input type="number" class="form-control" min="1" value="" placeholder="Step 0" id="step_section" name="step_section" required>
                </div>
                <div class="col-md-8 card preview-content-quiz">
                    <div class="card-header">
                        <h3 class="text-left">
                            Nội dung:
                        </h3>
                    </div>
                    <div class="card-block">
                    </div>
                </div>
                <div class="col-md-4 answer-key-area">
                    <div class="card-header">
                        <h3 class="text-left">
                            Đáp án:
                        </h3>
                    </div>
                    <div class="card-block">
                        <h6 class="no-question">No Question!</h6>
                        <div class="answer-area">

                        </div>
                    </div>
                </div>
                <div class="btn-area-custom">
                    <button type="button" class="btn btn-primary btn-prev-step-second">
                        Prev
                    </button>
                    <button type="button" class="btn btn-warning btn-create-new-section-type-question">
                        Create section
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('public/js/admin/adminCreateNewItemFunctions.js')}}"></script>
    <script src="{{asset('public/js/admin/adminGetDataFunctions.js')}}"></script>
    <script src="{{asset('public/js/admin/readingNewLearningTypeQuestion.js')}}"></script>
@endsection

