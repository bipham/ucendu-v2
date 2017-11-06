/**
 * Created by BiPham on 11/1/2017.
 */
$(document).ready(function(){
    // Khởi tạo một đối tượng Pusher với app_key
    var pusher = new Pusher('cecca162494859b86b89', {
        cluster: 'ap1',
        encrypted: true,
        auth: {
            headers: {
                'X-CSRF-TOKEN': $('[name="_token"]').val()
            }
        }
    });

    var user_id = $('.test-pusher').data('user-id');
    pusher.connection.bind('connected', function() {
       // alert(pusher.connection.socket_id);
    });

    pusher.connection.bind('disconnected', function() {
        alert('disconnected');
    });

    // pusher.disconnect();
    //Đăng ký với kênh chanel-demo-real-time mà ta đã tạo trong file DemoPusherEvent.php
    var presenceChannel = pusher.subscribe('presence-commnent-noti-' + user_id);

    presenceChannel.bind('pusher:subscription_succeeded', function(members) {
        // for example
        // update_member_count(members.count);
        //
        // members.each(function(member) {
        //     // for example:
        //     add_member(member.id, member.info);
        // });
        console.log(JSON.stringify(members));
    });

    //Bind một function addMesagePusher với sự kiện DemoPusherEvent
    presenceChannel.bind('App\\Events\\CommentNotificationEvent', addMessageDemo);
});

//function add message
function addMessageDemo(data) {
    var liTag = $("<li class='list-group-item'></li>");
    console.log(data);
    liTag.html(data.message);
    $('#messages').append(liTag);
    notifyMe(data.message);
}

function notifyMe(message) {
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }
    else if (Notification.permission === "granted") {
        var options = {
            body: message,
            icon: "/public/imgs/original/logo.jpg",
            dir : "ltr"
        };
        var notification = new Notification("Ucendu",options);
    }
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            if (!('permission' in Notification)) {
                Notification.permission = permission;
            }

            if (permission === "granted") {
                var options = {
                    body: message,
                    icon: "/public/imgs/original/logo.jpg",
                    dir : "ltr"
                };
                var notification = new Notification("Ucendu",options);
            }
        });
    }
}