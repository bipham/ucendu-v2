/**
 * Created by BiPham on 10/13/2017.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('[name="_token"]').val()
    }
});

// Define variable:
var baseUrl = document.location.origin;
var mainUrl = baseUrl.substring(13);
var question_number_input = 1;
var number_select_option = '';
var type_question_select = 'A B C';
var value_checkbox_option = 'A';
var value_radio_option = 'A';
var in_question = false;
var in_radio_question = false;
var in_checkbox_question = false;
var html_table = '<table border="1" cellpadding="1" cellspacing="1" style="width:100%;">' +
    '<tbody>' +
    '<tr>' +
    '<td>Words in question</td>' +
    '<td>Similar words in passage</td>' +
    '</tr>' +
    '<tr>' +
    '<td>' +
    '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>' +
    '</td>' +
    '<td>' +
    '<p>&nbsp;</p>' +
    '</td>' +
    '</tr>' +
    '</tbody>' +
    '</table>';