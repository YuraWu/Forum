var checkLogin = function(){
	var user_ID = getUserID();
	if(user_ID > 0){
		$("[userID="+user_ID+"]").show();
		return true;
	}else{
		return false;
	}
}
var getUserID = function(){
	var user_ID = 0;
	$.ajaxSetup({
		async:false
	})
	$.get("getUserID.php",function(ID){
		user_ID = ID;
	})
	return user_ID;
}
var login = function(user_ID){
	$("#user-id").attr("value",user_ID);
	checkLogin();
}
var logout = function(){
	$("#user-id").attr("value","0");
	$(".requireLogin").hide();
}
var initEvaluate = function(){
	$(".questionInfo-evaluate-praise").unbind();
	$(".questionInfo-evaluate-praised").unbind();
	$(".questionInfo-evaluate-nopraise").unbind();
	$(".questionInfo-evaluate-praise").click(praise_add);
	$(".questionInfo-evaluate-praised").mouseenter(function(){
		$(".questionInfo-evaluate-praiseLabel").html("取消");
	}).mouseleave(function(){
		$(".questionInfo-evaluate-praiseLabel").html("已赞");
	}).click(praise_cancel);
	$(".questionInfo-evaluate-degrade").unbind();
	$(".questionInfo-evaluate-degraded").unbind();
	$(".questionInfo-evaluate-nodegrade").unbind();
	$(".questionInfo-evaluate-degrade").click(degrade_add);
	$(".questionInfo-evaluate-degraded").mouseenter(function(){
		$(".questionInfo-evaluate-degradeLabel").html("取消");
	}).mouseleave(function(){
		$(".questionInfo-evaluate-degradeLabel").html("已贬");
	}).click(degrade_cancel);
	$(".questionInfo-care").unbind();
	$(".questionInfo-cared").unbind();
	$(".questionInfo-care").click(care_add);
	$(".questionInfo-cared").mouseenter(function(){
		$(".questionInfo-careLabel").html("取消");
	}).mouseleave(function(){
		$(".questionInfo-careLabel").html("已关心");
	}).click(care_cancel);
};
var praise_add = function(){
	if(checkLogin()){
		var question_ID = $("#question-ID").val();
		$.post("saveEvaluate.php",{"question_ID":question_ID,"type":'praise',"operation":'save'},function(data){
			if(data == "noUser"){
				alert("noUser");
			}else{
				$(".questionInfo-evaluate-praiseLabel").html("已赞");
				$(".questionInfo-evaluate-praise").attr("class","questionInfo-evaluate-praised");
				$(".questionInfo-evaluate-degrade").attr("class","questionInfo-evaluate-nodegrade");
				$(".questionInfo-evaluate-praiseCnt").html(data);
			}
		});
		initEvaluate();
	}else{
		$(".loginBox").fadeIn(400);
	}
};
var praise_cancel = function(){
	if(checkLogin()){
		var question_ID = $("#question-ID").val();
		$.post("saveEvaluate.php",{"question_ID":question_ID,"type":'praise',"operation":'cancel'},function(data){
			if(data == "noUser"){
				alert("请登录");
			}else{
				$(".questionInfo-evaluate-praiseLabel").html("赞");
				$(".questionInfo-evaluate-praised").attr("class","questionInfo-evaluate-praise");
				$(".questionInfo-evaluate-nodegrade").attr("class","questionInfo-evaluate-degrade");
				$(".questionInfo-evaluate-praiseCnt").html(data);
			}
		});
		initEvaluate();
	}else{
		$(".loginBox").fadeIn(400);
	}
};
var degrade_add = function(){
	if(checkLogin()){
		var question_ID = $("#question-ID").val();
		$.post("saveEvaluate.php",{"question_ID":question_ID,"type":'degrade',"operation":'save'},function(data){
			if(data == "noUser"){
				alert("请登录");
			}else{
				$(".questionInfo-evaluate-degradeLabel").html("已贬");
				$(".questionInfo-evaluate-degrade").attr("class","questionInfo-evaluate-degraded");
				$(".questionInfo-evaluate-praise").attr("class","questionInfo-evaluate-nopraise");
				$(".questionInfo-evaluate-degradeCnt").html(data);
			}
		});
		initEvaluate();
	}else{
		$(".loginBox").fadeIn(400);
	}
};
var degrade_cancel = function(){
	if(checkLogin()){
		var question_ID = $("#question-ID").val();
		$.post("saveEvaluate.php",{"question_ID":question_ID,"type":'degrade',"operation":'cancel'},function(data){
			if(data == "noUser"){
				alert("请登录");
			}else{
				$(".questionInfo-evaluate-degradeLabel").html("贬");
				$(".questionInfo-evaluate-degraded").attr("class","questionInfo-evaluate-degrade");
				$(".questionInfo-evaluate-nopraise").attr("class","questionInfo-evaluate-praise");
				$(".questionInfo-evaluate-degradeCnt").html(data);
			}
		});
		initEvaluate();
	}else{
		$(".loginBox").fadeIn(400);
	}
};
var care_add = function(){
	if(checkLogin()){
		var question_ID = $("#question-ID").val();		
		$.post("saveCare.php",{"question_ID":question_ID,"type":'care',"operation":'save'},function(data){
			if(data == "noUser"){
				alert("请登录");
			}else{
				$(".questionInfo-careLabel").html("已关心");
				$(".questionInfo-care").attr("class","questionInfo-cared");
				$(".questionInfo-careCnt").html(data);
			}
		});
		initEvaluate();
	}else{
		$(".loginBox").fadeIn(400);
	}
};
var care_cancel = function(){
	if(checkLogin()){
		var question_ID = $("#question-ID").val();
		$.post("saveCare.php",{"question_ID":question_ID,"type":'care',"operation":'cancel'},function(data){
			if(data=="noUser"){
				alert("请登录");
			}else{
				$(".questionInfo-careLabel").html("关心");
				$(".questionInfo-cared").attr("class","questionInfo-care");
				$(".questionInfo-careCnt").html(data);
			}
		});
		initEvaluate();
	}else{
		$(".loginBox").fadeIn(400);
	}
};
var setSatisfied = function(){
	if(checkLogin()){
		var answer_ID = $(this).parent().parent().find(".answer-ID").attr("value");
		$.post("saveSatisfied.php",{"answer_ID":answer_ID},function(data){
			if(data=='noUser'){
				alert("请登录");
			}else if(data=='noAnswer'){
				alert("该回答不存在");
			}else if(data=='noPower'){
				alert('您没有权限');
			}else{
				location.reload();
			}
		})
	}else{
		$(".loginBox").fadeIn(400);
	}
}
var initAnswerEvaluate = function(){
	$(".questionInfo-answer-praise").unbind().click(answer_praise);
	$(".questionInfo-answer-praised").unbind();
	$(".questionInfo-answer-nopraise").unbind();
	$(".questionInfo-answer-degrade").unbind().click(answer_degrade);
	$(".questionInfo-answer-degraded").unbind();
	$(".questionInfo-answer-nodegrade").unbind();
	$(".questionInfo-answer-setSatisfied").unbind().click(setSatisfied);
}
var answer_praise = function(){
	if(checkLogin()){
		var button = $(this);
		var answer_ID = $(this).parent().parent().find(".answer-ID").val();
		var user_ID = getUserID();
		$.post("saveanswerEvaluate.php",{"answer_ID":answer_ID,"user_ID":user_ID,"type":'praise'},function(data){
			button.attr("value","已赞 "+data).attr("class","questionInfo-answer-praised");
			$(".questionInfo-answer-degrade").attr("class","questionInfo-answer-nodegrade");
		})
		initAnswerEvaluate();
	}else{
		$(".loginBox").fadeIn(400);
	}	
}
var answer_degrade = function(){
	if(checkLogin()){
		var button = $(this);
		var answer_ID = $(this).parent().parent().find(".answer-ID").val();
		var user_ID = getUserID();
		$.post("saveanswerEvaluate.php",{"answer_ID":answer_ID,"user_ID":user_ID,"type":'degrade'},function(data){
			button.attr("value","已贬"+data).attr("class","questionInfo-answer-degraded");
			$(".questionInfo-answer-praise").attr("class","questionInfo-answer-nopraise");
		})
		initAnswerEvaluate();
	}else{
		$(".loginBox").fadeIn(400);
	}
}
var initComment = function(){
	$(".questionInfo-comment-showbutton").unbind();
	$(".questionInfo-comment-hidebutton").unbind();
	$(".questionInfo-comment-showbutton").click(showCommentArea);
	$(".questionInfo-comment-hidebutton").click(hideCommentArea);
};
var showCommentArea = function(){
	var hideButton = $(this).parent().find(".questionInfo-comment-hidebutton");
	var panel = $(this).parent().next(".questionInfo-commentPanel");
	$(this).hide();
	panel.stop(true).queue(function(){
		hideButton.show();
		initComment();
		$(this).dequeue();
	}).slideToggle(300);	
};
var hideCommentArea = function(){
	var showButton = $(this).parent().find(".questionInfo-comment-showbutton");
	var panel = $(this).parent().next(".questionInfo-commentPanel");
	$(this).hide();
	panel.stop(true).queue(function(){
		showButton.show();
		initComment();
		$(this).dequeue();
	}).slideToggle(300);
};
var initMyComment = function(){
	$(".questionInfo-myComment-showbutton").unbind();
	$(".questionInfo-myComment-hidebutton").unbind();
	$(".questionInfo-myComment-showbutton").click(showMyCommentArea);
	$(".questionInfo-myComment-hidebutton").click(hideMyCommentArea);
};
var showMyCommentArea = function(){
	if(checkLogin()){
		var area = $(this).parent().find(".questionInfo-myCommentArea");
		var hideButton = $(this).parent().find(".questionInfo-myComment-hidebutton");
		$(this).hide();
		area.stop(true).queue(function(){
			hideButton.show();
			initMyComment();
			$(this).dequeue();
		}).slideToggle(200);
	}else{
		$(".loginBox").fadeIn(400);
	}
};
var hideMyCommentArea = function(){
	var area = $(this).parent().find(".questionInfo-myCommentArea");
	var showButton = $(this).parent().find(".questionInfo-myComment-showbutton");
	$(this).hide();
	area.stop(true).queue(function(){
		showButton.show();
		initMyComment();
		$(this).dequeue();
	}).slideToggle(200);
};
var initAnswerSubmit = function(){
	$("#answer-submit").unbind().click(saveAnswer);
}
var initAnswerDelete = function(){
	$(".questionInfo-answer-delete").unbind().click(deleteAnswer);
};
var initCommentSubmit = function(){
	$(".myComment-submit").unbind().click(saveComment);
}

