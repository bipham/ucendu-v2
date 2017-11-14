/**
 * Created by BiPham on 10/18/2017.
 */
/**
 * Created by BiPham on 8/17/2017.
 */
var baseUrl = document.location.origin;
var mainUrl = baseUrl.substring(13);
var content_lesson_source = '';
var lesson_id = $('.upload-page-custom').data('lesson-id');
var quiz_id = $('.upload-page-custom').data('quiz-id');
var ajaxUpdateContentLessonReading = baseUrl + '/updateContentLessonReading/1-' + lesson_id;
var content_highlight_lesson = '';
var content_highlight = '';
var type_question_id = 0;
var content_quiz = '';
var listQ = [];
var content_answer_quiz ='';
var listClassKeyword = {};
var listAnswer = {};
var listKeyword = {};
var list_type_questions = {};
var listAnswer_source = {};
var listKeyword_source = {};
var list_type_questions_source = {};
var ajaxUpdateQuizReadingReading = baseUrl + '/updateQuizReading/1-' + lesson_id;
var list_Q_old = [];

//Edit Content
function editContentLesson() {
    $('.preview-lesson').addClass('hidden');
    $('.btn-edit-content-lesson').addClass('hidden-class');
    $('.btn-edit-quiz-lesson').addClass('hidden-class');
    $('.edit-quiz-lesson').remove();
    $('.edit-content-lesson').removeClass('hidden');

    content_lesson_source = CKEDITOR.instances["contentLesson"].getData().trim();
}

function editHighlightLesson() {
    if (content_lesson_source != CKEDITOR.instances["contentLesson"].getData().trim()) {
        content_lesson_source = CKEDITOR.instances["contentLesson"].getData().trim();
        $('.card-block.remove-highlight-area').html('');
        $('#sandbox').html(content_lesson_source);
    }
    else {
        $('.hl-btn-content-area.remove-highlight-area').html('');
        $('#sandbox .answer-highlight').each(function () {
            $(this).removeClass('hidden-highlight');
            var class_highlight_order = $(this)[0].classList[1].match(/\d+/);
            if ($('.remove-ans-' + class_highlight_order[0] ).length == 0 ) {
                $('.card-block.remove-highlight-area').append('' +
                    '<div class="remove-ans-' + class_highlight_order[0] + '">Remove highlight for anwser ' + class_highlight_order[0] + ': <button class="btn btn-info remove" data-removeid="' + class_highlight_order[0] + '">Remove</button></div>'
                );
            }
        });
        content_highlight = $('#sandbox-quiz').html();
    }
    $('.edit-highlight').toggleClass('hidden');
    $('.edit-content').toggleClass('hidden');
}

function updateContentLesson() {
    $('#sandbox .answer-highlight').addClass('hidden-highlight');
    content_highlight_lesson = $('#sandbox').html();
    $.ajax({
        type: "POST",
        url: ajaxUpdateContentLessonReading,
        dataType: "json",
        data: { 'content_highlight_lesson': content_highlight_lesson, 'content_lesson_source': content_lesson_source},
        success: function (data) {
            bootbox.alert({
                message: "Update lesson success!",
                backdrop: true,
                callback: function(){
                    location.href= baseUrl + '/managerReadingLesson';
                }
            });
        },
        error: function (data) {
            bootbox.alert({
                message: "Update lesson fail!",
                backdrop: true
            });
        }
    });
}

function stepEditContentLesson() {
    $('.edit-highlight').toggleClass('hidden');
    $('.edit-content').toggleClass('hidden');
}

function editQuizLesson() {
    $('.edit-content-lesson').remove();
    $('.preview-lesson').addClass('hidden');
    $('.edit-quiz-lesson').removeClass('hidden');
    $('.btn-edit-content-lesson').addClass('hidden-class');
    $('.btn-edit-quiz-lesson').addClass('hidden-class');

    $('#sandbox-quiz .answer-highlight').removeClass('hidden-highlight');

    $('#solution-area .question-quiz').each(function () {
        var qnumber = $(this).data('qnumber');
        if (jQuery.inArray(qnumber, listAnswer_source) == -1) {
            listAnswer_source[qnumber] = $('.explain-area-' + qnumber + ' .key-answer').html();
            listKeyword_source[qnumber] = $('#explain-' + qnumber + ' .explanation').html();
            if (listKeyword_source[qnumber] == 'No_keywords') {
                listClassKeyword[qnumber] = 'hidden-class';
                listKeyword_source[qnumber] = '';
            }
            else {
                listClassKeyword[qnumber] = '';
            }
            if (jQuery.inArray(qnumber, list_Q_old) == -1) {
                list_Q_old.push(qnumber);
            }
        }
    });
}

