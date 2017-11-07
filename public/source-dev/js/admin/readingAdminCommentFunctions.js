/**
 * Created by nobikun1412 on 11/7/2017.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('[name="_token"]').val()
    }
});
var token = $('[name="_token"]').val();
var baseUrl = document.location.origin;

function deleteReadingComment(id) {
    bootbox.confirm({
        title: "Delete Reading Comment",
        message: "Do you want to delete this comment?" + id,
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel',
                className: 'btn-danger'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm',
                className: 'btn-success'
            }
        },
        callback: function (result) {
            if(result) {
                var ajaxDelCommentReading = baseUrl + '/deleteCommentReading/' + id;
                console.log('ajaxDelCommentReading ' + ajaxDelCommentReading);
                $.ajax({
                    type: "GET",
                    url: ajaxDelCommentReading,
                    dataType: "json",
                    // data: { },
                    success: function (data) {
                        bootbox.alert({
                            message: "Delete comment success! " + data.result,
                            backdrop: true,
                            callback: function(){
                                // location.href= baseUrl + '/listCommentReading';
                                var reply_id_deleted = $('.btn-set-comment-public[data-id=' + id + ']').data('reply-id');
                                if (reply_id_deleted == 0) {
                                    $('.list-cmt-' + id).remove();
                                }
                                else {
                                    $('#comment' + id).remove();
                                }
                            }
                        });
                    },
                    error: function (data) {
                        bootbox.alert({
                            message: "Delete comment fail!",
                            backdrop: true
                        });
                    }
                });
            }
        }
    });
}

function setPublicReadingComment(id) {
    var $this = $(this);
    bootbox.confirm({
        title: "Set public reading comment",
        message: "Do you want to set public for this comment?",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel',
                className: 'btn-danger'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm',
                className: 'btn-success'
            }
        },
        callback: function (result) {
            if(result) {
                var ajaxSetPublicReadingComment = baseUrl + '/setPublicReadingComment/' + id;
                $.ajax({
                    type: "GET",
                    url: ajaxSetPublicReadingComment,
                    dataType: "json",
                    // data: { },
                    success: function (data) {
                        bootbox.alert({
                            message: "Set public comment success! " + data.result,
                            backdrop: true,
                            callback: function(){
                                // location.href= baseUrl + '/listCommentReading';
                                $('.btn-set-comment-public[data-id=' + id + ']').prop('disabled', true);
                                $('.btn-set-comment-private[data-id=' + id + ']').prop('disabled', false);
                            }
                        });
                    },
                    error: function (data) {
                        bootbox.alert({
                            message: "Set public comment fail!",
                            backdrop: true
                        });
                    }
                });
            }
        }
    });
}

function setPrivateReadingComment(id) {
    bootbox.confirm({
        title: "Set private reading comment",
        message: "Do you want to set private for this comment?",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel',
                className: 'btn-danger'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm',
                className: 'btn-success'
            }
        },
        callback: function (result) {
            if(result) {
                var ajaxSetPrivateReadingComment = baseUrl + '/setPrivateReadingComment/' + id;
                $.ajax({
                    type: "GET",
                    url: ajaxSetPrivateReadingComment,
                    dataType: "json",
                    // data: { },
                    success: function (data) {
                        bootbox.alert({
                            message: "Set private comment success! " + data.result,
                            backdrop: true,
                            callback: function(){
                                // location.href= baseUrl + '/listCommentReading';
                                $('.btn-set-comment-public[data-id=' + id + ']').prop('disabled', false);
                                $('.btn-set-comment-private[data-id=' + id + ']').prop('disabled', true);
                            }
                        });
                    },
                    error: function (data) {
                        bootbox.alert({
                            message: "Set private comment fail!",
                            backdrop: true
                        });
                    }
                });
            }
        }
    });
}