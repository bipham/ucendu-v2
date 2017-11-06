<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 9/5/2017
 * Time: 1:56 PM
 */
?>
<div class="menu-fix-custom">
    <div class="container">
        <div class="menu menu-reading">
            <div class="pull-right action-user-center-fixed">
                {{--@include('utils.actionCenterUser')--}}
            </div>
            <ul class="nav nav-tabs" id="myTabReading" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/createNewUser')}}">New_User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/createNewLearningTypeQuestion')}}">New_Learning</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/createNewLevelLesson')}}">New_level_lesson</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/createNewLevelUser')}}">New_level_user</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/createNewTypeQuestion')}}">New_type_question</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/createNewReadingLesson/1practice')}}">New_practice_lesson</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/createNewReadingLesson/2miniTest')}}">New_mini_test</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/createNewReadingLesson/3mixTest')}}">New_mix_test</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/createNewReadingLesson/4fullTest')}}">New_full_test</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/managerReadingLesson')}}">Manager_lesson</a>
                </li>
            </ul>
        </div>
    </div>
</div>
