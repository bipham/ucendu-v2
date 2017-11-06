var isCreateReplyComment = false;
var isExpanded = [];
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

console.log('question_id_noti ' + baseUrl);
console.log('comment_id_noti ' + comment_id_noti);

let mainUrl_tmp = baseUrl.substring(7);
let adminBaseUrl = 'http://admin.' + mainUrl_tmp;

// $(document).on("keypress","input.reply-cmt",enterComment);

$(document).ready(function() {
    jQuery(function(){
        if (question_id_noti && comment_id_noti) {
            showComments(question_id_noti, true);
            $('#commentArea-' + question_id_noti).collapse();
        }
    });

    $('.btn-show-explanation').click(function () {

    });
});

function showExplanation(question_custom_id, question_order, isTrigger) {
    "use strict";
    isTrigger = isTrigger || false;
    let ajaxShowExplanation = baseUrl + '/showExplanation/' + question_custom_id;
    $.ajax({
        type: "GET",
        url: ajaxShowExplanation,
        dataType: "json",
        success: function (data) {
            $('.title-explanation').html('EXPLANATION - Question ' + question_order);
            $('.explanation-detail').html(data.explanation);
            $('.solution-detail').addClass('transform-scale-width-custom-active');
            $('.explanation-column').removeClass('hidden');
            $('.explanation-column').addClass('transform-right-custom-active');

            //Scroll To highlight:
            let last_highlight = $('.highlighting');
            last_highlight.removeClass('highlighting');
            last_highlight.addClass('hidden-highlight');
            $('.highlight-' + question_order).removeClass('hidden-highlight');
            $('.highlight-' + question_order).addClass('highlighting');
            $("html, body").animate({
                scrollTop: $('.panel-container').offset().top
            }, 100);
            let idClass = 'highlight-' + question_order;
            let t_l = 60;
            let r_l = $(".left-panel-custom").offset().top;
            let u_l = $("."+idClass).offset().top;
            let f_l = $(".left-panel-custom").scrollTop();
            let v_l = u_l + f_l - r_l;
            $(".left-panel-custom").animate({
                scrollTop: v_l - t_l
            }, {
                duration: 100,
                complete: function () {
                }
            });

            //Show comments:
            console.log('sucess:', data);
            $('#commentArea .comments-area').html('');
            if (data.list_comments.length > 0) {
                jQuery.each( data.list_comments, function( index, list_comment ) {
                    let avatar = list_comment.avatar;
                    let cmt_content = list_comment.content_cmt;
                    let time_ago = list_comment.updated_at;
                    let cmt_id = list_comment.id;
                    let question_id = list_comment.question_id;
                    let username = list_comment.username;
                    let reply_id = list_comment.reply_id;
                    let isPrivated = '';
                    let isPublic = '';
                    let status_class = 'item-cmt-public';
                    if (list_comment.private == 1) {
                        isPrivated = 'disabled';
                        status_class = 'item-cmt-private';
                    }
                    else {
                        isPublic = 'disabled';
                    }

                    if (data.current_user_info.level_user_id == 1) {
                        if (reply_id == 0) {
                            $('#commentArea .comments-area').append('<div class="row list-cmt-area list-cmt-' + cmt_id + '" data-cmt-id="' + cmt_id + '">' +
                                '<div class="item-cmt cmt-' + cmt_id + ' ' + status_class + '" id="comment' + cmt_id + '" data-cmt-id="' + cmt_id + '">'
                                + '<span class="img-avatar">'
                                + '<img alt="" src=' + avatar + '"/public/storage/img/users/" class="img-custom avatar-custom" />'
                                + '</span>'
                                + '<span class="item-cmt-content">'
                                + '<div class="item-cmt-header">'
                                +  username
                                + '</div>'
                                + '<div class="item-cmt-body">'
                                +  cmt_content
                                + '</div>'
                                + '<div class="item-time-cmt">'
                                + '<span class="img-time-cmt">'
                                + '<img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" />'
                                + '</span>'
                                + '<span class="time-ago-cmt">'
                                + time_ago
                                + '</span>'
                                + '<span class="reply-cmt pull-right">'
                                + '<button type="button" class="btn btn-success btn-admin-custom btn-set-comment-public" data-id="' + cmt_id + '" data-question-id="' + question_id + '" data-reply-id="' + reply_id + '" onclick="setPublicReadingComment(' + cmt_id + ')"' + isPublic + '>Set public</button>'
                                + '<button type="button" class="btn btn-warning btn-admin-custom btn-set-comment-private" data-id="' + cmt_id + '" data-question-id="' + question_id + '" data-reply-id="' + reply_id + '" onclick="setPrivateReadingComment(' + cmt_id + ')"' + isPrivated + '>Set private</button>'
                                + '<button type="button" class="btn btn-danger btn-admin-custom btn-del-lesson" data-id="' + cmt_id + '" data-question-id="' + question_id + '" data-reply-id="' + reply_id + '" onclick="deleteReadingComment(' + cmt_id + ')">Del</button>'
                                + '<button type="button" class="btn btn-reply-cmt btn-sm btn-outline-primary" onclick="replyComment(' + cmt_id + ', ' + i + ')">Reply</button>'
                                + '</span>'
                                + '</div>'
                                + '</span>'
                                + '</div>'
                                + '</div>');
                        }
                        else {
                            $('.list-cmt-' + reply_id).append('<div class="item-cmt item-sub-cmt cmt-' + cmt_id + ' ' + status_class + '" id="comment' + cmt_id + '" data-cmt-id="' + cmt_id + '">'
                                + '<span class="img-avatar">'
                                + '<img alt="" src=' + avatar + '"/public/storage/img/users/" class="img-custom avatar-custom" />'
                                + '</span>'
                                + '<span class="item-cmt-content">'
                                + '<div class="item-cmt-header">'
                                +  username
                                + '</div>'
                                + '<div class="item-cmt-body">'
                                +  cmt_content
                                + '</div>'
                                + '<div class="item-time-cmt">'
                                + '<span class="img-time-cmt">'
                                + '<img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" />'
                                + '</span>'
                                + '<span class="time-ago-cmt">'
                                + time_ago
                                + '</span>'
                                + '<span class="reply-cmt pull-right">'
                                + '<button type="button" class="btn btn-success btn-admin-custom btn-set-comment-public" data-id="' + cmt_id + '" data-question-id="' + question_id + '" data-reply-id="' + reply_id + '" onclick="setPublicReadingComment(' + cmt_id + ')"' + isPublic + '>Set public</button>'
                                + '<button type="button" class="btn btn-warning btn-admin-custom btn-set-comment-private" data-id="' + cmt_id + '" data-question-id="' + question_id + '" data-reply-id="' + reply_id + '" onclick="setPrivateReadingComment(' + cmt_id + ')"' + isPrivated + '>Set private</button>'
                                + '<button type="button" class="btn btn-danger btn-admin-custom btn-del-lesson" data-id="' + cmt_id + '" data-question-id="' + question_id + '" data-reply-id="' + reply_id + '" onclick="deleteReadingComment(' + cmt_id + ')">Del</button>'
                                + '<button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment(' + cmt_id + ', ' + i + ')">Reply</button>'
                                + '</span>'
                                + '</div>'
                                + '</span>'
                                + '</div>');
                        }
                    }
                    else if ((list_comment.private == 0) || (list_comment.user_id == data.current_user_info.id)) {
                        if (reply_id == 0) {
                            $('#commentArea .comments-area').append('<div class="row list-cmt-area list-cmt-' + cmt_id + '" data-cmt-id="' + cmt_id + '">' +
                                '<div class="item-cmt cmt-' + cmt_id + '" id="comment' + cmt_id + '" data-cmt-id="' + cmt_id + '">'
                                + '<span class="img-avatar">'
                                + '<img alt="" src=' + avatar + '"/public/storage/img/users/" class="img-custom avatar-custom" />'
                                + '</span>'
                                + '<span class="item-cmt-content">'
                                + '<div class="item-cmt-header">'
                                +  username
                                + '</div>'
                                + '<div class="item-cmt-body">'
                                +  cmt_content
                                + '</div>'
                                + '<div class="item-time-cmt">'
                                + '<span class="img-time-cmt">'
                                + '<img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" />'
                                + '</span>'
                                + '<span class="time-ago-cmt">'
                                + time_ago
                                + '</span>'
                                + '<span class="reply-cmt pull-right">'
                                + '<button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment(' + cmt_id + ', ' + i + ')">Reply</button>'
                                + '</span>'
                                + '</div>'
                                + '</span>'
                                + '</div>'
                                + '</div>');
                        }
                        else {
                            $('.list-cmt-' + reply_id).append('<div class="item-cmt item-sub-cmt cmt-' + cmt_id + '" id="comment' + cmt_id + '" data-cmt-id="' + cmt_id + '">'
                                + '<span class="img-avatar">'
                                + '<img alt="" src=' + avatar + '"/public/storage/img/users/" class="img-custom avatar-custom" />'
                                + '</span>'
                                + '<span class="item-cmt-content">'
                                + '<div class="item-cmt-header">'
                                +  username
                                + '</div>'
                                + '<div class="item-cmt-body">'
                                +  cmt_content
                                + '</div>'
                                + '<div class="item-time-cmt">'
                                + '<span class="img-time-cmt">'
                                + '<img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" />'
                                + '</span>'
                                + '<span class="time-ago-cmt">'
                                + time_ago
                                + '</span>'
                                + '<span class="reply-cmt pull-right">'
                                + '<button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment(' + cmt_id + ', ' + i + ')">Reply</button>'
                                + '</span>'
                                + '</div>'
                                + '</span>'
                                + '</div>');
                        }
                    }
                });
            }
            if (jQuery.inArray(i, isExpanded) == -1) {
                isExpanded.push(i);
                var avatar = current_user.avatar;
                var username = current_user.username;
                var link = 'enterNewComment';

                $('#commentArea').append('<div class="item-reply-cmt" id="replyComment">'
                    + '<span class="img-avatar">'
                    + '<img alt="" src=' + avatar + '"/public/storage/img/users/" class="img-custom avatar-custom" />'
                    + '</span>'
                    + '<span class="item-cmt-content">'
                    + '<div class="item-cmt-header">'
                    +  username
                    + '</div>'
                    + '<div class="item-cmt-body">'
                    + '<input type="text" placeholder=" Write your comment ..." class="reply-cmt reply-cmt-' + i + '" data-reply-cmt-id="0" data-question-id = "' + i + '">'
                    + '</div>'
                    + '<div class="item-time-cmt">'
                    + '</div>'
                    + '</span>'
                    + '</div>'
                    + '</div>');
            }
            let numItems = $('#commentArea- .comments-area .list-cmt-area').length;
            if (numItems == 0) {
                $('#commentArea .comments-area').append('<p class="no-cmt">Chua co comment nao cho cau hoi nay!</p>');
            }

            $('#loading').hide();

            //Scoll to Comment:
            if (isTrigger) {
                if (question_id_noti && comment_id_noti) {
                    $('html, body').animate({
                        scrollTop: $('.solution-detail').offset().top
                    }, 1000);

                    let t = 60;
                    let r = $(".right-panel-custom").offset().top;
                    let u = $("#comment" + comment_id_noti).offset().top;
                    let f = $(".right-panel-custom").scrollTop();
                    let v = u + f - r;
                    $(".right-panel-custom").animate({
                        scrollTop: v - t
                    });
                    $("#comment" + comment_id_noti).addClass('current-cmt');
                    setTimeout(function(){
                        $("#comment" + comment_id_noti).addClass('time-out-current-cmt');
                    }, 3000);
                }
            }
            else {
                $('html, body').animate({
                    scrollTop: $('.solution-detail').offset().top
                }, 1000);
                let t = 60;
                let r = $(".right-panel-custom").offset().top;
                let u = $("#commentArea").offset().top;
                let f = $(".right-panel-custom").scrollTop();
                let v = u + f - r;
                $(".right-panel-custom").animate({
                    scrollTop: v - t
                });
            }
        },
        error: function (data) {
            bootbox.alert({
                message: "FAIL GET EXPLANATION!",
                backdrop: true
            });
        }
    });

}

function closeExplanation() {
    $('.explanation-column').addClass('hidden');
    $('.solution-detail').removeClass('transform-scale-width-custom-active');
    $('.explanation-column').removeClass('transform-right-custom-active');
}