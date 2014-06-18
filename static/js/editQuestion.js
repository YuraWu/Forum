$(function(){
	ajaxLogin();
	checkPoint();
	$("#editQuestion-title").keydown(function(event){
		var content = $(this).val();
		$("#editQuestion-tagPanel").empty();
		$.getJSON("getQuestiontags.php",{data:content},function(json){
			$.each(json,function(i,item){
				var num = i+1;
				var id = "editQuestion-tag" + num;
				var checkbox = $("<input>").attr("type","checkbox").attr("name","questionTags[]").val(item[0]);
				var button = $("<div>").attr("class","tag").attr("id",id).html(item[1]);
				button.append(checkbox);
				button.click(function(){
					if(!$(this).find(":checkbox").is(":checked")){
						$(this).css("box-shadow","0 0 0 1px #303e55");
						$(this).find(":checkbox").attr("checked",true);
					}else{
						$(this).css("box-shadow","none");
						$(this).find(":checkbox").attr("checked",false);
					}
				});
				$("#editQuestion-tagPanel").append(button);
			});
		});
	});
	$(".editQuestion-defineMyTag").click(showDefineTag);
	$("#editQuestion-defineTag-close").click(function(){
		$("#editQuestion-defineTag").fadeOut(400);
	});
	$("#editQuestion-defineTag-name").focus(function(){
		$("#tag-error").hide();
	});
	$("#editQuestion-defineTag-submit").click(function(){
		var name = $("#editQuestion-defineTag-name").val();
		if(checkTag()){
			$.get("getUserID.php",function(id){
				if(id > 0){
					$.post("saveTag.php",{"name":name,"userID":id},function(data){
						var checkbox = $("<input>").attr("type","checkbox").attr("name","questionTags[]").val(data);
						var button = $("<div>").attr("class","tag").html(name);
						button.append(checkbox);
						button.click(function(){
							if(!$(this).find(":checkbox").is(":checked")){
								$(this).css("box-shadow","0 0 0 1px #303e55");
								$(this).find(":checkbox").attr("checked",true);
							}else{
								$(this).css("box-shadow","none");
								$(this).find(":checkbox").attr("checked",false);
							}
						});
						$("#editQuestion-myTagPanel").append(button);
					})
					$("#editQuestion-defineTag-name").val("");
					$("#editQuestion-defineTag").fadeOut(400);
				}else{
					alert("请登录");
					$("#editQuestion-defineTag-name").val("");
					$("#editQuestion-defineTag").fadeOut(400);
				}
			})
		}
	})
	initSubmit();
});
var showDefineTag = function(){
	$(".error").hide();
	$("#editQuestion-defineTag").show();
}
var checkTag = function(){
	var name = $("#editQuestion-defineTag-name").val();
	if(!name){
		$("#tag-error").html("请填写标签名").show();
		return false;
	}else{
		return true;
	}
}
var checkLogin = function(){
	var user_ID = 0;
	$.ajaxSetup({
		async:false
	})
	$.get("getUserID.php",function(ID){
		user_ID = ID;
	})
	var class_ID = ".userID"+user_ID; 
	if(user_ID > 0){
		$(class_ID).show();
		return true;
	}else{
		return false;
	}
}
var login = function(user_ID){
	$("#user-id").attr("value",user_ID);
	checkLogin();
}
var logout = function(){
	$("#user-id").attr("value","0");
	$(".requireLogin").hide();
}
var checkPoint = function(){
	$(".editQuestion-point").keydown(function(event){
		return (event.keyCode == 8) || ((event.keyCode >= 48) && (event.keyCode <= 57));
	})
}
var initSubmit = function(){
	$(".editQuestion-form").submit(function(){
		var title = $("#editQuestion-title").val();
		var point = $(".editQuestion-point").val();
		if(checkLogin()){
			var todayQuestions = 0;
			$.ajaxSetup({
				async:false
			})
			$.get("getTodayQuestions.php",function(data){
				todayQuestions = data;
			})
			if(todayQuestions > 0){
				var userPoint = 0;
				$.get("getUserPoint.php",function(data){
					userPoint = data;
				})
				if(Number(point) > Number(userPoint)){
					alert("积分不足!您有积分"+userPoint);
					return false;
				}
				if(!title){
					alert("给您的问题取个标题吧");
					return false;
				}
				$(".editQuestion-content").html(html);
				return true;
			}else{
				alert("您今天不能再提出问题了,快去赚取积分吧！");
				return false;
			}
			
		}else{
			$(".loginBox").fadeIn(400);
			return false;
		}
		
	})
}