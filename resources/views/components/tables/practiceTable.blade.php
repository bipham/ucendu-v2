<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 10/13/2017
 * Time: 10:56 AM
 */
?>
<table id="reading-list-lesson" class="table datatable display manager-lesson-table">
    <thead>
    <tr>
        <th><label><input class="select-all-lessons" name="all-lessons" type="checkbox" value="all"></label></th>
        <th>ID </th>
        <th>Title </th>
        <th>Type question </th>
        <th>Level lesson </th>
        <th>Order lesson </th>
        <th>Level user </th>
        <th>Created At </th>
        <th>Admin </th>
        <th>Action </th>
    </tr>
    </thead>
    <tbody>
    @foreach($lessons as $key => $lesson)
        <?php
        $type_lesson_id = config('constants.type_lesson.practice');
        $readingLessonService = new App\Services\ReadingLessonService();
        $all_type_questions = $lesson->typeQuestion->levelLesson->typeQuestions()->get();
        $all_orders = $readingLessonService->getAllOrderLessonByTypeQuestionId($type_lesson_id, $lesson->typeQuestion->id);
        $created_at = timeFormat($lesson->created_at);
        ?>
        <tr class="item_row item-lesson-{!! $lesson->id !!}">
            <td><input type="checkbox" name="item-lesson" value="{!! $lesson->id !!}"></td>
            <td>{!! $lesson->id !!}</td>
            <td>
                @include('components.modals.editTitleLessonModal', ['$lesson' => $lesson, 'type_lesson_id' => $type_lesson_id])
            </td>
            <td>
                @include('components.modals.editTypeQuestionModal', ['all_level_lessons' => $all_level_lessons, 'all_type_questions' => $all_type_questions, 'lesson' => $lesson, 'type_lesson_id' => $type_lesson_id, 'all_orders' => $all_orders])
            </td>
            <td>
                @include('components.modals.editLevelLessonModal', ['lesson' => $lesson])
            </td>
            <td>
                @include('components.modals.editOrderLessonModal', ['lesson' => $lesson])
            </td>
            <td>
                @include('components.modals.editLevelUserLessonModal', ['$lesson' => $lesson, 'all_level_users' => $all_level_users, 'type_lesson_id' => $type_lesson_id])
            </td>
            <td>
                {!! $created_at !!}
            </td>
            <td>
                {!! $lesson->User['username'] !!}
            </td>
            <td>
                <a href="{{url('editPracticeLessonReading/' . $lesson->id)}}">
                    <button type="button" class="btn btn-info btn-admin-custom btn-edit-lesson" data-id="{!! $lesson->id !!}">Edit</button>
                </a>
                <button class="btn btn-danger btn-admin-custom btn-del-lesson" data-id="{!! $lesson->id !!}" onclick="deleteReadingLesson({!! $type_lesson_id !!},{!! $lesson->id !!})">Del</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
