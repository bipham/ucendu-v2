function checkStepAnswer(){return listAnswer={},listKeyword={},list_type_questions={},$(".preview-content-quiz .card-block .last-option").each(function(){var e=$(this).data("qnumber"),t=$(this).attr("name");t=t.match(/\d+/);var s=$(".answer-"+t).val().trim(),n=CKEDITOR.instances["input_explanation_"+e].getData();""!=s?listAnswer[e]=s:delete listAnswer[e],""==n?(n="No_keywords",listClassKeyword[e]="hidden-class"):listClassKeyword[e]="",listKeyword[e]=n,list_type_questions[e]=type_question_id}),listQ.length==Object.keys(listAnswer).length&&listQ.length==Object.keys(list_type_questions).length}var ajaxFinishCreateNewLearningOfTypeQuestion=baseUrl+"/createNewLearningTypeQuestion",ajaxGetAllTypeQuestionByLevelLessonId=baseUrl+"/getTypeQuestionByLevelLessonId",view_layout="",content_section="",left_section="",right_section="",option_list_questions="",title_section="",listAnswer={},listKeyword={},listClassKeyword={},listQ=[],list_type_questions={},listAnswer_source={},listKeyword_source={},list_type_questions_source={},type_question_id="",i="";$(document).ready(function(){content_section=CKEDITOR.instances.content_section.getData(),left_section=CKEDITOR.instances.left_section.getData(),right_section=CKEDITOR.instances.right_section.getData(),$("#view_layout").on("change",function(){2==(view_layout=$(this).val().trim())?($(".two-layout-content").removeClass("hidden"),$(".first-layout-content").addClass("hidden")):($(".two-layout-content").addClass("hidden"),$(".first-layout-content").removeClass("hidden"))}),$("#list_level").on("change",function(){var e=$(this).val().trim();$.ajax({type:"GET",url:ajaxGetAllTypeQuestionByLevelLessonId,dataType:"json",data:{level_lesson_id:e},success:function(t){$("#list_type_questions").empty(),$("#list_type_questions").append('<option value="'+-e+'">All Of Type</option>'),$.each(t.list_type_questions,function(e,t){$("#list_type_questions").append('<option value="'+t.id+'">'+t.name+"</option>")})},error:function(e){bootbox.alert({message:"FAIL GET ALL TYPE QUESTION!",backdrop:!0})}})}),$(".btn-create-new-section-type-question").click(function(){var e=$("#step_section").val().trim(),t=$("#view_layout").val().trim(),s=$("#name_icon_section").val().trim(),n=CKEDITOR.instances.content_section.getData().trim();checkStepAnswer()&&""!=e?(jQuery.isEmptyObject(listAnswer)&&(listAnswer="null",listKeyword="null",list_type_questions="null"),$.ajax({type:"POST",url:ajaxFinishCreateNewLearningOfTypeQuestion,dataType:"json",data:{type_question_id:type_question_id,step_section:e,view_layout:t,title_section:title_section,name_icon_section:s,content_section:n,left_section:left_section,right_section:right_section,list_answer:listAnswer,list_type_questions:list_type_questions,listKeyword:listKeyword},success:function(e){"fail-step"==e.result?bootbox.alert({message:"Fail! Step section is not available!",backdrop:!0}):"fail-title"==e.result?bootbox.alert({message:"Fail! Title section is not available!",backdrop:!0}):bootbox.alert({message:"Create new learning type question success!",backdrop:!0,callback:function(){location.href=baseUrl+"/createNewLearningTypeQuestion"}})},error:function(e){bootbox.alert({message:"FAIL CREATE NEW learning OF TYPE QUESTION!",backdrop:!0})}})):bootbox.alert({message:"Please enter data!",backdrop:!0})}),$(".btn-next-step-second").click(function(){title_section=$("#title_section").val().trim(),type_question_id=$("#list_type_questions").val().trim(),""==title_section?bootbox.alert({message:"Please enter title section!",backdrop:!0}):($(".step-first").addClass("hidden"),$(".step-second").removeClass("hidden"),$("html, body").animate({scrollTop:$(".new-learning-container").offset().top},100))}),$(".btn-prev-step-first").click(function(){$(".step-second").addClass("hidden"),$(".step-first").removeClass("hidden"),$("html, body").animate({scrollTop:$(".new-learning-container").offset().top},100)}),$(".btn-next-step-third").click(function(){if(content_section!=CKEDITOR.instances.content_section.getData()||left_section!=CKEDITOR.instances.left_section.getData()||right_section!=CKEDITOR.instances.right_section.getData()){content_section=CKEDITOR.instances.content_section.getData(),left_section=CKEDITOR.instances.left_section.getData(),right_section=CKEDITOR.instances.right_section.getData();var e=content_section+left_section+right_section;$(".preview-content-quiz .card-block").html(e),$(".answer-area").html(""),listQ=[],$(".question-quiz").each(function(){var e=$(this).data("qnumber");if(-1==jQuery.inArray(e,listQ)){listQ.push(e);var t=$(this).attr("name");t=t.match(/\d+/),$(".answer-area").append('<div class="answer-key answer-enter-'+e+'" data-qnumber="'+e+'"><h5 class="title-answer-for-question title-custom">Question '+t+':</h5><div class="enter-answer-key row-enter-custom"><div class="title-row-enter">Answer '+t+': </div><input class="answer-q answer-'+t+'" data-qnumber="'+e+'" /></div><div class="enter-keyword row-enter-custom"><div class="title-row-enter">Keyword '+t+': </div><textarea id="input_explanation_'+e+'" class="input-keyword keyword-'+t+'" data-qnumber="'+e+'"></textarea></div></div>'),CKEDITOR.replace("input_explanation_"+e)}-1==jQuery.inArray(e,listAnswer_source)&&($("input.answer-q[data-qnumber="+e+"]").val(listAnswer_source[e]),""==listKeyword_source[e]||void 0==listKeyword_source[e]||null==listKeyword_source[e]?CKEDITOR.instances["input_explanation_"+e].setData(html_table):CKEDITOR.instances["input_explanation_"+e].setData(listKeyword_source[e]),$(".enter-type-question select[data-qnumber="+e+"]").val(list_type_questions_source[e]))})}console.log("listQ: "+listQ),listQ.length>0?$(".no-question").addClass("hidden-class"):$(".no-question").removeClass("hidden-class"),$(".step-second").addClass("hidden"),$(".step-third").removeClass("hidden"),$("html, body").animate({scrollTop:$(".new-learning-container").offset().top},100)}),$(".btn-prev-step-second").click(function(){$(".step-third").addClass("hidden"),$(".step-second").removeClass("hidden"),$("html, body").animate({scrollTop:$(".new-learning-container").offset().top},100)})});