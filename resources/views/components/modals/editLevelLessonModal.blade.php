<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 10/13/2017
 * Time: 4:26 PM
 */
?>
<!-- Button Edit Level Lesson-->
<div class="basic-info info-level-lesson">
    <h6 class="title-info-custom level-lesson-custom level-lesson-{!! $lesson->id !!}">
        {!! $lesson->typeQuestion->levelLesson->level !!}
    </h6>
    <i class="btn-edit-basic-info fa fa-pencil-square-o" aria-hidden="true" data-id="{!! $lesson->id !!}" data-toggle="modal" data-target="#editBasicInfoLessonModal-{!! $lesson->id !!}"></i>
</div>