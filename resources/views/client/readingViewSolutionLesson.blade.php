<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 10/27/2017
 * Time: 2:03 AM
 */
?>
@extends('layout.masterNoFooterClient')
@section('meta-title')

@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/css/client/readingSolution.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/client/readingNavtabsVertical.css')}}">
@endsection

@section('titleTypeLesson')
    {!! $lesson->title !!}
@endsection

@section('typeLessonHeader')
    {!! $lesson->typeQuestion->name !!}
@endsection

@section('content')
    <div class="container solution-detail-page page-custom">
        @include('utils.readingViewSolutionTable')
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
        <h4 class="title-solution-detail-section">
            Solution Detail
        </h4>
        <div class="solution-detail panel-container transform-custom">
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
        @include('utils.readingExplanation')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('public/js/client/readingSolutionDetail.js')}}"></script>
    <script src="{{asset('public/libs/chart/Chart.min.js')}}"></script>
    <script type="text/javascript">
        $('.result-overview').hide();

        $('.question-quiz').each(function () {
            var qnumber = $(this).data('qnumber');
            var qorder = $(this).attr('name');
            var solution_key = $('.explain-area-' + qnumber + ' .key-answer').html();
            qorder = qorder.match(/\d+/);
            $('.view-solution-question-' + qorder).html(solution_key);
        });
    </script>
@endsection