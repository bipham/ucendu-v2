<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 8/11/2017
 * Time: 11:24 AM
 */
?>

@extends('layout.masterNoMenuAdmin')
@section('meta-title')
    Reading - Create New Type Question
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/css/admin/admin-style.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/admin/upload.css')}}">
    <script src="/public/libs/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-5 text-center">
                @include('utils.message')
                {{--@include('errors.input')--}}
                <form role="form" action="{!! url('createNewTypeQuestion') !!}" method="POST">
                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                    <h1>Create Type Question</h1>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="level_lesson">
                            Chọn Danh Mục
                        </label>
                        <select class="form-control" id="level-lesson" name="level_lesson" >
                            @foreach($all_level_lessons as $level_lesson)
                                <option value="{!! $level_lesson->id !!}">{!! $level_lesson->level !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <CENTER>
                        <button type="submit" class="btn btn-lg btn-warning">
                            Create
                        </button>
                    </CENTER>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('public/js/admin/readingNewTypeQuestion.js')}}"></script>
@endsection