$( document ).ready(function() {
    //Edit Quiz
    $('.btn-next-edit-answer').click(function () {
        var checkDataStepQuiz = checkStepQuiz();
        if (checkDataStepQuiz) {
            if (content_quiz != CKEDITOR.instances["quizLesson"].getData()) {
                content_quiz = CKEDITOR.instances["quizLesson"].getData();
                $('.preview-content-quiz .card-block').html(content_quiz);
                $('.answer-area').html('');
                listQ = [];
                $('.preview-content-quiz .card-block .question-quiz').each(function () {
                    var qnumber = $(this).data('qnumber');
                    if (jQuery.inArray(qnumber, listQ) == -1) {
                        listQ.push(qnumber);
                        var qorder = $(this).attr('name');
                        qorder = qorder.match(/\d+/);
                        $('.answer-area').append(   '<div class="answer-key answer-enter-' + qnumber + '" data-qnumber="' + qnumber + '">' +
                            '<h5 class="title-answer-for-question title-custom">Question ' + qorder + ':</h5>' +
                            '<div class="enter-answer-key row-enter-custom">' +
                            '<div class="title-row-enter">Answer ' + qorder + ': </div>' +
                            '<input class="answer-q answer-' + qorder + '" data-qnumber="' + qnumber + '" />' +
                            '</div>' +
                            '<div class="enter-keyword row-enter-custom">' +
                            '<div class="title-row-enter">Explanation ' + qorder + ': </div>' +
                            '<textarea id="input_explanation_' + qnumber + '" class="input-keyword keyword-' + qorder + '" data-qnumber="' + qnumber + '"></textarea>' +
                            '</div>' +
                            '<div class="remove-highlight-area-' + qorder + '">' +
                            '</div>' +
                            '</div>');
                        CKEDITOR.replace( 'input_explanation_' + qnumber);
                    }
                    if (jQuery.inArray(qnumber, listAnswer_source) == -1) {
                        $('input.answer-q[data-qnumber=' + qnumber + ']').val(listAnswer_source[qnumber]);
                        CKEDITOR.instances['input_explanation_' + qnumber].setData(listKeyword_source[qnumber]);
                    }
                });
            }
            $('#sandbox-quiz .answer-highlight').each(function () {
                $(this).removeClass('hidden-highlight');
                var class_highlight_order = $(this)[0].classList[1].match(/\d+/);
                if ($('.remove-ans-' + class_highlight_order[0] ).length == 0 ) {
                    $('.remove-highlight-area-' + class_highlight_order[0]).append('' +
                        '<div class="remove-ans-' + class_highlight_order[0] + '">Remove highlight for anwser ' + class_highlight_order[0] + ': <button class="btn btn-info remove" data-removeid="' + class_highlight_order[0] + '">Remove</button></div>'
                    );
                }
            });
            if (listQ.length > 0) {
                $('.edit-quiz').toggleClass('hidden');
                $('.edit-answer').toggleClass('hidden');
            }
            else {
                bootbox.alert({
                    message: "Please enter question of quiz!",
                    backdrop: true
                });
            }
        }
    });

    $('.btn-back-edit-quiz').click(function () {
        $('.edit-quiz').toggleClass('hidden');
        $('.edit-answer').toggleClass('hidden');
    });

    $('.btn-next-preview-edit').click(function () {
        type_question_id = $('.upload-page-custom').data('type-question-id');
        var checkDataStepAnswer = checkStepAnswer();
        if (checkDataStepAnswer) {
            content_highlight = $('#sandbox-quiz').html();
            $('.preview-edit-lesson').toggleClass('hidden');
            $('.edit-answer').toggleClass('hidden');
            $('#pr-post').html(content_highlight);
            $('.answer-highlight').addClass('hidden-highlight');
            $('#pr-quiz').html(content_quiz);
            $('#pr-quiz .last-option').each(function () {
                var qnumber = $(this).data('qnumber');
                var qorder = $(this).attr('name');
                qorder = qorder.match(/\d+/);
                var answer_key = $('.answer-' + qorder).val();
                $(this).parent().after( '<div class="explain-area explain-' + qorder + ' explain-area-' + qnumber + '" data-qnumber="' + qnumber + '" data-qorder="' + qorder + '" data-type-question="' + list_type_questions[qnumber] + '">' +
                    '<div class="show-answer">' +
                    '<button type="button" class="btn btn-danger btn-show-answer">Answer ' + qorder + ' ' +
                    '<div class="badge badge-pill key-answer">' +
                    answer_key +
                    '</div>' +
                    '</button>' +
                    '<div class="explain-show' + '" id="explain-' + qnumber +'"> ' +
                    '<button type="button" class="btn btn-primary btn-show-explanation show-explanation-' + qnumber + '" data-qnumber="' + qnumber + '" data-qorder="' + qorder + '" data-type-question="' + list_type_questions[qnumber] + '" onclick="showExplanation(' + qnumber + ',' + qorder + ')">' +
                    '<i class="fa fa-key" aria-hidden="true"></i>' +
                    ' Explanation' +
                    '</button>' +
                    '<div class="hidden explanation">' +
                    listKeyword[qnumber] +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    // '<div class="solution-tools locate-highlight-tool">' +
                    // '<a class="btn btn-xs btn-outline-warning btn-locate-highlight" data-qnumber="' + qnumber +'" onclick="scrollToHighlight(' + qorder + ')">' +
                    // '<i class="fa fa-map-marker" aria-hidden="true"></i>' +
                    // '&nbsp;Locate' +
                    // '</a>' +
                    // '</div>' +
                    // '<div class="solution-tools locate-comment-tool">' +
                    // '<a class="btn btn-xs btn-outline-primary btn-show-comments" data-qnumber="' + qnumber +'" data-toggle="collapse" href="#commentArea-' + qnumber + '" aria-expanded="false" aria-controls="commentArea-' + qnumber + '" onclick="showComments(' + qnumber + ')">' +
                    // '<i class="fa fa-question" aria-hidden="true"></i>' +
                    // '&nbsp;Comments' +
                    // '</a>' +
                    // '</div>' +
                    // '<div class="collapse collage-comments collapse-custom" id="commentArea-' + qnumber +'"> ' +
                    // '<div class="card card-header comments-area-title">QUESTION & ANSWER:' +
                    // '</div>' +
                    // '<div class="card card-block comments-area">' +
                    // '</div>' +
                    // '</div>' +
                    '</div>');
            });
            $('#pr-quiz input').each(function () {
                $(this).attr('disabled', 'disabled');
            });
            $('#pr-quiz select').each(function () {
                $(this).attr('disabled', 'disabled');
            });
            content_answer_quiz =  $('#pr-quiz').html();
            content_highlight = $('#pr-post').html();
        }
        else {
            bootbox.alert({
                message: "Please enter answer of quiz!",
                backdrop: true
            });
        }
    });

    $('.btn-back-edit-answer').click(function () {
        $('.answer-highlight').removeClass('hidden-highlight');
        $('.answer-highlight').removeClass('highlighting');
        $('.preview-edit-lesson').toggleClass('hidden');
        $('.edit-answer').toggleClass('hidden');
    });

    $('.btn-update-quiz-lesson').click(function () {
        $.ajax({
            type: "POST",
            url: ajaxUpdateQuizReadingReading,
            dataType: "json",
            data: { list_Q_old: list_Q_old, list_answer: listAnswer, content_highlight: content_highlight, content_quiz: content_quiz, content_answer_quiz: content_answer_quiz, type_question_id: type_question_id, listKeyword: listKeyword},
            success: function (data) {
                bootbox.alert({
                    message: "Update quiz success!",
                    backdrop: true,
                    callback: function(){
                        location.href= baseUrl + '/managerReadingLesson';
                    }
                });
            },
            error: function (data) {
                bootbox.alert({
                    message: "Update quiz fail!",
                    backdrop: true
                });
            }
        });
    });

});

