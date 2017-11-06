<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 10/13/2017
 * Time: 10:32 AM
 */
?>
@extends('layout.masterNoMenuAdmin')
@section('meta-title')
    Reading List Lesson
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/admin/readingListLesson.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/libs/DataTables/datatables.min.css')}}"/>
@endsection
@section('content')
    <div class="container reading-list-lesson-container">
        @include('utils.message')
        {{--@include('errors.input')--}}
        <ul class="nav nav-tabs" id="managerLessonTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="practice-tab" data-toggle="tab" href="#practiceLesson" role="tab" aria-controls="practice" aria-expanded="true">Practice Lesson</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="mini-test-tab" data-toggle="tab" href="#miniTestLesson" role="tab" aria-controls="mini-test">Mini Test</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="mix-test-tab" data-toggle="tab" href="#mixTestLesson" role="tab" aria-controls="mix-test">Mix Test</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="full-test-tab" data-toggle="tab" href="#fullTestLesson" role="tab" aria-controls="full-test">Full Test</a>
            </li>
        </ul>
        <div class="tab-content" id="managerLessonContent">
            <div class="tab-pane fade show active" id="practiceLesson" role="tabpanel" aria-labelledby="practice-tab">
                @include('components.tables.practiceTable',['lessons' => $lessons['practice']])
            </div>
            <div class="tab-pane fade" id="miniTestLesson" role="tabpanel" aria-labelledby="mini-test-tab">
                @include('components.tables.practiceTable',['lessons' => $lessons['mini_test']])
            </div>
            <div class="tab-pane fade" id="mixTestLesson" role="tabpanel" aria-labelledby="mix-test-tab">

            </div>
            <div class="tab-pane fade" id="fullTestLesson" role="tabpanel" aria-labelledby="full-test-tab">

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('public/js/admin/adminEditFunctions.js')}}"></script>
    <script src="{{asset('public/js/admin/adminGetDataFunctions.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/js/admin/readingListLesson.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/libs/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/js/admin/readingManagerLessonTables.js')}}"></script>
@endsection
