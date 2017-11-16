function showExplanation(t,e,a){"use strict";a=a||!1;var i=baseUrl+"/showExplanation/"+t;$.ajax({type:"GET",url:i,dataType:"json",success:function(i){console.log("data: "+JSON.stringify(i)),$(".title-explanation").html("EXPLANATION - Question "+e),$(".explanation-detail").html(i.explanation),$(".solution-detail").addClass("transform-scale-width-custom-active"),$(".explanation-column").removeClass("hidden"),$(".explanation-column").addClass("transform-right-custom-active");var s=$(".highlighting");s.removeClass("highlighting"),s.addClass("hidden-highlight"),$(".highlight-"+e).removeClass("hidden-highlight"),$(".highlight-"+e).addClass("highlighting"),$("html, body").animate({scrollTop:$(".panel-container").offset().top},100);var n="highlight-"+e,m=$(".left-panel-custom").offset().top,c=$("."+n).offset().top+$(".left-panel-custom").scrollTop()-m;if($(".left-panel-custom").animate({scrollTop:c-60},{duration:2e3,complete:function(){}}),$("#commentArea .comments-area").html(""),$("#commentArea .primary-comment").html(""),i.list_comments.length>0&&jQuery.each(i.list_comments,function(e,a){insertNewComment(i.current_user_info.id,i.current_user_info.level_user_id,a.id,a.private,a.avatar,a.content_cmt,a.updated_at,t,a.username,a.reply_comment_id,a.user_id)}),parseInputCommentPrimary(current_user_avatar,current_username,t),0==$("#commentArea .comments-area .list-cmt-area").length&&$("#commentArea .comments-area").append('<p class="no-cmt">No comment for this question, be a first persion comment on this!</p>'),$("#loading").hide(),a){if(question_id_noti&&comment_id_noti){$("html, body").animate({scrollTop:$(".solution-detail").offset().top},1e3);var o=60,l=$(".explanation-column").offset().top,r=(d=$("#comment"+comment_id_noti).offset().top)+(p=$(".explanation-column").scrollTop())-l;$(".explanation-column").animate({scrollTop:r-o}),$("#comment"+comment_id_noti).addClass("current-cmt"),setTimeout(function(){$("#comment"+comment_id_noti).addClass("time-out-current-cmt")},3e3)}}else{$("html, body").animate({scrollTop:$(".solution-detail").offset().top},1e3);var o=60,l=$(".explanation-column").offset().top,d=$("#commentArea").offset().top,p=$(".explanation-column").scrollTop(),r=d+p-l;$(".explanation-column").animate({scrollTop:r-o})}},error:function(t){bootbox.alert({message:"FAIL GET EXPLANATION!",backdrop:!0})}})}function closeExplanation(){$(".explanation-column").addClass("hidden"),$(".solution-detail").removeClass("transform-scale-width-custom-active"),$(".explanation-column").removeClass("transform-right-custom-active")}function enterComment(t){if(13==t.keyCode){var e=current_user_id,a=$(this).val().trim();if(""!=a){$(this).val("");var i=$(this).data("question-id"),s=$(this).data("reply-cmt-id"),n=baseUrl+"/enterNewComment",m=$("input[name='_token']").val();$.ajax({type:"POST",url:n,dataType:"json",data:{_token:m,user_id:e,content_cmt:a,question_custom_id:i,reply_id:s},success:function(t){$("p.no-cmt").remove(),$(".item-reply-sub-cmt").remove(),insertNewComment(current_user_id,current_level_user,t.new_comment.id,t.new_comment.private,current_user_avatar,a,"Just now",i,current_username,s,current_user_id),$("input.reply-cmt-"+i).data("reply-cmt-id",0),$("html,body").animate({scrollTop:$(".cmt-"+t.new_comment.id).offset().top-20},500)},error:function(t){bootbox.alert({message:"Error, please contact admin!",backdrop:!0})}})}}}function replyComment(t,e){var a=current_user_avatar,i=current_username,s=$(".cmt-"+t).parent().data("cmt-id"),n=$(".cmt-"+t).parent(".list-cmt-area");n.find(".item-reply-sub-cmt").length>0?$("input.reply-sub-cmt-"+e).data("reply-cmt-id",s):n.append('<div class="item-reply-sub-cmt item-sub-cmt" id="replySubComment"><span class="img-avatar"><img alt="" src="/storage/img/users/'+a+'" class="img-custom avatar-custom" /></span><span class="item-cmt-content"><div class="item-cmt-header">'+i+'</div><div class="item-cmt-body"><input type="text" placeholder=" Write a reply ..." class="reply-cmt reply-sub-cmt reply-sub-cmt-'+s+'" data-reply-cmt-id="'+s+'" data-question-id = "'+e+'"></div><div class="item-time-cmt"></div></span></div></div>'),$("input.reply-sub-cmt-"+s).focus(),$("html, body").animate({scrollTop:$(".panel-container").offset().top},100);var m=$(".right-panel-custom").offset().top,c=$("input.reply-sub-cmt-"+s).offset().top+$(".right-panel-custom").scrollTop()-m;$(".right-panel-custom").animate({scrollTop:c-100},{duration:100,complete:function(){}})}function parseInputCommentPrimary(t,e,a){$("#commentArea .primary-comment").append('<div class="item-reply-cmt" id="replyComment"><span class="img-avatar"><img alt="" src="/public/storage/img/users/'+t+'" class="img-custom avatar-custom" /></span><span class="item-cmt-content"><div class="item-cmt-header">'+e+'</div><div class="item-cmt-body"><input type="text" placeholder=" Write your comment ..." class="reply-cmt reply-cmt-'+a+'" data-reply-cmt-id="0" data-question-id = "'+a+'"></div><div class="item-time-cmt"></div></span></div></div>')}function insertNewComment(t,e,a,i,s,n,m,c,o,l,r){var d="",p="",u="item-cmt-public";1==i?(d="disabled",u="item-cmt-private"):p="disabled",1==e?0==l?$("#commentArea .comments-area").append('<div class="row list-cmt-area list-cmt-'+a+'" data-cmt-id="'+a+'"><div class="item-cmt cmt-'+a+" "+u+'" id="comment'+a+'" data-cmt-id="'+a+'"><span class="img-avatar"><img alt="" src="/public/storage/img/users/'+s+'" class="img-custom avatar-custom" /></span><span class="item-cmt-content"><div class="item-cmt-header">'+o+'</div><div class="item-cmt-body">'+n+'</div><div class="item-time-cmt"><span class="img-time-cmt"><img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" /></span><span class="time-ago-cmt">'+m+'</span><span class="reply-cmt pull-right"><button type="button" class="btn btn-success btn-admin-custom btn-set-comment-public" data-id="'+a+'" data-question-id="'+c+'" data-reply-id="'+l+'" onclick="setPublicReadingComment('+a+')"'+p+'>Set public</button><button type="button" class="btn btn-warning btn-admin-custom btn-set-comment-private" data-id="'+a+'" data-question-id="'+c+'" data-reply-id="'+l+'" onclick="setPrivateReadingComment('+a+')"'+d+'>Set private</button><button type="button" class="btn btn-danger btn-admin-custom btn-del-lesson" data-id="'+a+'" data-question-id="'+c+'" data-reply-id="'+l+'" onclick="deleteReadingComment('+a+')">Del</button><button type="button" class="btn btn-reply-cmt btn-sm btn-outline-primary" onclick="replyComment('+a+", "+c+')">Reply</button></span></div></span></div></div>'):$(".list-cmt-"+l).append('<div class="item-cmt item-sub-cmt cmt-'+a+" "+u+'" id="comment'+a+'" data-cmt-id="'+a+'"><span class="img-avatar"><img alt="" src="/public/storage/img/users/'+s+'" class="img-custom avatar-custom" /></span><span class="item-cmt-content"><div class="item-cmt-header">'+o+'</div><div class="item-cmt-body">'+n+'</div><div class="item-time-cmt"><span class="img-time-cmt"><img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" /></span><span class="time-ago-cmt">'+m+'</span><span class="reply-cmt pull-right"><button type="button" class="btn btn-success btn-admin-custom btn-set-comment-public" data-id="'+a+'" data-question-id="'+c+'" data-reply-id="'+l+'" onclick="setPublicReadingComment('+a+')"'+p+'>Set public</button><button type="button" class="btn btn-warning btn-admin-custom btn-set-comment-private" data-id="'+a+'" data-question-id="'+c+'" data-reply-id="'+l+'" onclick="setPrivateReadingComment('+a+')"'+d+'>Set private</button><button type="button" class="btn btn-danger btn-admin-custom btn-del-lesson" data-id="'+a+'" data-question-id="'+c+'" data-reply-id="'+l+'" onclick="deleteReadingComment('+a+')">Del</button><button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment('+a+", "+c+')">Reply</button></span></div></span></div>'):0!=i&&r!=t||(0==l?$("#commentArea .comments-area").append('<div class="row list-cmt-area list-cmt-'+a+'" data-cmt-id="'+a+'"><div class="item-cmt cmt-'+a+'" id="comment'+a+'" data-cmt-id="'+a+'"><span class="img-avatar"><img alt="" src="/public/storage/img/users/'+s+'" class="img-custom avatar-custom" /></span><span class="item-cmt-content"><div class="item-cmt-header">'+o+'</div><div class="item-cmt-body">'+n+'</div><div class="item-time-cmt"><span class="img-time-cmt"><img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" /></span><span class="time-ago-cmt">'+m+'</span><span class="reply-cmt pull-right"><button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment('+a+", "+c+')">Reply</button></span></div></span></div></div>'):$(".list-cmt-"+l).append('<div class="item-cmt item-sub-cmt cmt-'+a+'" id="comment'+a+'" data-cmt-id="'+a+'"><span class="img-avatar"><img alt="" src="/public/storage/img/users/'+s+'" class="img-custom avatar-custom" /></span><span class="item-cmt-content"><div class="item-cmt-header">'+o+'</div><div class="item-cmt-body">'+n+'</div><div class="item-time-cmt"><span class="img-time-cmt"><img alt="time-cmt" src="/public/imgs/original/time.png" class="img-time-cmt" /></span><span class="time-ago-cmt">'+m+'</span><span class="reply-cmt pull-right"><button type="button" class="btn btn-sm btn-outline-primary" onclick="replyComment('+a+", "+c+')">Reply</button></span></div></span></div>'))}$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('[name="_token"]').val()}});var token=$('[name="_token"]').val(),baseUrl=document.location.origin;