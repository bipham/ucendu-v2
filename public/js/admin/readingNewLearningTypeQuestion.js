var ajaxFinishCreateNewLearningOfTypeQuestion = baseUrl + '/createNewLearningTypeQuestion';
var ajaxGetAllTypeQuestionByLevelLessonId = baseUrl + '/getTypeQuestionByLevelLessonId';
var view_layout = '';
var content_section = '';
var left_section = '';
var right_section = '';
var option_list_questions = '';
var title_section = '';
var listAnswer = {};
var listKeyword = {};
var listClassKeyword = {};
var listQ = [];
var list_type_questions = {};
var listAnswer_source = {};
var listKeyword_source = {};
var list_type_questions_source = {};
var type_question_id = '';
var i = '';
$( document ).ready(function() {
    content_section = CKEDITOR.instances["content_section"].getData();
    left_section = CKEDITOR.instances["left_section"].getData();
    right_section = CKEDITOR.instances["right_section"].getData();

    $('#view_layout').on('change', function () {
        view_layout = $(this).val().trim();
        if (view_layout == 2) {
            $('.two-layout-content').removeClass('hidden');
            $('.first-layout-content').addClass('hidden');
        }
        else {
            $('.two-layout-content').addClass('hidden');
            $('.first-layout-content').removeClass('hidden');
        }
    });

    $('#list_level').on('change', function () {
        var level_lesson_id = $(this).val().trim();
        $.ajax({
            type: "GET",
            url: ajaxGetAllTypeQuestionByLevelLessonId,
            dataType: "json",
            data: { level_lesson_id: level_lesson_id },
            success: function (data) {
                $('#list_type_questions').empty();
                $('#list_type_questions').append('<option value="' + -level_lesson_id + '">All Of Type</option>');
                $.each(data.list_type_questions, function (index, type_question) {
                    $('#list_type_questions').append('<option value="' + type_question.id + '">' + type_question.name + '</option>');
                })
            },
            error: function (data) {
                bootbox.alert({
                    message: "FAIL GET ALL TYPE QUESTION!",
                    backdrop: true
                });
            }
        });
    });

    $('.btn-create-new-section-type-question').click(function () {
        var step_section = $('#step_section').val().trim();
        var view_layout = $('#view_layout').val().trim();
        var name_icon_section = $('#name_icon_section').val().trim();
        var content_section = CKEDITOR.instances["content_section"].getData().trim();
        var checkDataStepAnswer = checkStepAnswer();
        if (!checkDataStepAnswer || step_section == '') {
            bootbox.alert({
                message: "Please enter data!",
                backdrop: true
            });
        }
        else {
            if (jQuery.isEmptyObject(listAnswer)) {
                listAnswer = 'null';
                listKeyword = 'null';
                list_type_questions = 'null';
            }
            $.ajax({
                type: "POST",
                url: ajaxFinishCreateNewLearningOfTypeQuestion,
                dataType: "json",
                data: { type_question_id: type_question_id, step_section: step_section, view_layout: view_layout, title_section: title_section, name_icon_section: name_icon_section, content_section: content_section, left_section: left_section, right_section: right_section ,list_answer: listAnswer, list_type_questions: list_type_questions, listKeyword: listKeyword },
                success: function (data) {
                    if (data.result == 'fail-step') {
                        bootbox.alert({
                            message: 'Fail! Step section is not available!',
                            backdrop: true,
                        });
                    }
                    else if (data.result == 'fail-title') {
                        bootbox.alert({
                            message: 'Fail! Title section is not available!',
                            backdrop: true,
                        });
                    }
                    else {
                        bootbox.alert({
                            message: 'Create new learning type question success!',
                            backdrop: true,
                            callback: function(){
                                location.href= baseUrl + '/createNewLearningTypeQuestion';
                            }
                        });
                    }
                },
                error: function (data) {
                    bootbox.alert({
                        message: "FAIL CREATE NEW learning OF TYPE QUESTION!",
                        backdrop: true
                    });
                }
            });
        }
    });

    $('.btn-next-step-second').click(function () {
        title_section = $('#title_section').val().trim();
        type_question_id = $('#list_type_questions').val().trim();
        if (title_section == '') {
            bootbox.alert({
                message: "Please enter title section!",
                backdrop: true
            });
        }
        else {
            $('.step-first').addClass('hidden');
            $('.step-second').removeClass('hidden');
            $("html, body").animate({
                scrollTop: $('.new-learning-container').offset().top
            }, 100);
        }
    });

    $('.btn-prev-step-first').click(function () {
        $('.step-second').addClass('hidden');
        $('.step-first').removeClass('hidden');
        $("html, body").animate({
            scrollTop: $('.new-learning-container').offset().top
        }, 100);
    });

    $('.btn-next-step-third').click(function () {
        if ((content_section != CKEDITOR.instances["content_section"].getData()) || (left_section != CKEDITOR.instances["left_section"].getData()) || (right_section != CKEDITOR.instances["right_section"].getData()) ) {
            content_section = CKEDITOR.instances["content_section"].getData();
            left_section = CKEDITOR.instances["left_section"].getData();
            right_section = CKEDITOR.instances["right_section"].getData();
            var content_learning = content_section + left_section + right_section;
            $('.preview-content-quiz .card-block').html(content_learning);
            $('.answer-area').html('');
            listQ = [];
            $('.question-quiz').each(function () {
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
                        '<div class="title-row-enter">Keyword ' + qorder + ': </div>' +
                        '<textarea id="input_explanation_' + qnumber + '" class="input-keyword keyword-' + qorder + '" data-qnumber="' + qnumber + '"></textarea>' +
                        '</div>' +
                        '</div>');
                    CKEDITOR.replace( 'input_explanation_' + qnumber);
                }
                if (jQuery.inArray(qnumber, listAnswer_source) == -1) {
                    $('input.answer-q[data-qnumber=' + qnumber + ']').val(listAnswer_source[qnumber]);
                    if (listKeyword_source[qnumber] == '' || listKeyword_source[qnumber] == undefined || listKeyword_source[qnumber] == null) {
                        CKEDITOR.instances['input_explanation_' + qnumber].setData(html_table);
                    }
                    else {
                        CKEDITOR.instances['input_explanation_' + qnumber].setData(listKeyword_source[qnumber]);
                    }
                    $('.enter-type-question select[data-qnumber=' + qnumber + ']').val(list_type_questions_source[qnumber]);
                }
            });
        }
        console.log('listQ: ' + listQ);
        if (listQ.length > 0) {
            $('.no-question').addClass('hidden-class');
        }
        else {
            $('.no-question').removeClass('hidden-class');
        }
        $('.step-second').addClass('hidden');
        $('.step-third').removeClass('hidden');
        $("html, body").animate({
            scrollTop: $('.new-learning-container').offset().top
        }, 100);
    });

    $('.btn-prev-step-second').click(function () {
        $('.step-third').addClass('hidden');
        $('.step-second').removeClass('hidden');
        $("html, body").animate({
            scrollTop: $('.new-learning-container').offset().top
        }, 100);
    });
});

// Function:
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