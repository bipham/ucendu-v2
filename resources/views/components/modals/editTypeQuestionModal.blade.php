<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 10/13/2017
 * Time: 2:21 PM
 */
?>
<!-- Button Edit Type Question-->
<div class="basic-info info-type-question">
    <h6 class="title-info-custom type-question-custom type-question-lesson-{!! $lesson->id !!}">
        {!! $lesson->typeQuestion->name !!}
    </h6>
    <i class="btn-edit-basic-info fa fa-pencil-square-o" aria-hidden="true" data-id="{!! $lesson->id !!}" data-toggle="modal" data-target="#editBasicInfoLessonModal-{!! $lesson->id !!}"></i>
</div>

<!-- Modal Edit Type Question-->
<div class="modal fade" id="editBasicInfoLessonModal-{!! $lesson->id !!}" tabindex="-1" data-id="{!! $lesson->id !!}" role="dialog" aria-labelledby="editBasicInfoLessonModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="readingReviewQuizModalLabel">
                    Edit type question!
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                    <div class="form-group">
                        <label for="list_level{!! $lesson->id !!}">
                            Select level lesson!
                        </label>
                        <select class="form-control" id="list_level{!! $lesson->id !!}" name="list_level{!! $lesson->id !!}" onchange="getAllTypeQuestionByLevelLessonId({!! $lesson->id !!})">
                            @foreach($all_level_lessons as $level_lesson)
                                <option value="{!! $level_lesson->id !!}" @if($level_lesson->id == $lesson->typeQuestion->levelLesson->id) selected="selected" @endif>{!! $level_lesson->level !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="list_type_questions{!! $lesson->id !!}">
                            Select type question!
                        </label>
                        <select class="form-control" id="list_type_questions{!! $lesson->id !!}" name="list_type_questions{!! $lesson->id !!}" >
                            @foreach($all_type_questions as $type_question)
                                <option value="{!! $type_question->id !!}" @if($type_question->id == $lesson->typeQuestion->id) selected="selected" @endif>{!! $type_question->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="show-order">
                            <div class="title-list-order">List ordered</div>
                            <ul class="list-ordered list-ordered-{!! $lesson->id !!}">
                                @foreach($all_orders as $ordered)
                                    <li>{!! $ordered->order_lesson !!}</li>
                                @endforeach
                            </ul>
                        </div>
                        <label for="order-lesson-{!! $lesson->id !!}">
                            Order lesson
                        </label>
                        <input type="number" min="1" name="order-lesson-{!! $lesson->id !!}" class="form-control" placeholder="Order number" required id="orderLesson{!! $lesson->id !!}" value="{!! $lesson->order_lesson !!}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-update-type-question btn-warning" onclick="updateBasicInfoLesson({!! $type_lesson_id !!}, {!! $lesson->id !!})">
                    Save
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
