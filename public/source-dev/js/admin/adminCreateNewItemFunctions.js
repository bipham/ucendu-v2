/**
 * Created by BiPham on 10/11/2017.
 */
function checkStepPost() {
    if (title_post == '') {
        bootbox.alert({
            message: "Please enter name the post!",
            backdrop: true
        });
        return false;
    }
    else if (isFinishTest) {
        bootbox.alert({
            message: "This test was finished with 3 paragraphs, pls choose another test!",
            backdrop: true
        });
        return false;
    }
    // else if (img_name == '') {
    //     bootbox.alert({
    //         message: "Please select image feature!",
    //         backdrop: true
    //     });
    //     return false;
    // }
    else if (CKEDITOR.instances["contentPost"].getData() == '') {
        bootbox.alert({
            message: "Please enter the content of post!",
            backdrop: true
        });
        return false;
    }
    else return true;
}

function checkStepQuiz() {
    if (type_lesson_id == 4) {
        if (order_paragraph > 3 || order_paragraph < 1) {
            bootbox.alert({
                message: "Please enter the order paragraph from 1 to 3!",
                backdrop: true
            });
            return false;
        }
    }
    if (CKEDITOR.instances["contentQuiz"].getData() == '') {
        bootbox.alert({
            message: "Please enter the content of quiz!",
            backdrop: true
        });
        return false;
    }
    else if (level_user_id == 0) {
        bootbox.alert({
            message: "Please select level user!",
            backdrop: true
        });
        return false;
    }
    else if (order_lesson == 0) {
        bootbox.alert({
            message: "Please enter the order lesson!",
            backdrop: true
        });
        return false;
    }
    else if (limit_time == 0) {
        if (type_lesson_id > 1) {
            bootbox.alert({
                message: "Please enter limit time!",
                backdrop: true
            });
            return false;
        }
        else return true;
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

        var type_question_key = '';

        if (type_lesson_id > 2) {
            type_question_key = $('.sl-type-question-' + qorder).val();
        }
        else {
            type_question_key = type_question_id;
        }

        if (type_question_key != null) {
            list_type_questions[qnumber] = type_question_key;
        }
        else {
            delete list_type_questions[qnumber];
        }
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