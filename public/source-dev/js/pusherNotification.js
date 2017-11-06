/**
 * Created by BiPham on 11/1/2017.
 */
$(document).ready(function(){
    // Khởi tạo một đối tượng Pusher với app_key
    var pusher = new Pusher('cecca162494859b86b89', {
        cluster: 'ap1',
        encrypted: true
    });

    //Đăng ký với kênh chanel-demo-real-time mà ta đã tạo trong file DemoPusherEvent.php
    var channel = pusher.subscribe('commnent-noti');

    //Bind một function addMesagePusher với sự kiện DemoPusherEvent
    channel.bind('App\\Events\\CommentNotificationEvent', addMessageDemo);
});

//function add message
function addMessageDemo(data) {
    var liTag = $("<li class='list-group-item'></li>");
    liTag.html(data.message);
    $('#messages').append(liTag);
}