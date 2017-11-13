/**
 * Created by nobikun1412 on 27-May-17.
 */

var baseUrl = document.location.origin;
var user_id = current_user_id;
var public_connect = baseUrl + ':8890?user_id=' + user_id;

var socket_public = io.connect(public_connect);
socket_public.emit('updateSocket', user_id);

socket_public.on('insert-new-comment', function (data) {
    insertNewComment(current_user_id, current_level_user, data.comment.id, data.comment.private, data.avatar, data.comment.content_cmt, 'Just now', data.comment.question_custom_id, data.username, data.comment.reply_comment_id, data.comment.user_id);
});

socket_public.on('comment-notication', function (data) {
    notifyMe(data);
});

//function add message
function addMessageDemo(data) {
    var liTag = $("<li class='list-group-item'></li>");
    console.log(data);
    liTag.html(data.message);
    $('#messages').append(liTag);
}

function notifyMe(data) {
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }
    else if (Notification.permission === "granted") {
        var options = {
            body: data.message,
            icon: "/public/imgs/original/logo.jpg",
            dir : "ltr"
        };
        var notification = new Notification(data.title, options);
    }
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            if (!('permission' in Notification)) {
                Notification.permission = permission;
            }

            if (permission === "granted") {
                var options = {
                    body: data.message,
                    icon: "/public/imgs/original/logo.jpg",
                    dir : "ltr"
                };
                var notification = new Notification(data.title, options);
            }
        });
    }
}