<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 9/26/2017
 * Time: 12:00 AM
 */
//dd($practice_lessons);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>@yield('meta-title', 'Reading English') - Ucendu</title>
    <link rel="stylesheet" href="{{asset('public/libs/bootstrap/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/libs/font-awesome/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/css/client/readingLessonDetail.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/my-style.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/css/client/readingFooterNavigation.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/css/client/responsive.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/css/client/readingClient.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/libs/toolbar/jquery.toolbar.css')}}" />
    {{--<link rel="stylesheet" href="{{asset('public/libs/jcubic-splitter/css/jquery.splitter.css')}}" />--}}
    <script>
        {{--var current_user = {!! json_encode(Auth::user()) !!};--}}
        var current_username = {!! json_encode(Auth::user()->username) !!};
        var current_user_id = {!! json_encode(Auth::id()) !!};
        var current_user_avatar = {!! json_encode(Auth::user()->avatar) !!};
        var current_level_user = {!! json_encode(Auth::user()->level_user_id) !!};
    </script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(["init", {
            appId: "25eb1639-9eec-4283-838b-a9c35a8c84cf",
            autoRegister: false, /* Set to true to automatically prompt visitors */
            notifyButton: {
                enable: true /* Set to false to hide */
            }
        }]);
    </script>
    @yield('css')
</head>
<body data-hijacking="on" data-animation="parallax">
<a href="#" id="allownoti" class="hidden">Cho phép thông báo</a>
<a href="#" id="shownoti" class="hidden">Hiển thị thông báo</a>
<div class="overlay"></div>
<div id="loading"></div>
@include('layout.header')
@include('layout.menuHeaderReading')
<div role="main" class="main main-page">
    @yield('top-information')

    @yield('content')

</div>
{{--@include('utils.toolbarReadingLesson')--}}
@include('utils.leftMenuReading')
@include('layout.footerNavigation')
<script src="{{asset('public/libs/tether/tether.min.js')}}"></script>
<script src="{{asset('public/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('public/libs/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/libs/highlight/TextHighlighter.min.js')}}"></script>
<script src="{{asset('public/libs/bootbox/bootbox.min.js')}}"></script>
<script src="{{asset('public/libs/splitter/jquery-resizable.js')}}"></script>
<script src="//cdn.rawgit.com/julmot/mark.js/master/dist/jquery.mark.min.js"></script>
<script src="{{asset('public/libs/toolbar/jquery.toolbar.js')}}"></script>
<script src="{{asset('public/js/my-script.js')}}"></script>
<script src="{{asset('public/js/client/readingFooterNavigation.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="{{asset('public/js/socketNoti.js')}}"></script>
<script type="text/javascript">

    OneSignal.sendSelfNotification(
            /* Title (defaults if unset) */
        "OneSignal Web Push Notification",
            /* Message (defaults if unset) */
        "Action buttons increase the ways your users can interact with your notification.",
            /* URL (defaults if unset) */
        'http://ucendu.dev/?_osp=do_not_open',
            /* Icon */
        'https://onesignal.com/images/notification_logo.png',
        {
            /* Additional data hash */
            notificationType: 'news-feature'
        },
        [{ /* Buttons */
            /* Choose any unique identifier for your button. The ID of the clicked button is passed to you so you can identify which button is clicked */
            id: 'like-button',
            /* The text the button should display. Supports emojis. */
            text: 'Like',
            /* A valid publicly reachable URL to an icon. Keep this small because it's downloaded on each notification display. */
            icon: 'http://i.imgur.com/N8SN8ZS.png',
            /* The URL to open when this action button is clicked. See the sections below for special URLs that prevent opening any window. */
            url: 'https://example.com/?_osp=do_not_open'
        },
            {
                id: 'read-more-button',
                text: 'Read more',
                icon: 'http://i.imgur.com/MIxJp1L.png',
                url: 'https://example.com/?_osp=do_not_open'
            }]
    );
</script>
@yield('scripts')
</body>
</html>