function checkStepQuiz() {
    if (CKEDITOR.instances["quizLesson"].getData() == '') {
        bootbox.alert({
            message: "Please enter the content of quiz!",
            backdrop: true
        });
        return false;
    }
    else return true;
}

function checkStepAnswer() {
    listAnswer = {};
    listKeyword = {};
    list_type_questions = {};

    $('.preview-content-quiz .card-block .last-option').each(function () {
        var qnumber = $(this).data('qnumber');
        var qorder = $(this).attr('name');
        qorder = qorder.match(/\d+/);
        var answer_key = $('.answer-' + qorder).val().trim();
        var keywords_key = CKEDITOR.instances['input_explanation_' + qnumber].getData();
        if (answer_key != '') {
            listAnswer[qnumber] = answer_key;
        }
        else {
            delete listAnswer[qnumber];
        }
        if (keywords_key == '') {
            keywords_key = 'No_keywords';
            listClassKeyword[qnumber] = 'hidden-class';
        }
        else {
            listClassKeyword[qnumber] = '';
        }
        listKeyword[qnumber] = keywords_key;

        list_type_questions[qnumber] = type_question_id;
    });
    if ((listQ.length == Object.keys(listAnswer).length) && (listQ.length  == Object.keys(list_type_questions).length)) {
        return true;
    }
    else return false;
}

$(document).on("change", "input.answer-q",function() {
    var qnumber = $(this).data('qnumber');
    listAnswer_source[qnumber] = $(this).val();
});

$(document).on("change", ".input-keyword",function() {
    var qnumber = $(this).data('qnumber');
    listKeyword_source[qnumber] = CKEDITOR.instances['input_explanation_' + qnumber].getData();
    if (listKeyword_source[qnumber] == '') {
        listClassKeyword[qnumber] = 'hidden-class';
    }
    else {
        listClassKeyword[qnumber] = '';
    }
});

$(document).on("change", ".enter-type-question select",function() {
    var qnumber = $(this).data('qnumber');
    list_type_questions_source[qnumber] = $(this).val();
});