<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 10/16/2017
 * Time: 8:34 AM
 */
?>
<!-- Button Edit Type Question-->
<div class="basic-info info-order-lesson">
    <h6 class="title-info-custom order-lesson-custom order-lesson-{!! $lesson->id !!}">
        {!! $lesson->order_lesson !!}
    </h6>
    <i class="btn-edit-basic-info fa fa-pencil-square-o" aria-hidden="true" data-id="{!! $lesson->id !!}" data-toggle="modal" data-target="#editBasicInfoLessonModal-{!! $lesson->id !!}"></i>
</div>