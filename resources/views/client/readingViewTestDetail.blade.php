<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 7/18/2017
 * Time: 8:30 PM
 */
?>
@extends('layout.masterNoFooterClient')
@section('meta-title')
    Mix Test - {!! $lesson->title !!}
@endsection
@section('css')

@endsection

@section('titleTypeLesson')
    {!! $lesson->title !!}
@endsection

@section('typeLessonHeader')
    {{--{!! $lesson->typeQuestion->name !!}--}}
@endsection

@section('content')
    <div class="container lesson-detail-page page-custom" data-level-lesson-id="{!! $level_lesson_id !!}" data-type-lesson-id="{!! $type_lesson_id !!}" data-type-question-id="{!! $type_question_id_current !!}>
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
        <div class="overlay-lesson">
            <div class="row-fluid header-product outer-banner-custom">
                <div class="breadcrumb-header middle-banner-custom">
                    <div class="content-breadcrumb-header content-banner-custom">
                        <div class="info-overview">
                            <div class="badge badge-primary countdown-time-overview">
                                {!! $lesson->limit_time !!} mins
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
        <div class="lesson-detail panel-container hidden">
            <div class="left-panel-custom panel-left panel-top" id="lesson-content-area" data-lesson-id="{!! $lesson->id !!}">
                {!! $lesson->content_lesson !!}
            </div>
            <div class="splitter">
            </div>
            <div class="splitter-horizontal">
            </div>
            <div class="right-panel-custom panel-right panel-bottom" id="quiz-test-area" data-quizId="{!! $lesson->id !!}" data-limit-time="{!! $lesson->limit_time !!}">
                {!! $lesson->content_quiz !!}
                <div class="reading-end-lesson end-lesson-area">
                    <h4 class="title-end-lesson">
                        --- End of the Test ---
                    </h4>
                    <h5 class="recomment-submit-lesson">
                        Please Submit to view your score, solution and explanations.
                    </h5>
                    <button type="submit" class="btn btn-danger btn-submit-modal btn-custom" data-toggle="modal" data-target="#readingSubmitQuizModal">
                        Submit
                    </button>
                    <div class="found-mistake">
                        <a href="#" class="send-mistake">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            Found a mistake? Let us know!
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('public/js/client/lessonDetail.js')}}"></script>
    <script src="{{asset('public/libs/countdown/jquery.countdown.js')}}"></script>
    <script type="text/javascript">
        var limit_time = <?php print_r($lesson->limit_time); ?>;
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
