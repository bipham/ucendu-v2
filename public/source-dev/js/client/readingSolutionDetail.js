var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
var question_id_noti = getUrlParameter('question');
var comment_id_noti = getUrlParameter('comment');

var mainUrl_tmp = baseUrl.substring(7);
var adminBaseUrl = 'http://admin.' + mainUrl_tmp;

$(document).ready(function() {
    var question_order_noti = $('.show-explanation-' + question_id_noti).data('qorder');
    jQuery(function(){
        if (question_id_noti && comment_id_noti) {
            showExplanation(question_id_noti, question_order_noti, true);
        }
    });
});

$(document).on("keypress","input.reply-cmt",enterComment);