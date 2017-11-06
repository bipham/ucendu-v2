<?php
/**
 * Created by PhpStorm.
 * User: nobikun1412
 * Date: 06-Jun-17
 * Time: 01:29
 */
?>

@extends('layout.master')
@section('meta-title')
    Home
@endsection
@section('top-information')
    @include('utils.bannerTop')
@endsection
@section('content')
    <div id="error-page" class="container" >
            <div id="error-404-page" class="row background-white vpadding-10" >
                <div class="col-xs-12 col-sm-7 col-lg-7">
                    <!-- Info -->
                    <div class="info-error-page">
                        <h1 class="number-error-page">404</h1>
                        <h2 class="title-error-custom">Xin lỗi chúng tôi không thể tìm thấy trang bạn yêu cầu</h2>
                        <p>Có vẻ như các trang mà bạn đang cố gắng tiếp cận không tồn tại nữa hoặc có thể nó đã bị xóa. Nếu bạn đang tìm kiếm một tin rao, hãy thử tìm kiếm nâng cao hơn.</p>
                        <a href="/" class="btn btn-success">Trang chủ</a>
                    </div>
                    <!-- end Info -->
                </div>

                <div class="col-xs-12 col-sm-5 col-lg-5 text-center">
                    <!-- Monkey -->
                    <div class="monkey">
                        <img class="img-responsive" src="/public/imgs/banner-page/monkey.gif" alt="Monkey">
                    </div>
                    <!-- end Monkey -->
                </div>
            </div>

    </div>
@endsection

@section('scripts')

@endsection
