<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 10/11/2017
 * Time: 11:45 AM
 */
?>
@extends('layout.masterNoMenuAdmin')
@section('meta-title')
    Create new level user
@endsection
@section('css')

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-5 text-center">
                @include('utils.message')
                {{--@include('errors.input')--}}
                <form role="form" action="{!! url('createNewLevelUser') !!}" method="POST">
                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                    <h1>Tạo Level User</h1>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Level" id="level" name="level" required>
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
    {{--<script src="{{asset('public/js/admin/upload.js')}}"></script>--}}
@endsection
