<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 8/9/2017
 * Time: 10:56 PM
 */
?>
@if(Auth::check())
<ul class="navbar-nav navbar-custom-header primary-header-custom navbar-info-custom" id="userNotiAction" data-user-id="{!! Auth::id() !!}">
    <?php
    $user = Auth::user();
    $total_notifications = count($user->unreadnotifications);
    ?>
    <li class="dropdown dropdown-custom open img-status-header">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{Auth::user()->username}}
        </button>
        <div class="dropdown-menu profile-dropdown-custom" aria-labelledby="dropdownMenu">
            <a class="dropdown-item" href="{!! url('logout') !!}">Log out</a>
        </div>
    </li>
    <li class="img-avatar-header img-status-header">
        <img alt="{!! Auth::user()->username !!}" src="{!! asset('storage/img/users') !!}/{!! Auth::user()->avatar !!}" class="img-circle img-ava-header">
    </li>
    <li class="notification-status img-status-header">
        <i class="fa fa-globe noti-status img-status-custom" aria-hidden="true"></i>
        <span class="print-number-noti">
                    @if($total_notifications != 0)
                <sup class="total-noti">{!! $total_notifications !!}</sup>
            @endif
            </span>
        <div id="notifications-container-menu">
            <div class="notifications-header">
                <h3 class="title-noti-menu">Notifications</h3>
                <h3 class="mark-all-notis" onclick="markAllNotificationAsRead()">Mark all read</h3>
            </div>
            <div id="notifications-body">
                <div class="list-noti-content">
                    <div class="content-noti-custom" id="listNotiArea">

                    </div>
                </div>
            </div>
            <div class="notifications-footer">
                <h3 class="see-all-notis">See all notifications!</h3>
            </div>
        </div>
    </li>
</ul>
@endif
