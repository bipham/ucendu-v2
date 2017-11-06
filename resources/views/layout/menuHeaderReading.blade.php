<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 7/25/2017
 * Time: 10:16 PM
 */
?>
<header id="header-client-reading" class="menu-header header-custom">
    <div class="container">
        <div class="menu menu-reading row">
            <div class="col-md-4 logo-area">
                <div class="logo-reading-menu img-thumbnail-middle pull-left">
                    <div class="img-thumbnail-inner">
                        <a href="/" class="brand-web">
                            <img src="/public/imgs/original/logo.jpg" alt="Logo" class="img-custom img-middle-responsive img-logo-reading-menu">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 title-lesson-area pull-left">
                <div class="nav-item title-lesson-header">
                    <h4 class="title-type-lesson">
                        @yield('titleTypeLesson')
                    </h4>
                    @yield('typeLessonHeader')
                </div>
            </div>
            <div class="pull-right action-user-center-fixed">
                {{--@include('utils.actionCenterUser')--}}
            </div>
        </div>
    </div>
</header><!-- /header -->
