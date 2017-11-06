<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 10/13/2017
 * Time: 2:15 PM
 */
?>
<!-- Button Edit Title Lesson-->
<div class="basic-info info-title-lesson">
    <h6 class="title-info-custom title-lesson-custom title-lesson-{!! $lesson->id !!}">
        {!! $lesson->title !!}
    </h6>
    <i class="btn-edit-basic-info fa fa-pencil-square-o" aria-hidden="true" data-id="{!! $lesson->id !!}" data-toggle="modal" data-target="#editInfoTitleLessonModal-{!! $lesson->id !!}"></i>
</div>

<!-- Modal Edit Title Lesson-->
<div class="modal fade" id="editInfoTitleLessonModal-{!! $lesson->id !!}" tabindex="-1" data-id="{!! $lesson->id !!}" role="dialog" aria-labelledby="editInfoTitleLessonModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="readingReviewQuizModalLabel">
                    Edit title lesson!
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                    <div class="form-group">
                        <label for="title-lesson-{!! $lesson->id !!}">
                            Title lesson
                        </label>
                        <input type="text" name="title-lesson-{!! $lesson->id !!}" class="form-control" placeholder="Title" required id="titleLesson{!! $lesson->id !!}" value="{!! $lesson->title !!}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-update-title-lesson btn-warning" onclick="updateTitleLesson({!! $type_lesson_id !!}, {!! $lesson->id !!})">
                    Save
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>