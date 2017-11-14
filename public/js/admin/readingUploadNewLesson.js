/**
 * Created by BiPham on 7/9/2017.
 */
var content_post = '';
var content_highlight = '';
var content_quiz = '';
var content_answer_quiz = '';
var limit_time = 0;
var level_user_id = 0;
var level_lesson_id = 0;
var order_lesson = 0;
var order_paragraph = 0;
var type_question = '';
var type_question_options = '';
var type_lesson = 1;
var title_post = '';
var img_url = '';
var img_name = '';
var img_name_no_ext = '';
var img_extension = '';
var listQ = [];
var listAnswer = {};
var listKeyword = {};
var list_type_questions = {};
var listClassKeyword = {};
var listAnswer_source = {};
var listKeyword_source = {};
var list_type_questions_source = {};
var type_question_id = '';
var i = '';
var idremove = '';
var listHl = [];
var noti = false;
var sandbox = document.getElementById('sandbox');
var boolRemove = false;
var isFinishTest = false;
var lesson_id = 0;
var last_lesson_id = $('.upload-new-leson-page').data('last-lesson-id');
var type_lesson_id = $('.upload-new-leson-page').data('type-lesson-id');
var ajaxUploadFinish = baseUrl + '/createNewReadingLesson/' + type_lesson_id;

var hltr = new TextHighlighter(sandbox, {
    onBeforeHighlight: function (range) {
        i = prompt("Higlight for answer number:", "");
        console.log('i: ' + i);
        if (i) {
            hltr.options['highlightedClass'] ='answer-highlight highlight-' + i;
            if (jQuery.inArray(i, listHl) == -1) {
                listHl.push(i);
            }
            return true;
        }
        else return false;
    },
    onAfterHighlight: function (range, hlts) {
        var qnumber = $('.answer-' + i).data('qnumber');
        $('.highlight-' + i).attr('data-qnumber', qnumber);
        var idClass = 'hl-answer-' + qnumber;
        $('.highlight-' + i).attr('id', idClass);
        if ($('.remove-ans-' + i).length == 0) {
            $('.remove-highlight-area-' + i).append('<div class="remove-ans-' + i + '">Remove highlight for anwser ' + i + ': <button class="btn btn-info remove" data-removeid="' + i + '">Remove</button></div>');
        }
    },
    onRemoveHighlight: function (hl) {
        var clcus = 'answer-highlight highlight-' + idremove;
        if (hl.className == clcus) {
            if (!noti) {
                boolRemove = window.confirm('Do you really want to remove: "' + hl.className + '"');
                noti = true;
            }
            console.log('bnool: ' + boolRemove);
            if (boolRemove) {
                $('.remove-ans-' + idremove).remove();
                return true;
            }
        }
        else return false;
    }
});

