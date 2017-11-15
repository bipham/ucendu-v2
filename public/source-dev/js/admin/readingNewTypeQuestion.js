/**
 * Created by nobikun1412 on 15/11/2017.
 */
function submitNewTypeQuestion() {
    var ajaxCreateNewTypeQuestion = baseUrl + '/createNewTypeQuestion';
    var name_type_question = $('#name').val().trim();
    var level_lesson_selected = $('#level-lesson').val().trim();
    var tip_guide = CKEDITOR.instances['tip_guide'].getData();
    if (name_type_question != '' || level_lesson_selected != '') {
        $.ajax({
            type: "POST",
            url: ajaxCreateNewTypeQuestion,
            dataType: "json",
            data: { name_type_question: name_type_question, level_lesson_selected: level_lesson_selected, tip_guide: tip_guide },
            success: function (data) {
                if (data.result == 'success') {
                    bootbox.alert({
                        message: "Create " + data.result + ' - ' + data.message,
                        backdrop: true,
                        callback: function(){
                            location.href= baseUrl + '/createNewTypeQuestion';
                        }
                    });
                }
                else {
                    bootbox.alert({
                        message: "Create " + data.result + ' - ' + data.message,
                        backdrop: true
                    });
                }
            },
            error: function (data) {
                bootbox.alert({
                    message: "FAIL - " + data,
                    backdrop: true
                });
            }
        });
    }
}

function submitUpdateTypeQuestion(type_question_id) {
    var ajaxCreateNewTypeQuestion = baseUrl + '/updateTypeQuestion/' + type_question_id;
    var name_type_question = $('#name').val().trim();
    var level_lesson_selected = $('#level-lesson').val().trim();
    var tip_guide = CKEDITOR.instances['tip_guide'].getData();
    if (name_type_question != '' || level_lesson_selected != '') {
        $.ajax({
            type: "POST",
            url: ajaxCreateNewTypeQuestion,
            dataType: "json",
            data: { name_type_question: name_type_question, level_lesson_selected: level_lesson_selected, tip_guide: tip_guide },
            success: function (data) {
                if (data.result == 'success') {
                    bootbox.alert({
                        message: "Create " + data.result + ' - ' + data.message,
                        backdrop: true,
                        callback: function(){
                            location.href= baseUrl + '/managerTypeQuestion';
                        }
                    });
                }
                else {
                    bootbox.alert({
                        message: "Create " + data.result + ' - ' + data.message,
                        backdrop: true
                    });
                }
            },
            error: function (data) {
                bootbox.alert({
                    message: "FAIL - " + data,
                    backdrop: true
                });
            }
        });
    }
}