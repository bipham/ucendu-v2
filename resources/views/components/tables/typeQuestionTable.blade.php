<?php
/**
 * Created by PhpStorm.
 * User: nobikun1412
 * Date: 15/11/2017
 * Time: 2:50 PM
 */
?>
<?php
$host = $_SERVER['SERVER_NAME'];
$host_names = substr($host, 6);
$home_url = 'http://' . $host_names;
?>
<table id="reading-list-comment" class="table datatable display manager-comments-table">
    <thead>
    <tr>
        <th><label><input class="select-all-lessons" name="all-comments" type="checkbox" value="all"></label></th>
        <th>ID</th>
        <th>Name</th>
        <th>Level Lesson</th>
        <th>Tip guide</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Admin</th>
        <th>Action </th>
    </tr>
    </thead>
    <tbody>
    @foreach($all_type_questions as $key => $type_question)
        <tr class="item-row item-type-question-{!! $type_question->id !!}">
            <td><input type="checkbox" name="item-type-question" value="{!! $type_question->id !!}"></td>
            <td>{!! $type_question->id !!}</td>
            <td class="name-type-question-preview">
                {!! $type_question->name !!}
            </td>
            <td class="level-lesson-preview">
                {!! $type_question->levelLesson->level !!}
            </td>
            <td class="tip-guide-preview">
                {!! $type_question->tip_guide !!}
            </td>
            <td class="status-type-question-preview status-type-question-{!! $type_question->id !!}">
                <div class="badge badge-success status-type-question status-public {!! $type_question->status == 0 ? 'hidden' : '' !!}">Public</div>
                <div class="badge badge-warning status-status-type-question status-private {!! $type_question->status != 0 ? 'hidden' : '' !!}">Not Public</div>
            </td>
            <td class="time-ago-create-preview">
                {!! $type_question->time_ago !!}
            </td>
            <td class="admin-preview">
                {!! $type_question->User->username !!}
            </td>
            <td class="action-type-question-center">
                <a href="{{url('editTypeQuestion/' . $type_question->id)}}">
                    <button type="button" class="btn btn-success btn-admin-custom btn-edit-type-question" data-id="{!! $type_question->id !!}">Edit</button>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