var initCommentDelete = function(){
	$(".comment-delete").unbind().click(deleteComment);
}
var saveAnswer = function(){
	if(checkLogin()){
		var editor=UE.getEditor('myEditor');
		editor.sync();
		var content = editor.getContent();
		var question_ID = $("#question-ID").val();
		if(content){
			$.getJSON("saveAnswer.php",{"content":content,"question_ID":question_ID},function(json){
				$.each(json,function(i,item){
					if(i == 0){
						if(item == "noUser"){
							alert("请登录");
						}else{
							$(".questionInfo-normalAnswerLabel").html(item);
						}
					}
					if(i==1){
						var normalAnswer = $("<div>").attr("class","questionInfo-normalAnswer").html(item);
						$(".questionInfo-normalAnswerList").append(normalAnswer);
						checkLogin();
						initComment();
						initMyComment();

						initAnswerEvaluate();
						initCommentSubmit();
						initAnswerDelete();
						initCommentDelete();
					}
				});
				
			});
			editor.execCommand('cleardoc');
		}else{
			alert("无回答内容");
		}
	}else{
		$(".loginBox").fadeIn(400);
	}
}
var saveComment = function(){
	if(checkLogin()){
		var textarea = $(this).parent().parent().find("textarea");
		var content = textarea.val();
		var answer_ID = $(this).parent().parent().parent().parent().parent().find(".answer-ID").val();
		var label = $(this).parent().parent().parent().parent().parent().find(".questionInfo-comment-showbutton");
		var commentList = $(this).parent().parent().parent().parent().find(".questionInfo-commentList");
		$(this).parent().parent().parent().parent().find(".questionInfo-noComment").remove();
		var comment = $("<div>").attr("class","questionInfo-comment");
		$.getJSON("saveComment.php",{"content":content,"answer_ID":answer_ID},function(json){
			$.each(json,function(idx,item){
				if(idx == 0){
					if(item == "noUser"){
						alert("请登录");
					}else{
						var value = "评论 " + item;
						label.val(value);
						textarea.val("");
					}
				}
				if(idx == 1){
					comment.html(item);
					commentList.append(comment);
					checkLogin();
					initCommentDelete();
				}
			});	
		});
	}else{
		$(".loginBox").fadeIn(400);
	}
};
var deleteAnswer = function(){
	if(checkLogin()){
		var answer_ID = $(this).parent().parent().find(".answer-ID").attr("value");
		var answer = $(this).parent();
		if(confirm("删除回答将删除别人的评论，作为惩罚扣除5点积分，是否继续?")){
			$.post("deleteAnswer.php",{"ID":answer_ID},function(data){
				if(data=="noAnswer"){
					alert("回答不存在");
				}else if(data == "noPower"){
					alert("这不是你的回答");
				}else if(data == "noPoint"){
					alert("您的积分不足");
				}else{
					if(data.indexOf("满意回答")>=0){
						if(data == "满意回答 0"){
							answer.parent().remove();
						}else{
							$(".questionInfo-satisfiedAnswerLabel").html(data);
							answer.parent().remove();
						}
					}else{
						$(".questionInfo-normalAnswerLabel").html(data);
						answer.parent().remove();
					}
				}
			})
		}
	}else{
		$(".loginBox").fadeIn(400);
	}
}
var deleteComment = function(){
	if(checkLogin()){
		var comment_ID = $(this).parent().find(".comment-ID").val();
		var answer_ID = $(this).parent().parent().parent().parent().find(".answer-ID").val();
		var comment = $(this).parent().parent();
		var commentList = comment.parent();
		var label = $(this).parent().parent().parent().parent().parent().find(".questionInfo-comment-showbutton");
		$.post("deleteComment.php",{"comment_ID":comment_ID,"answer_ID":answer_ID},function(data){
			if(data == 'noComment'){
				alert("评论不存在");
			}else if(data == "noPower"){
				alert("没有权限");
			}else{
				var value = "评论 " + data; 
				label.val(value);
				comment.remove();
				if(commentList.find(".questionInfo-comment").length == 0){
					var noComment = $("<div>").attr("class","questionInfo-noComment").html("本回答暂无评论");
					commentList.append(noComment);
				}
			}
		});
	}else{
		$(".loginBox").fadeIn(400);
	}
};

$(function(){
	initEvaluate();
	initAnswerEvaluate();
	initComment();
	initMyComment();
	initAnswerSubmit();
	initCommentSubmit();
	initAnswerDelete();
	initCommentDelete();
	checkLogin();
	ajaxLogin();
	ajaxLogout();
});