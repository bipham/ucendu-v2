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

var mainUrl_tmp = baseUrl.substring(7);
var adminBaseUrl = 'http://admin.' + mainUrl_tmp;

$(document).ready(function() {
    jQuery(function(){
        if (question_id_noti && comment_id_noti) {
            showComments(question_id_noti, true);
            $('#commentArea-' + question_id_noti).collapse();
        }
    });
});

function showExplanation(question_custom_id, question_order, isTrigger) {
    "use strict";
    isTrigger = isTrigger || false;
    var ajaxShowExplanation = baseUrl + '/showExplanation/' + question_custom_id;
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
            var last_highlight = $('.highlighting');
            last_highlight.removeClass('highlighting');
            last_highlight.addClass('hidden-highlight');
            $('.highlight-' + question_order).removeClass('hidden-highlight');
            $('.highlight-' + question_order).addClass('highlighting');
            $("html, body").animate({
                scrollTop: $('.panel-container').offset().top
            }, 100);
            var idClass = 'highlight-' + question_order;
            var t_l = 60;
            var r_l = $(".left-panel-custom").offset().top;
            var u_l = $("."+idClass).offset().top;
            var f_l = $(".left-panel-custom").scrollTop();
            var v_l = u_l + f_l - r_l;
            $(".left-panel-custom").animate({
                scrollTop: v_l - t_l
            }, {
                duration: 100,
                complete: function () {
                }
            });

            //Show comments:
            $('#commentArea .comments-area').html('');
            $('#commentArea .primary-comment').html('');
            if (data.list_comments.length > 0) {
                jQuery.each( data.list_comments, function( index, list_comment ) {
                    var avatar = list_comment.avatar;
                    var cmt_content = list_comment.content_cmt;
                    var time_ago = list_comment.updated_at;
                    var cmt_id = list_comment.id;
                    var question_id = list_comment.question_custom_id;
                    var username = list_comment.username;
                    var reply_id = list_comment.reply_comment_id;
                    var isPrivated = '';
                    var isPublic = '';
                    var status_class = 'item-cmt-public';
                    if (list_comment.private == 1) {
                        isPrivated = 'disabled';
                        status_class = 'item-cmt-private';
                    }
                    else {
                        isPublic = 'disabled';
                    }

                    if (data.current_user_info['level_user_id'] == 1) {
                        if (reply_id == 0) {
                            $('#commentArea .comments-area').append('<div class="row list-cmt-area list-cmt-' + cmt_id + '" data-cmt-id="' + cmt_id + '">' +
                                '<div class="item-cmt cmt-' + cmt_id + ' ' + status_class + '" id="comment' + cmt_id + '" data-cmt-id="' + cmt_id + '">'
                                + '<span class="img-avatar">'
                                + '<img alt="" src="/public/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
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
                                + '<button type="button" class="btn btn-reply-cmt btn-sm btn-outline-primary" onclick="replyComment(' + cmt_id + ', ' + question_custom_id + ')">Reply</button>'
                                + '</span>'
                                + '</div>'
                                + '</span>'
                                + '</div>'
                                + '</div>');
                        }
                        else {
                            $('.list-cmt-' + reply_id).append('<div class="item-cmt item-sub-cmt cmt-' + cmt_id + ' ' + status_class + '" id="comment' + cmt_id + '" data-cmt-id="' + cmt_id + '">'
                                + '<span class="img-avatar">'
                                + '<img alt="" src="/public/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
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
                                + '<button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment(' + cmt_id + ', ' + question_custom_id + ')">Reply</button>'
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
                                + '<img alt="" src="/public/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
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
                                + '<button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment(' + cmt_id + ', ' + question_custom_id + ')">Reply</button>'
                                + '</span>'
                                + '</div>'
                                + '</span>'
                                + '</div>'
                                + '</div>');
                        }
                        else {
                            $('.list-cmt-' + reply_id).append('<div class="item-cmt item-sub-cmt cmt-' + cmt_id + '" id="comment' + cmt_id + '" data-cmt-id="' + cmt_id + '">'
                                + '<span class="img-avatar">'
                                + '<img alt="" src="/public/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
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
                                + '<button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment(' + cmt_id + ', ' + question_custom_id + ')">Reply</button>'
                                + '</span>'
                                + '</div>'
                                + '</span>'
                                + '</div>');
                        }
                    }
                });
            }

            //Parse input comment primary:
            var avatar = current_user_avatar;
            var username = current_username;
            var link = 'enterNewComment';

            $('#commentArea .primary-comment').append('<div class="item-reply-cmt" id="replyComment">'
                + '<span class="img-avatar">'
                + '<img alt="" src="/public/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
                + '</span>'
                + '<span class="item-cmt-content">'
                + '<div class="item-cmt-header">'
                +  username
                + '</div>'
                + '<div class="item-cmt-body">'
                + '<input type="text" placeholder=" Write your comment ..." class="reply-cmt reply-cmt-' + question_custom_id + '" data-reply-cmt-id="0" data-question-id = "' + question_custom_id + '">'
                + '</div>'
                + '<div class="item-time-cmt">'
                + '</div>'
                + '</span>'
                + '</div>'
                + '</div>');

            var numItems = $('#commentArea .comments-area .list-cmt-area').length;
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

                    var t = 60;
                    var r = $(".right-panel-custom").offset().top;
                    var u = $("#comment" + comment_id_noti).offset().top;
                    var f = $(".right-panel-custom").scrollTop();
                    var v = u + f - r;
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
                var t = 60;
                var r = $(".right-panel-custom").offset().top;
                var u = $("#commentArea").offset().top;
                var f = $(".right-panel-custom").scrollTop();
                var v = u + f - r;
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

function enterComment(e) {
    if (e.keyCode == 13) {
        var user_id = current_user_id;
        var content_cmt = $(this).val().trim();
        if (content_cmt != '') {
            $(this).val('');
            var question_custom_id= $(this).data('question-id');
            var reply_id = $(this).data('reply-cmt-id');
            var ajaxUrlEnterReplyComment = baseUrl + '/enterNewComment';
            console.log('reply: ' + reply_id + ' question: ' + question_custom_id + 'content: ' + content_cmt);
            var token = $("input[name='_token']").val();
            $.ajax({
                type: "POST",
                url: ajaxUrlEnterReplyComment,
                dataType: "json",
                data: {'_token':token, user_id: user_id, content_cmt: content_cmt, question_custom_id: question_custom_id, reply_id: reply_id},
                success: function (data) {
                    var avatar = current_user_avatar;
                    var time_ago = 'Just now';
                    var cmt_id = data.new_comment.id;
                    var username = current_username;
                    $('p.no-cmt').remove();
                    $('.item-reply-sub-cmt').remove();
                    if ((data.new_comment.private == 0) || (data.new_comment.user_id == user_id)) {
                        if (reply_id == 0) {
                            $('#commentArea .comments-area').append('<div class="row list-cmt-area list-cmt-' + cmt_id + '" data-cmt-id="' + cmt_id + '">' +
                                '<div class="item-cmt cmt-' + cmt_id + '" data-cmt-id="' + cmt_id + '">'
                                + '<span class="img-avatar">'
                                + '<img alt="" src="/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
                                + '</span>'
                                + '<span class="item-cmt-content">'
                                + '<div class="item-cmt-header">'
                                + username
                                + '</div>'
                                + '<div class="item-cmt-body">'
                                + content_cmt
                                + '</div>'
                                + '<div class="item-time-cmt">'
                                + '<span class="img-time-cmt">'
                                + '<img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" />'
                                + '</span>'
                                + '<span class="time-ago-cmt">'
                                + time_ago
                                + '</span>'
                                + '<span class="reply-cmt pull-right">'
                                + '<button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment(' + cmt_id + ', ' + question_custom_id + ')">Reply</button>'
                                + '</span>'
                                + '</div>'
                                + '</span>'
                                + '</div>'
                                + '</div>');
                        }
                        else {
                            $('.list-cmt-' + reply_id).append('<div class="item-cmt item-sub-cmt cmt-' + cmt_id + '" data-cmt-id="' + cmt_id + '">'
                                + '<span class="img-avatar">'
                                + '<img alt="" src="/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
                                + '</span>'
                                + '<span class="item-cmt-content">'
                                + '<div class="item-cmt-header">'
                                + username
                                + '</div>'
                                + '<div class="item-cmt-body">'
                                + content_cmt
                                + '</div>'
                                + '<div class="item-time-cmt">'
                                + '<span class="img-time-cmt">'
                                + '<img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" />'
                                + '</span>'
                                + '<span class="time-ago-cmt">'
                                + time_ago
                                + '</span>'
                                + '<span class="reply-cmt pull-right">'
                                + '<button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment(' + cmt_id + ', ' + question_custom_id + ')">Reply</button>'
                                + '</span>'
                                + '</div>'
                                + '</span>'
                                + '</div>');
                        }
                    }
                    $('input.reply-cmt-' + question_custom_id).data('reply-cmt-id', 0);
                    $('html,body').animate({
                        scrollTop: $(".cmt-" + cmt_id).offset().top - 20
                    }, 500);
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
    }
}

function replyComment(cmt_id, question_custom_id) {
    var avatar = current_user_avatar;
    var username = current_username;
    var reply_id = $('.cmt-' + cmt_id).parent().data('cmt-id');
    var parentCmt = $('.cmt-' + cmt_id).parent('.list-cmt-area');
    var item_reply_sub_cmt = parentCmt.find('.item-reply-sub-cmt');
    if (item_reply_sub_cmt.length > 0) {
        $('input.reply-sub-cmt-' + question_custom_id).data('reply-cmt-id', reply_id);
    }
    else {
        parentCmt.append('<div class="item-reply-sub-cmt item-sub-cmt" id="replySubComment">'
            + '<span class="img-avatar">'
            + '<img alt="" src="/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
            + '</span>'
            + '<span class="item-cmt-content">'
            + '<div class="item-cmt-header">'
            +  username
            + '</div>'
            + '<div class="item-cmt-body">'
            + '<input type="text" placeholder=" Write a reply ..." class="reply-cmt reply-sub-cmt reply-sub-cmt-' + reply_id + '" data-reply-cmt-id="' + reply_id + '" data-question-id = "' + question_custom_id + '">'
            + '</div>'
            + '<div class="item-time-cmt">'
            + '</div>'
            + '</span>'
            + '</div>'
            + '</div>');
    }

    $('input.reply-sub-cmt-' + reply_id).focus();
    $("html, body").animate({
        scrollTop: $('.panel-container').offset().top
    }, 100);
    var t = 100,
        r = $(".right-panel-custom").offset().top,
        u = $("input.reply-sub-cmt-" + reply_id).offset().top,
        f = $(".right-panel-custom").scrollTop(),
        v = u + f - r;
    $(".right-panel-custom").animate({
        scrollTop: v - t
    }, {
        duration: 100,
        complete: function () {
        }
    });
}

$(document).on("keypress","input.reply-cmt",enterComment);