$( document ).ready(function() {
    content_post = CKEDITOR.instances["contentPost"].getData();
    content_quiz = CKEDITOR.instances["contentQuiz"].getData();
    $('.btn-next-step-quiz').click(function () {
        if (type_lesson_id == 4) {
            lesson_id = $("#list_lesson").val().trim();
            title_post = $("#list_lesson option:selected").text().trim();
            if (lesson_id == 0) {
                bootbox.alert({
                    message: "Pls create new full test!",
                    backdrop: true
                });
                return false;
            }
        }
        else title_post = $('input#itemname').val();
        var current_order_lesson = 1;
        level_lesson_id = $('#list_level').val().trim();
        if (level_lesson_id == 0) {
            bootbox.alert({
                message: "Pls select level lesson!",
                backdrop: true
            });
        }
        else {
            level_lesson_id = $('#list_level').val().trim();
            if (type_lesson_id < 3) {
                type_question_id = $('#list_type_questions').val().trim();
            }
            else {
                type_question_id = $('#list_level').val().trim();
            }
            //Get ALl Order Para Full Test:
            if (type_lesson_id == 4) {
                var current_order_paragraph = 1;
                var ajaxGetAllOrderParagraphOfFullTest = baseUrl + '/getAllOrderParagraphOfFullTest/' + lesson_id;
                $.ajax({
                    type: "GET",
                    url: ajaxGetAllOrderParagraphOfFullTest,
                    dataType: "json",
                    // data: {},
                    success: function (data) {
                        $('#loading').hide();
                        $('.list-ordered-paragraph').html('');
                        isFinishTest = false;
                        if (data.all_paragraph_orders.length >= 3) {
                            isFinishTest = true;
                        }
                        else {
                            jQuery.each( data.all_paragraph_orders, function( key_order_paragraph, order_paragraph ) {
                                $('.list-ordered-paragraph').append('<li>' + order_paragraph.order_paragraph + '</li>');
                                current_order_paragraph = order_paragraph.order_paragraph + 1;
                            });
                            $('#order_paragraph').val(current_order_paragraph);
                        }
                    },
                    error: function (data) {
                        $('#loading').hide();
                        bootbox.alert({
                            message: "Get ordered paragraph fail!",
                            backdrop: true
                        });
                    }
                });
            }
            else {
                var ajaxGetAllOrdered = baseUrl + '/getAllOrdered/' + type_lesson_id + '-' + type_question_id;
                $.ajax({
                    type: "GET",
                    url: ajaxGetAllOrdered,
                    dataType: "json",
                    // data: {},
                    success: function (data) {
                        $('#loading').hide();
                        $('.list-ordered').html('');
                        jQuery.each( data.all_orders, function( key_order, order ) {
                            $('.list-ordered').append('<li>' + order.order_lesson + '</li>');
                            current_order_lesson = order.order_lesson + 1;
                        });
                        $('#order_lesson').val(current_order_lesson);
                    },
                    error: function (data) {
                        $('#loading').hide();
                        bootbox.alert({
                            message: "Get ordered fail!",
                            backdrop: true
                        });
                    }
                });
            }

            var checkDataStepPost = checkStepPost();
            if (checkDataStepPost) {
                $('.step-content-post').addClass('hidden-class');
                $('.step-content-quiz').removeClass('hidden-class');
            }
        }
    });

    $('.btn-prev-step-post').click(function () {
        $('.step-content-quiz').addClass('hidden-class');
        $('.step-content-post').removeClass('hidden-class');
    });

    $('.btn-next-step-answer').click(function () {
        level_user_id = $('#list_level_users').val().trim();
        order_lesson = $('#order_lesson').val().trim();
        limit_time = $('#limit_time').val().trim();
        if (type_lesson_id == 4) {
            order_paragraph = $('#order_paragraph').val().trim();
        }
        var checkDataStepQuiz = checkStepQuiz(level_user_id, order_lesson);
        if (checkDataStepQuiz) {
            if ((content_quiz != CKEDITOR.instances["contentQuiz"].getData()) || (type_lesson != $('#typeLesson').val()) ) {
                content_quiz = CKEDITOR.instances["contentQuiz"].getData();
                $('.preview-content-quiz .card-block').html(content_quiz);
                $('.answer-area').html('');
                listQ = [];
                $('.question-quiz').each(function () {
                    var qnumber = $(this).data('qnumber');
                    if (jQuery.inArray(qnumber, listQ) == -1) {
                        listQ.push(qnumber);
                        var qorder = $(this).attr('name');
                        qorder = qorder.match(/\d+/);
                        if (type_lesson_id < 3) {
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
                        }
                        else {
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
                                '<div class="enter-type-question row-enter-custom">' +
                                '<label for="select-type-question-' + qnumber + '" data-qnumber="' + qnumber + '"><strong>Chọn Loai cau hoi</strong></label> ' +
                                '<select class="form-control single-type-question sl-type-question-' + qorder + '" data-qnumber="' + qnumber + '" name="select-type-question-' + qnumber + '"> ' +
                                type_question_options +
                                '</select>' +
                                '</div>' +
                                '<div class="remove-highlight-area-' + qorder + '">' +
                                '</div>' +
                                '</div>');
                        }
                        CKEDITOR.replace( 'input_explanation_' + qnumber);
                    }
                    if (jQuery.inArray(qnumber, listAnswer_source) == -1) {
                        $('input.answer-q[data-qnumber=' + qnumber + ']').val(listAnswer_source[qnumber]);
                        CKEDITOR.instances['input_explanation_' + qnumber].setData(listKeyword_source[qnumber]);
                        $('.enter-type-question select[data-qnumber=' + qnumber + ']').val(list_type_questions_source[qnumber]);
                    }
                });
            }
            if (listQ.length > 0) {
                $('.step-content-quiz').addClass('hidden-class');
                $('.step-answer-key').removeClass('hidden-class');
            }
            else {
                bootbox.alert({
                    message: "Please enter question of quiz!",
                    backdrop: true
                });
            }
            if (content_post != CKEDITOR.instances["contentPost"].getData()) {
                content_post = CKEDITOR.instances["contentPost"].getData();
                $('.remove-highlight-area').html('');
                $('#sandbox').html(content_post);
            }
        }
    });

    $('.btn-prev-step-quiz').click(function () {
        $('.step-content-quiz').removeClass('hidden-class');
        $('.step-answer-key').addClass('hidden-class');
    });

    $('.btn-prev-step-answer').click(function () {
        $('.step-answer-key').removeClass('hidden-class');
        $('.step-preview-post').addClass('hidden-class');
        $('.answer-highlight').removeClass('hidden-highlight');
        $('.answer-highlight').removeClass('highlighting');
        $('#pr-post').html('');
        $('#pr-quiz').html('');
    });

    $('.btn-next-step-preview').click(function () {
        var checkDataStepAnswer = checkStepAnswer();
        if (checkDataStepAnswer) {
            content_highlight = $('#sandbox').html();
            $('.step-preview-post').removeClass('hidden-class');
            $('.step-answer-key').addClass('hidden-class');
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

    $('.btn-finish-steps').click(function () {
        $('#loading').show();
        $.ajax({
            type: "POST",
            url: ajaxUploadFinish,
            dataType: "json",
            data: { lesson_id: lesson_id, order_paragraph: order_paragraph, level_lesson_id: level_lesson_id, level_user_id: level_user_id, order_lesson: order_lesson, type_question_id: type_question_id, img_url: img_url, img_name_no_ext: img_name_no_ext, img_extension: img_extension, title_post: title_post, list_answer: listAnswer, content_post: content_post, content_highlight: content_highlight, content_quiz: content_quiz, content_answer_quiz: content_answer_quiz, list_type_questions: list_type_questions, listKeyword: listKeyword, limit_time: limit_time },
            success: function (data) {
                $('#loading').hide();
                if (data.result == 'fail-order') {
                    if (type_lesson_id == 4) {
                        bootbox.alert({
                            message: 'Order paragraph is not available!',
                            backdrop: true
                        });
                    }
                    else {
                        bootbox.alert({
                            message: 'Order lesson is not available!',
                            backdrop: true
                        });
                    }
                }
                else {
                    bootbox.alert({
                        message: 'Create new lesson success!',
                        backdrop: true,
                        callback: function(){
                            location.href= baseUrl + '/createNewReadingLesson/' + type_lesson_id;
                        }
                    });
                }
            },
            error: function (data) {
                $('#loading').hide();
                bootbox.alert({
                    message: "Create practice lesson fail!",
                    backdrop: true
                });
            }
        });
    });
});

$(document).on("click", ".remove",function() {
    idremove = $(this).data('removeid');
    noti = false;
    hltr.removeHighlights();
});