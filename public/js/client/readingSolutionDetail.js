var getUrlParameter=function(t){var n,e,i=decodeURIComponent(window.location.search.substring(1)).split("&");for(e=0;e<i.length;e++)if((n=i[e].split("="))[0]===t)return void 0===n[1]||n[1]},question_id_noti=getUrlParameter("question"),comment_id_noti=getUrlParameter("comment"),mainUrl_tmp=baseUrl.substring(7),adminBaseUrl="http://admin."+mainUrl_tmp;$(document).ready(function(){var t=$(".show-explanation-"+question_id_noti).data("qorder");jQuery(function(){question_id_noti&&comment_id_noti&&showExplanation(question_id_noti,t,!0)})}),$(document).on("keypress","input.reply-cmt",enterComment);