/**
 * Created by BiPham on 10/16/2017.
 */
/**
 * Created by BiPham on 7/19/2017.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('[name="_token"]').val()
    }
});
var token = $('[name="_token"]').val();
var baseUrl = document.location.origin;

function showExplanation(question_custom_id, question_order, isTrigger) {
    "use strict";
    isTrigger = isTrigger || false;
    var ajaxShowExplanation = baseUrl + '/showExplanation/' + question_custom_id;
    $.ajax({
        type: "GET",
        url: ajaxShowExplanation,
        dataType: "json",
        success: function (data) {
            console.log('data: ' + JSON.stringify(data));
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
                duration: 2000,
                complete: function () {
                }
            });

            //Show comments:
            $('#commentArea .comments-area').html('');
            $('#commentArea .primary-comment').html('');
            if (data.list_comments.length > 0) {
                jQuery.each( data.list_comments, function( index, list_comment ) {
                    insertNewComment(data.current_user_info.id, data.current_user_info.level_user_id, list_comment.id, list_comment.private, list_comment.avatar, list_comment.content_cmt, list_comment.updated_at, question_custom_id, list_comment.username, list_comment.reply_comment_id, list_comment.user_id)
                });
            }

            //Parse input comment primary:
            parseInputCommentPrimary(current_user_avatar, current_username, question_custom_id);

            var numItems = $('#commentArea .comments-area .list-cmt-area').length;
            if (numItems == 0) {
                $('#commentArea .comments-area').append('<p class="no-cmt">No comment for this question, be a first persion comment on this!</p>');
            }

            $('#loading').hide();

            //Scoll to Comment:
            if (isTrigger) {
                if (question_id_noti && comment_id_noti) {
                    $('html, body').animate({
                        scrollTop: $('.solution-detail').offset().top
                    }, 1000);

                    var t = 60;
                    var r = $(".explanation-column").offset().top;
                    var u = $("#comment" + comment_id_noti).offset().top;
                    var f = $(".explanation-column").scrollTop();
                    var v = u + f - r;
                    $(".explanation-column").animate({
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
                var r = $(".explanation-column").offset().top;
                var u = $("#commentArea").offset().top;
                var f = $(".explanation-column").scrollTop();
                var v = u + f - r;
                $(".explanation-column").animate({
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
            var token = $("input[name='_token']").val();
            $.ajax({
                type: "POST",
                url: ajaxUrlEnterReplyComment,
                dataType: "json",
                data: {'_token':token, user_id: user_id, content_cmt: content_cmt, question_custom_id: question_custom_id, reply_id: reply_id},
                success: function (data) {
                    $('p.no-cmt').remove();
                    $('.item-reply-sub-cmt').remove();
                    insertNewComment(current_user_id, current_level_user, data.new_comment.id, data.new_comment.private, current_user_avatar, content_cmt, 'Just now', question_custom_id, current_username, reply_id, current_user_id);
                    $('input.reply-cmt-' + question_custom_id).data('reply-cmt-id', 0);
                    $('html,body').animate({
                        scrollTop: $(".cmt-" + data.new_comment.id).offset().top - 20
                    }, 500);
                },
                error: function (data) {
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

function parseInputCommentPrimary(avatar, username, question_custom_id) {
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
}

function insertNewComment(current_user_id, current_level_user, comment_id, comment_private, avatar, comment_content, time_ago, question_custom_id, username, reply_comment_id, comment_user_id) {
    var isPrivated = '';
    var isPublic = '';
    var status_class = 'item-cmt-public';
    if (comment_private == 1) {
        isPrivated = 'disabled';
        status_class = 'item-cmt-private';
    }
    else {
        isPublic = 'disabled';
    }
    if (current_level_user == 1) {
        if (reply_comment_id == 0) {
            $('#commentArea .comments-area').append('<div class="row list-cmt-area list-cmt-' + comment_id + '" data-cmt-id="' + comment_id + '">' +
                '<div class="item-cmt cmt-' + comment_id + ' ' + status_class + '" id="comment' + comment_id + '" data-cmt-id="' + comment_id + '">'
                + '<span class="img-avatar">'
                + '<img alt="" src="/public/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
                + '</span>'
                + '<span class="item-cmt-content">'
                + '<div class="item-cmt-header">'
                +  username
                + '</div>'
                + '<div class="item-cmt-body">'
                +  comment_content
                + '</div>'
                + '<div class="item-time-cmt">'
                + '<span class="img-time-cmt">'
                + '<img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" />'
                + '</span>'
                + '<span class="time-ago-cmt">'
                + time_ago
                + '</span>'
                + '<span class="reply-cmt pull-right">'
                + '<button type="button" class="btn btn-success btn-admin-custom btn-set-comment-public" data-id="' + comment_id + '" data-question-id="' + question_custom_id + '" data-reply-id="' + reply_comment_id + '" onclick="setPublicReadingComment(' + comment_id + ')"' + isPublic + '>Set public</button>'
                + '<button type="button" class="btn btn-warning btn-admin-custom btn-set-comment-private" data-id="' + comment_id + '" data-question-id="' + question_custom_id + '" data-reply-id="' + reply_comment_id + '" onclick="setPrivateReadingComment(' + comment_id + ')"' + isPrivated + '>Set private</button>'
                // + '<button type="button" class="btn btn-danger btn-admin-custom btn-del-lesson" data-id="' + comment_id + '" data-question-id="' + question_custom_id + '" data-reply-id="' + reply_comment_id + '" onclick="deleteReadingComment(' + comment_id + ')">Del</button>'
                + '<button type="button" class="btn btn-reply-cmt btn-sm btn-outline-primary" onclick="replyComment(' + comment_id + ', ' + question_custom_id + ')">Reply</button>'
                + '</span>'
                + '</div>'
                + '</span>'
                + '</div>'
                + '</div>');
        }
        else {
            $('.list-cmt-' + reply_comment_id).append('<div class="item-cmt item-sub-cmt cmt-' + comment_id + ' ' + status_class + '" id="comment' + comment_id + '" data-cmt-id="' + comment_id + '">'
                + '<span class="img-avatar">'
                + '<img alt="" src="/public/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
                + '</span>'
                + '<span class="item-cmt-content">'
                + '<div class="item-cmt-header">'
                +  username
                + '</div>'
                + '<div class="item-cmt-body">'
                +  comment_content
                + '</div>'
                + '<div class="item-time-cmt">'
                + '<span class="img-time-cmt">'
                + '<img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" />'
                + '</span>'
                + '<span class="time-ago-cmt">'
                + time_ago
                + '</span>'
                + '<span class="reply-cmt pull-right">'
                + '<button type="button" class="btn btn-success btn-admin-custom btn-set-comment-public" data-id="' + comment_id + '" data-question-id="' + question_custom_id + '" data-reply-id="' + reply_comment_id + '" onclick="setPublicReadingComment(' + comment_id + ')"' + isPublic + '>Set public</button>'
                + '<button type="button" class="btn btn-warning btn-admin-custom btn-set-comment-private" data-id="' + comment_id + '" data-question-id="' + question_custom_id + '" data-reply-id="' + reply_comment_id + '" onclick="setPrivateReadingComment(' + comment_id + ')"' + isPrivated + '>Set private</button>'
                // + '<button type="button" class="btn btn-danger btn-admin-custom btn-del-lesson" data-id="' + comment_id + '" data-question-id="' + question_custom_id + '" data-reply-id="' + reply_comment_id + '" onclick="deleteReadingComment(' + comment_id + ')">Del</button>'
                + '<button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment(' + comment_id + ', ' + question_custom_id + ')">Reply</button>'
                + '</span>'
                + '</div>'
                + '</span>'
                + '</div>');
        }
    }
    else if ((comment_private == 0) || (comment_user_id == current_user_id)) {
        if (reply_comment_id == 0) {
            $('#commentArea .comments-area').append('<div class="row list-cmt-area list-cmt-' + comment_id + '" data-cmt-id="' + comment_id + '">' +
                '<div class="item-cmt cmt-' + comment_id + '" id="comment' + comment_id + '" data-cmt-id="' + comment_id + '">'
                + '<span class="img-avatar">'
                + '<img alt="" src="/public/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
                + '</span>'
                + '<span class="item-cmt-content">'
                + '<div class="item-cmt-header">'
                +  username
                + '</div>'
                + '<div class="item-cmt-body">'
                +  comment_content
                + '</div>'
                + '<div class="item-time-cmt">'
                + '<span class="img-time-cmt">'
                + '<img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" />'
                + '</span>'
                + '<span class="time-ago-cmt">'
                + time_ago
                + '</span>'
                + '<span class="reply-cmt pull-right">'
                + '<button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment(' + comment_id + ', ' + question_custom_id + ')">Reply</button>'
                + '</span>'
                + '</div>'
                + '</span>'
                + '</div>'
                + '</div>');
        }
        else {
            $('.list-cmt-' + reply_comment_id).append('<div class="item-cmt item-sub-cmt cmt-' + comment_id + '" id="comment' + comment_id + '" data-cmt-id="' + comment_id + '">'
                + '<span class="img-avatar">'
                + '<img alt="" src="/public/storage/img/users/' + avatar + '" class="img-custom avatar-custom" />'
                + '</span>'
                + '<span class="item-cmt-content">'
                + '<div class="item-cmt-header">'
                +  username
                + '</div>'
                + '<div class="item-cmt-body">'
                +  comment_content
                + '</div>'
                + '<div class="item-time-cmt">'
                + '<span class="img-time-cmt">'
                + '<img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" />'
                + '</span>'
                + '<span class="time-ago-cmt">'
                + time_ago
                + '</span>'
                + '<span class="reply-cmt pull-right">'
                + '<button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment(' + comment_id + ', ' + question_custom_id + ')">Reply</button>'
                + '</span>'
                + '</div>'
                + '</span>'
                + '</div>');
        }
    }
}
