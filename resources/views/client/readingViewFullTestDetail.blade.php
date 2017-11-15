<?php
/**
 * Created by PhpStorm.
 * User: nobikun1412
 * Date: 15/11/2017
 * Time: 10:20 AM
 */
?>
@extends('layout.masterNoFooterClient')
@section('meta-title')
    Full Test - {!! $lesson_detail->title !!}
@endsection
@section('css')

@endsection

@section('titleTypeLesson')
    {!! $lesson_detail->title !!}
@endsection

@section('typeLessonHeader')
    {{--{!! $lesson->typeQuestion->name !!}--}}
@endsection

@section('content')
    <div class="container lesson-detail-page page-custom" data-level-lesson-id="{!! $level_lesson_id !!}" data-type-lesson-id="{!! $type_lesson_id !!}" data-type-question-id="{!! $type_question_id_current !!}">
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
        <div class="overlay-lesson">
            <div class="row-fluid header-product outer-banner-custom">
                <div class="breadcrumb-header middle-banner-custom">
                    <div class="content-breadcrumb-header content-banner-custom">
                        <div class="info-overview">
                            <div class="badge badge-primary countdown-time-overview">
                                {!! $lesson_detail->limit_time !!} mins
                            </div>
                            <h4 class="reading-title-start">
                                Are you ready?
                            </h4>
                            <button type="button" class="btn btn-outline-danger btn-reading-start-test">START</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach($paragraphs as $key_paragraph => $paragraph)
            <div class="lesson-detail panel-container hidden" data-order-paragraph="{!! $paragraph->order_paragraph !!}" data-paragraph-id="{!! $paragraph->id !!}">
                <div class="left-panel-custom panel-left panel-top" id="lesson-content-area" data-lesson-id="{!! $lesson_detail->id !!}">
                    {!! $paragraph->content_lesson !!}
                </div>
                <div class="splitter">
                </div>
                <div class="splitter-horizontal">
                </div>
                <div class="right-panel-custom panel-right panel-bottom" id="quiz-test-area" data-quizId="{!! $lesson_detail->id !!}" data-limit-time="{!! $lesson_detail->limit_time !!}">
                    {!! $paragraph->content_quiz !!}
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script src="{{asset('public/js/client/lessonDetail.js')}}"></script>
    <script src="{{asset('public/libs/countdown/jquery.countdown.js')}}"></script>
    <script type="text/javascript">
        var limit_time = <?php print_r($lesson_detail->limit_time); ?>;
        $('.btn-reading-start-test').click(function () {
            isStart = true;
            var limit_time_quiz = new Date().getTime() + limit_time*60000;
            $('.lesson-detail').removeClass('hidden');
            $('.overlay-lesson').addClass('overlay-lesson-active');
            $('.right-panel-custom').addClass('active-quiz');
            $('html,body').animate({
                scrollTop: 0
            }, 500);
            $('.countdown-time').css('display', 'block');
            $('.countdown-time').countdown(limit_time_quiz, function(event) {
                $(this).html(event.strftime('%M:%S'))
            })
                .on('finish.countdown', function(event) {
                    var result_quiz = getAnsweredQuestionOverview();
                    var dialog = bootbox.dialog({
                        title: 'End time!',
                        message:    '<h5 class="title-auto-submit">You answered <span class="result-test">' + result_quiz + '</span> questions</h5>' +
                        '<p><i class="fa fa-spin fa-spinner"></i> Your result is submitting...</p>',
                        closeButton: false
                    });
                    dialog.init(function(){
                        $('.menu-left-stick').addClass('hidden');
                        $('.reading-tool-lesson-quiz').addClass('hidden');
                        setTimeout(function(){
                            submitReadingTest();
                        }, 3000);
                    });

                });
            $('.reading-tool-lesson-quiz').removeClass('hidden');
        });
    </script>
@endsection

