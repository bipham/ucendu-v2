var baseUrl = document.location.origin;
var noti_container = '';
var noti_header = '';
var noti_area = '';
var noti_fixed_element = '';
var openNoti = false;
var openNotiFixed = false;

$(".panel-left").resizable({
    handleSelector: ".splitter",
    resizeHeight: true
});
$(".panel-top").resizable({
    handleSelector: ".splitter-horizontal",
    resizeWidth: false
});

//Change status notification display:
$(document).mouseup(function(e)
{
    var container = $('.left-custom .notification-status');
    var container_fixed = $('.action-user-center-fixed .notification-status');

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        openNoti = false;
        $('#notifications-container-menu').hide();
        $('.noti-status').removeClass('white-font-class');
    }

    if (!container_fixed.is(e.target) && container_fixed.has(e.target).length === 0)
    {
        openNotiFixed = false;
        $('.action-user-center-fixed #notifications-container-menu').hide();
        $('.action-user-center-fixed .noti-status').removeClass('white-font-class');
    }

    $('.btn-lesson-menu').click(function () {
        if($('.type-lesson-header').hasClass('question-header')) {
            var type_question_id = $('.type-lesson-header').data('type-question-id');
            $('.item-type-question-' + type_question_id).addClass('active-custom');
        }
        else if($('.type-lesson-header').hasClass('mix-test-header')) {
            $('.mix-test-lesson-reading').addClass('active-custom');
        }
        else {
            $('.full-test-lesson-reading').addClass('active-custom');
        }
    });

});

$('.noti-status').click(function (e) {
    // alert('match noti');
    e.preventDefault();
    noti_header = $(this).parent('.notification-status');
    noti_fixed_element = $(this).parents('.action-user-center-fixed');
    noti_area = noti_header.find('#listNotiArea');
    noti_container = noti_header.find('#notifications-container-menu');

    if (noti_fixed_element.length > 0) {
        if (!openNotiFixed) {
            openNotiFixed = true;
            $('.action-user-center-fixed #notifications-container-menu').show();
            $(this).addClass('white-font-class');
        }
        else {
            openNotiFixed = false;
            $('.action-user-center-fixed #notifications-container-menu').hide();
            $(this).removeClass('white-font-class');
        }
    }
    else {
        if (!openNoti) {
            openNoti = true;
            noti_container.show();
            $(this).addClass('white-font-class');
        }
        else {
            openNoti = false;
            noti_container.hide();
            $(this).removeClass('white-font-class');
        }
    }

    loadAllNotification(noti_area);
});

function loadAllNotification(noti_area) {
    var ajaxGetNotiUrl = baseUrl + '/getNotification/';
    $.ajax({
        type: "GET",
        url: ajaxGetNotiUrl,
        dataType: "json",
        success: function (data) {
            noti_area.html('');
            console.log(data);
            var list_notis = data.list_notis;
            if (list_notis.length != 0) {
                for (var i = 0; i < list_notis.length; i++) {
                    var classReadNoti = list_notis[i].read_at != null ? 'seen-noti' : '';
                    var data_noti = list_notis[i].data.comment;
                    if (list_notis[i].type == 'App\\Notifications\\CommentNotification') {
                        var url_link = baseUrl + '/reading/' + data_noti.level_lesson_id + '-' + data_noti.level_lesson + '/readingViewSolutionLesson/' + data_noti.type_lesson_id + '-' + data_noti.lesson_id + '?question=' + data_noti.question_custom_id + '&comment=' + data_noti.id;
                        var content_noti = '<strong>' + data_noti.username + ' </strong> commented on <strong>' + data_noti.title_lesson + ' - ' + data_noti.type_question + ' - ' + data_noti.level_lesson + '</strong>';
                        var noti_id = '\'' + list_notis[i].id + '\'';
                    }
                    noti_area.append(
                        '<div class="item-notification no-read ' + classReadNoti + '" onclick="readNotification(' + noti_id + ')">'
                        + '<a href="' + url_link + '" class="link-to-noti">'
                        + '<span class="img-user-send-noti img-auto-center">'
                        + '<img alt="' + data_noti.username + '" src="/public/storage/img/users/' + data_noti.avatar + '" class="img-user-noti-header img-auto-center-inner" />'
                        + '</span>'
                        + '<span class="item-content-noti">'
                        + '<div class="item-body-noti">'
                        +  content_noti
                        + '</div>'
                        + '<div class="item-time-noti">'
                        + '<span class="img-time-noti">'
                        + '<img alt="time-noti" src="/public/imgs/original/time.png" class="img-time-noti" />'
                        + '</span>'
                        + '<span class="time-ago-noti">'
                        + data_noti.time_ago
                        + '</span>'
                        + '</div>'
                        + '</span>'
                        + '</a>'
                        + '</div>'
                    );
                }
            }
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
}

function readNotification(id) {
    var ajaxReadNotiUrl = baseUrl + '/readNotification/' + id;
    $.ajax({
        type: "GET",
        url: ajaxReadNotiUrl,
        dataType: "json",
        success: function (data) {
            console.log('Success:', data);
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
}

function markAllNotificationAsRead() {
    var ajaxMarkAllNotificationAsRead = baseUrl + '/markAllNotificationAsRead';
    $.ajax({
        type: "GET",
        url: ajaxMarkAllNotificationAsRead,
        dataType: "json",
        success: function (data) {
            $('sup.total-noti').each(function () {
                $(this).hide();
            });
            $('.item-notification.no-read').each(function () {
                $(this).removeClass('no-read');
                $(this).addClass('seen-noti');
            });
        },
        error: function (data) {
        }
    });
}