/**
 * Created by BiPham on 7/18/2017.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('[name="_token"]').val()
    }
});
var baseUrl = document.location.origin;
var list_answer = {};
var lesson_id = $('#lesson-content-area').data('lesson-id');
var type_lesson_id = $('.lesson-detail-page').data('type-lesson-id');
var level_lesson_id = $('.lesson-detail-page').data('level-lesson-id');
$('.btn-submit-quiz').click(function () {
    submitReadingTest();
});

$('.question-quiz').on('change', function () {
   var answered_val = $(this).val();
   var question_order = $(this).attr('name').match(/\d+/);
   $('.answered-question-' + question_order).val(answered_val);
   if ($('.answered-question-' + question_order).val() != '') {
       $('.answered-question-' + question_order).addClass('answered');
   }
   else {
       $('.answered-question-' + question_order).removeClass('answered');
   }
});

$('.question-quiz').on('keyup', function () {
    var answered_val = $(this).val();
    var question_order = $(this).attr('name').match(/\d+/);
    $('.answered-question-' + question_order).val(answered_val);
    if ($('.answered-question-' + question_order).val() != '') {
        $('.answered-question-' + question_order).addClass('answered');
    }
    else {
        $('.answered-question-' + question_order).removeClass('answered');
    }
});

function getAllAnswer() {
    $('#quiz-test-area .question-quiz').each(function () {
        var qnumber = $(this).data('qnumber');
        var qorder = $(this).attr('name');
        qorder = qorder.match(/\d+/);
        if ($(this).hasClass('question-radio')) {
            if ($(this).is(':checked')) {
                var answer_key = $(this).val();
                if (answer_key != '') {
                    list_answer[qnumber] = answer_key;
                }
                else {
                    delete list_answer[qnumber];
                }
            }
        }
        else if ($(this).hasClass('question-checkbox')) {
            if ($(this).is(':checked')) {
                var answer_key = $(this).val();
                if (answer_key != '') {
                    if (qnumber in list_answer) {
                        list_answer[qnumber] += ' %26 ' + answer_key;
                    }
                    else {
                        list_answer[qnumber] = answer_key;
                    }
                    // list_answer[qnumber] = answer_key;
                }
                else {
                    delete list_answer[qnumber];
                }
            }
        }
        else if ($(this).hasClass('question-input')) {
            var answer_key = $(this).val().trim();
            if (answer_key != '') {
                list_answer[qnumber] = answer_key;
            }
            else {
                delete list_answer[qnumber];
            }
        }
        else if ($(this).hasClass('question-select')) {
            var answer_key = $(this).val();
            if (answer_key != '') {
                list_answer[qnumber] = answer_key;
            }
            else {
                delete list_answer[qnumber];
            }
        }
    });
}

function submitReadingTest() {
    list_answer = {};
    getAllAnswer();
    if (Object.keys(list_answer).length == 0) {
        list_answer = 'emptyList';
    }
    var ajaxUrlResult = baseUrl + '/reading/' + level_lesson_id + '/getResultReadingLesson/' + type_lesson_id + '-' + lesson_id;
    $.ajax({
        type: "GET",
        url: ajaxUrlResult,
        dataType: "json",
        data: { list_answer: list_answer},
        success: function (data) {
            location.href= baseUrl + '/reading/' + level_lesson_id + '/readingViewResultLesson/' + type_lesson_id + '-' + lesson_id + '?list_answer=' + JSON.stringify(list_answer) + '&correct_answer=' + JSON.stringify(data.correct_answer) + '&total_questions=' + data.total_questions;
        },
        error: function (data) {
            console.log('Error:', data);
            bootbox.alert({
                message: "Error, please contact admin!",
                backdrop: true
            });
        }
    });
}

function focusQuestion(i) {
    $('#readingReviewQuizModal').modal('hide');
    $('#readingReviewQuizModal').on('hidden.bs.modal', function (e) {
        // do something...
        $('.right-panel-custom').animate({
            scrollTop: $(".question-"+i).offset().top - 150
        },1);
        $(".question-"+i)[0].focus();
    });
}

function getAnsweredQuestionOverview() {
    var total_question = 0;
    var answered_question = 0;
    $('.review-question-quiz').each(function(index){
        total_question += 1;
        var answered_class = $(this).find('.answered-question-review');
        if (answered_class.hasClass('answered')) {
            answered_question += 1;
        }
    });
    var result = answered_question + "/" + total_question;
    return result;
}

$('.btn-submit-modal').click(function () {
    var result_quiz = getAnsweredQuestionOverview();
    $('.result-test').html(result_quiz);
});

