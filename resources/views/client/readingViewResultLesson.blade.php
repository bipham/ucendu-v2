<?php
/**
 * Created by PhpStorm.
 * User: nobikun1412
 * Date: 10/25/2017
 * Time: 4:16 PM
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
    {{--{!! $lesson->typeQuestion->name !!}--}}
@endsection

@section('content')
    <div class="container solution-detail-page page-custom">
        @include('utils.readingViewResultTables')
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
    <script src="{{asset('public/js/client/readingCommentFunctions.js')}}"></script>
    <script src="{{asset('public/js/client/readingSolutionDetail.js')}}"></script>
    <script src="{{asset('public/libs/chart/Chart.min.js')}}"></script>
    <script type="text/javascript">
        var correct_answers = <?php print_r(json_encode($correct_answer)); ?>;
        var total_questions = <?php print_r(json_encode($total_questions)); ?>;
        if (total_questions != 0) {
            var number_correct_answer = correct_answers.length;
            $('.result-overview').html(number_correct_answer + '/' + total_questions);
        }
        var list_answer = <?php print_r(json_encode($list_answer)); ?>;
        $('.question-quiz').each(function () {
            var qnumber = $(this).data('qnumber');
            var qorder = $(this).attr('name');
            var solution_key = $('.explain-area-' + qnumber + ' .key-answer').html();
            qorder = qorder.match(/\d+/);
            var answer_key = list_answer[qnumber];
            if (answer_key) {
                $('.name-answered-' + qorder).html('Your choice');
                $('.view-your-choice-' + qorder).html(answer_key);
            }
            $('.view-solution-question-' + qorder).html(solution_key);

            if(jQuery.inArray(qnumber, correct_answers) !== -1) {
                $('.question-table-' + qorder + ' .selected-false-icon').addClass('hidden');
                $('.question-table-' + qorder + ' .selected-true-icon').removeClass('hidden');
            }

            if ($(this).hasClass('question-radio')) {
                if (answer_key) {
                    $('input[value=' + answer_key + '].question-' + qorder,'#solution-area').prop( "checked", true);
                }
            }
            else if ($(this).hasClass('question-checkbox')) {
                if (answer_key) {
                    var array_answer = answer_key.split(' & ');
                    for (var i = 0; i < array_answer.length; i++) {
                        $('input[value=' + array_answer[i] + '].question-' + qorder,'#solution-area').prop( "checked", true);
                    }

                }
            }
            else if ($(this).hasClass('question-input')) {
                if (answer_key) {
                    $(this).val(answer_key);
                }
            }
            else if ($(this).hasClass('question-select')) {
                if (answer_key) {
                    $(this).val(answer_key);
                }
            }
        });
        $('.explain-area').each(function () {
            var qnumber = $(this).data('qnumber');
            if(jQuery.inArray(qnumber, correct_answers) !== -1) {
                $('.explain-area-' + qnumber + ' .show-answer .btn-show-answer').after('<i class="fa selected-true-icon fa-check-circle-o" aria-hidden="true"></i>');
            }
            else {
                $('.explain-area-' + qnumber + ' .show-answer .btn-show-answer').after('<i class="fa selected-false-icon fa-times-circle-o" aria-hidden="true"></i>');
            }
        });

        //Canvas Chart:
        var ctx = document.getElementById("myChartReadingScore").getContext('2d');
        var total_q = $('.stats-total-question .stats-value').html();
        var correct_q = $('.stats-correct .stats-value').html();
        var incorrect_q = $('.stats-incorrect .stats-value').html();
        var unanswered_q = $('.stats-unanswered .stats-value').html();
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Total", "Correct", "Incorrect", "No choice"],
                datasets: [{
                    label: '# Total questions',
                    data: [total_q, correct_q, incorrect_q, unanswered_q],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255,99,132,1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
@endsection

