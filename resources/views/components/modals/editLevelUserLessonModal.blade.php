<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 10/16/2017
 * Time: 10:06 AM
 */
?>
<!-- Button Edit Title Lesson-->
<div class="basic-info info-level-user">
    <h6 class="title-info-custom level-user-custom level-user-lesson-{!! $lesson->id !!}">
        {!! $lesson->levelUser->level !!}
    </h6>
    <i class="btn-edit-basic-info fa fa-pencil-square-o" aria-hidden="true" data-id="{!! $lesson->id !!}" data-toggle="modal" data-target="#editUpdateLevelUserLessonModal-{!! $lesson->id !!}"></i>
</div>

<!-- Modal Edit Level User Lesson-->
<div class="modal fade" id="editUpdateLevelUserLessonModal-{!! $lesson->id !!}" tabindex="-1" data-id="{!! $lesson->id !!}" role="dialog" aria-labelledby="editUpdateLevelUserLessonModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="readingReviewQuizModalLabel">
                    Edit level user lesson!
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                    <div class="form-group">
                        <label for="level-user-lesson-{!! $lesson->id !!}">
                            Level user lesson
                        </label>
                        <select class="form-control" id="level-user-lesson-{!! $lesson->id !!}" name="level-user-lesson-{!! $lesson->id !!}" >
                            @foreach($all_level_users as $level_user)
                                <option value="{!! $level_user->id !!}" @if($level_user->id == $lesson->levelUser->id) selected="selected" @endif>{!! $level_user->level !!}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-update-level-user-lesson btn-warning" onclick="updateLevelUserLesson({!! $type_lesson_id !!}, {!! $lesson->id !!})">
                    Save
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

