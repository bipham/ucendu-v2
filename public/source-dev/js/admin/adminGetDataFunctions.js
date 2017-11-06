/**
 * Created by BiPham on 10/13/2017.
 */
var new_title = '';
function getAllTypeQuestionByLevelLessonId(less_id) {
    var ajaxGetAllTypeQuestionByLevelLessonId = baseUrl + '/getTypeQuestionByLevelLessonId';
    var lessID = less_id || '';
    var level_lesson_id = $('#list_level' + lessID).val().trim();
    $.ajax({
        type: "GET",
        url: ajaxGetAllTypeQuestionByLevelLessonId,
        dataType: "json",
        data: { level_lesson_id: level_lesson_id },
        success: function (data) {
            $('#list_type_questions' + lessID).empty();
            type_question_options = '';
            $.each(data.list_type_questions, function (index, type_question) {
                type_question_options += '<option value="' + type_question.id + '">' + type_question.name + '</option>';
            });
            $('#list_type_questions' + lessID).append(type_question_options);
        },
        error: function (data) {
            bootbox.alert({
                message: "FAIL GET ALL TYPE QUESTION!",
                backdrop: true
            });
        }
    });
}

function getAllTypeQuestionFullTestByLevelLessonId(less_id) {
    var lessID = less_id || '';
    getAllTypeQuestionByLevelLessonId(less_id);
    var level_lesson_id = $('#list_level' + lessID).val().trim();
    var ajaxGetListFullTestLessonUpload = baseUrl + '/getListFullTestLessonUploaded/' + level_lesson_id;
    $.ajax({
        type: "GET",
        url: ajaxGetListFullTestLessonUpload,
        dataType: "json",
        success: function (data) {
            $('#list_lesson' + lessID).empty();
            console.log(data.all_uploaded_lessons);
            if (data.all_uploaded_lessons.length > 0) {
                $.each(data.all_uploaded_lessons, function (index, uploaded_lesson) {
                    $('#list_lesson' + lessID).append('<option value="' + uploaded_lesson.id + '">' + uploaded_lesson.title + '</option>');
                });
                $('.create-new-full-test').removeClass('hidden');
            }
            else {
                $('#list_lesson' + lessID).append('<option value="0">Pls create new test</option>');
                $('.create-new-full-test').removeClass('hidden');
            }
            $('.list-ordered').html('');
            var current_order_lesson = 1;
            jQuery.each( data.all_orders, function( key_order, order ) {
                $('.list-ordered').append('<li>' + order.order_lesson + '</li>');
                current_order_lesson = order.order_lesson + 1;
            });
            $('#order_lesson').val(current_order_lesson);
            $('#loading').hide();
        },
        error: function (data) {
            bootbox.alert({
                message: "FAIL GET ALL LESSONS!",
                backdrop: true
            });
        }
    });
}

function createNewFullTest() {
    var level_lesson_id = $('#list_level').val().trim();
    new_title = $('#new_title_full_test').val().trim();
    level_user_id = $('#list_level_users').val().trim();
    order_lesson = $('#order_lesson').val().trim();
    limit_time = $('#limit_time').val().trim();
    var check_data_full_test = checkDataCreateFullTest();
    if (check_data_full_test) {
        var ajaxCreateNewFullTest = baseUrl + '/createNewFullTest';
        $.ajax({
            type: "GET",
            url: ajaxCreateNewFullTest,
            dataType: "json",
            data: {level_lesson_id: level_lesson_id, new_title: new_title, level_user_id: level_user_id, order_lesson: order_lesson, limit_time: limit_time},
            success: function (data) {
                $('#list_lesson option[value=0]').remove();
                $('#list_lesson').append('<option value="' + data.full_test_id + '" selected>' + new_title + '</option>');
                $('#readingCreateNewTitleFullTest').modal('toggle');
                $('#new_title_full_test').val('');
                $('.create-new-full-test').addClass('hidden');
                $('#loading').hide();
            },
            error: function (data) {
                bootbox.alert({
                    message: "Create full test FAIL!",
                    backdrop: true
                });
            }
        });
    }
}

function readURL(input) {
    img_name = $('input[type=file]').val().split('\\').pop();
    img_extension = img_name.substr( (img_name.lastIndexOf('.') + 1) ).toLowerCase();
    img_name_no_ext = img_name.split('.')[0];
    var allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];
    if( allowedExtensions.indexOf(img_extension) == -1 ) {
        bootbox.alert({
            message: "Img not true format!",
            backdrop: true
        });
        $('#imgFeature').val('');
        img_name = '';
        img_name_no_ext = '';
        $("#image-main-preview").attr('src', '#');
        $("#image-main-preview").addClass('hidden-class');
        i++;
        return;
    }
    else {
        img_name = $('input[type=file]').val().split('\\').pop();
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#" + input.name + "-preview")
                    .attr('src', e.target.result)
                    .width(150);
                img_url = e.target.result;
                $("#" + input.name + "-preview").removeClass('hidden-class');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
}

function checkDataCreateFullTest() {
    if (new_title == '') {
        bootbox.alert({
            message: "Please enter new title full test!",
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
        bootbox.alert({
            message: "Please enter limit time!",
            backdrop: true
        });
        return false;
    }
    else return true;
}