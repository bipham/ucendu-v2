<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 7/18/2017
 * Time: 8:30 PM
 */
//dd($practice_lessons);
?>
@extends('layout.masterNoFooterClient')
@section('meta-title')

@endsection
@section('css')

@endsection

@section('titleTypeLesson')
    {!! $lesson->title !!}
@endsection

@section('typeLessonHeader')
    {!! $lesson->typeQuestion->name !!}
@endsection

@section('content')
    <div class="container lesson-detail-page page-custom" data-level-lesson-id="{!! $level_lesson_id !!}" data-type-lesson-id="{!! $type_lesson_id !!}" data-type-question-id="{!! $type_question_id_current !!}">
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
        <div class="overlay-lesson">
            <div class="row-fluid header-product outer-banner-custom">
                <div class="breadcrumb-header middle-banner-custom">
                    <div class="content-breadcrumb-header content-banner-custom">
                        @if($type_lesson_id > 0 && $type_lesson_id < 3)
                            <div class="tip-guide">
                                {!! $lesson->typeQuestion->tip_guide !!}
                            </div>
                        @endif
                        <div class="info-overview">
                            <h4 class="reading-title-start">
                                Are you ready?
                            </h4>
                            <button type="button" class="btn btn-outline-danger btn-reading-start-test">START</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lesson-detail panel-container hidden">
            <div class="left-panel-custom panel-left panel-top" id="lesson-content-area" data-lesson-id="{!! $lesson->id !!}">
                {!! $lesson->content_lesson !!}
            </div>
            <div class="splitter">
            </div>
            <div class="splitter-horizontal">
            </div>
            <div class="right-panel-custom panel-right panel-bottom active-quiz" id="quiz-test-area" data-quizId="{!! $lesson->id !!}">
                {!! $lesson->content_quiz !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('public/js/client/lessonDetail.js')}}"></script>
    <script src="{{asset('public/libs/countdown/jquery.countdown.js')}}"></script>
    <script type="text/javascript">
        $('.btn-reading-start-test').click(function () {
            $('.lesson-detail').removeClass('hidden');
            $('.overlay-lesson').addClass('overlay-lesson-active');
            $('.right-panel-custom').addClass('active-quiz');
            $('html,body').animate({
                scrollTop: 0
            }, 500);
            $('.reading-tool-lesson-quiz').removeClass('hidden');
        });
    </script>
@endsection
