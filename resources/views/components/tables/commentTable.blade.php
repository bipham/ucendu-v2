<?php
/**
 * Created by PhpStorm.
 * User: nobikun1412
 * Date: 11/7/2017
 * Time: 3:41 PM
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
        <th>User</th>
        <th>Comment</th>
        <th>Lesson</th>
        <th>Type lesson</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Action </th>
    </tr>
    </thead>
    <tbody>
    @foreach($all_comments as $key => $comment)
        <tr class="item-row item-comment-{!! $comment['id'] !!}" data-question-id="{!! $comment['question_custom_id'] !!}" data-reply-id="{!! $comment['reply_comment_id'] !!}">
            <td><input type="checkbox" name="item-comment" value="{!! $comment['id'] !!}"></td>
            <td>{!! $comment['id'] !!}</td>
            <td class="user-comment-preview">
                <div class="img-auto-center user-comment-info thumbnail-outer-custom">
                    <img class="rounded img-thumbnail img-feature-user img-feature-custom img-thumbnail-inner" src="{{ asset('public/storage/img/users/' . $comment['avatar']) }}" alt="{!! $comment['username'] !!}" />
                    <span class="username-comment inline-class title-thumbnail-inner">
                        {!! $comment['username'] !!}
                    </span>
                </div>
            </td>
            <td class="content-comment-preview">
                <a href="{{url($home_url . '/reading/' . $comment['level_lesson_id'] . $comment['level_lesson'] .'/readingViewSolutionLesson/' . $comment['type_lesson_id'] . '-' . $comment['lesson_id'] . '?question=' . $comment['question_custom_id'] . '&comment=' . $comment['id'])}}">
                    {!! $comment['content_cmt'] !!}
                </a>
            </td>
            <td class="lesson-title">
                <a href="{{url($home_url . '/reading/' . $comment['level_lesson_id'] . $comment['level_lesson'] .'/readingViewSolutionLesson/' . $comment['type_lesson_id'] . '-' . $comment['lesson_id'])}}">
                    {!! $comment['title_lesson'] !!} - {!! $comment['type_question'] !!}
                </a>
            </td>
            <td class="type-lesson">
                {!! $comment['type_lesson'] !!} - {!! $comment['level_lesson'] !!}
            </td>
            <td class="status-comment-preview status-comment-{!! $comment['id'] !!}">
                <div class="badge badge-success status-comment status-public {!! $comment['private'] != 0 ? 'hidden' : '' !!}">Public</div>
                <div class="badge badge-warning status-comment status-private {!! $comment['private'] == 0 ? 'hidden' : '' !!}">Private</div>
            </td>
            <td class="time-ago-comment-preview">
                {!! $comment['time_ago'] !!}
            </td>
            <td class="edit-comment-center">
                <button type="button" class="btn btn-success btn-admin-custom btn-set-comment-public" data-id="{!! $comment['id'] !!}" data-question-id="{!! $comment['question_custom_id'] !!}" data-reply-id="{!! $comment['reply_comment_id'] !!}" onclick="setPublicReadingComment({!! $comment['id'] !!})" @if($comment['private'] == 0) disabled @endif>Set public</button>
                <button type="button" class="btn btn-warning btn-admin-custom btn-set-comment-private" data-id="{!! $comment['id'] !!}" data-question-id="{!! $comment['question_custom_id'] !!}" data-reply-id="{!! $comment['reply_comment_id'] !!}" onclick="setPrivateReadingComment({!! $comment['id'] !!})" @if($comment['private'] == 1) disabled @endif>Set private</button>
                <button type="button" class="btn btn-danger btn-admin-custom btn-del-lesson" data-id="{!! $comment['id'] !!}" data-question-id="{!! $comment['question_custom_id'] !!}" data-reply-id="{!! $comment['reply_comment_id'] !!}" onclick="deleteReadingComment({!! $comment['id'] !!})">Del</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
