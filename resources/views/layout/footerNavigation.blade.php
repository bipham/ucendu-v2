<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 9/26/2017
 * Time: 12:01 AM
 */
?>
<footer class="navbar-fixed-bottom footer-navigation-fixed panel-footer navbar-account">
    <div class="show-current-step" onclick="toggleLeftMenu()">
        <i class="fa fa-times icon-hide-left-menu hidden" aria-hidden="true"></i>
        <i class="fa fa-bars icon-show-left-menu" aria-hidden="true"></i>
        <span class="title-step">
            {!! $title_current_step !!}
        </span>
    </div>
    <!--/.footer-bottom-->
</footer>
