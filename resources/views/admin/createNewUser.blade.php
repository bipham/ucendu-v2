<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 7/27/2017
 * Time: 4:19 PM
 */
?>

@extends('layout.masterNoMenuAdmin')
@section('meta-title')
    Home
@endsection
@section('css')

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-5 text-center">
                @include('utils.message')
                {{--@include('errors.input')--}}
                <form role="form" action="{!! url('createNewUser') !!}" method="POST">
                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                    <h1>Tạo Tài khoản Mới</h1>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Tài khoản" id="userName" name="username" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Địa chỉ Email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="levelUser" name="level" >
                            @foreach($all_level_users as $level_user)
                                <option value="{!! $level_user->id !!}">{!! $level_user->level !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <CENTER>
                        <button type="submit" class="btn btn-lg btn-warning">
                            Tạo tài khoản
                        </button>
                    </CENTER>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{--<script src="{{asset('public/js/admin/upload.js')}}"></script>--}}
@endsection

