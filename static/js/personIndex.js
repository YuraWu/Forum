var checkLogin = function(){
	var user_ID = getUserID();
	if(user_ID > 0){
		$("[userID="+user_ID+"]").show();
		return true;
	}else{
		return false;
	}
};
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
};
var logout = function(){
	$(".requireLogin").hide();
};
var initTab = function(){
	$(".tab").click(function(){
		$(".currentTab").removeClass("currentTab");
		$(this).addClass("currentTab");
		var showPanel = $(this).attr("linkPanel");
		$(".currentPanel").fadeOut(100,function(){
			$(this).removeClass("currentPanel");
			$(showPanel).fadeIn(100);
			$(showPanel).addClass("currentPanel");
		});
	});
}			
function readFile(){
	var file = this.files[0];
	if(!/image\/\w+/.test(file.type)){
		alert("请确保文件为图像类型");
		return false;
	}
	var reader = new FileReader();
	reader.readAsDataURL(file);
	reader.onload = function(e){
		$(".uploadPortrait-preview").attr("src",this.result);
	}
}

var initUploadPortrait = function(){
	$(".selectPortrait").click(function(){
		$(".uploadPortrait").fadeIn(400);
	})
	$(".uploadPortrait-select").click(function(){
		$(".uploadPortrait-source").click();
	})
	$(".uploadPortrait-source").change(readFile);
	$(".uploadPortrait-close").click(function(){
		$(".uploadPortrait").fadeOut(400);
	})
	$(".uploadPortrait-form").submit(function(){
		if($(".uploadPortrait-source").val()){
			return true;
		}else{
			alert("请选择图片");
			$(".uploadPortrait-source").click();
			return false;
		}
	})
}
var saveInfo = function(sex,birthday,constellation,realname,email,telephone,address,profession,workplace){
	$("#sex").attr("value",sex);
	$("#birthday").attr("value",birthday);
	$("#constellation").attr("value",constellation);
	$("#realname").attr("value",realname);
	$("#email").attr("value",email);
	$("#telephone").attr("value",telephone);
	$("#address").attr("value",address);
	$("#profession").attr("value",profession);
	$("#workplace").attr("value",workplace);
}
var refreshInfo = function(){
	$("#sex").val($("#sex").attr("value"));
	$("#birthday").val($("#birthday").attr("value"));
	$("#constellation").val($("#constellation").attr("value"));
	$("#realname").val($("#realname").attr("value"));
	$("#email").val($("#email").attr("value"));
	$("#telephone").val($("#telephone").attr("value"));
	$("#address").val($("#address").attr("value"));
	$("#profession").val($("#profession").attr("value"));
	$("#workplace").val($("#workplace").attr("value"));
	$(".error").hide();
}
var initEditable = function(){
	$(".input-editable").unbind();
	$(".input-unEditable").unbind().focus(function(){$(this).blur()});
}
var initEditInfo = function(){
	$("#editInfo").unbind().click(function(){
		var user_ID = getUserID();
		if(user_ID > 0){
			var person_ID = getUrlParam("ID");
			if(user_ID == person_ID){
				var sex = $("#sex").val();
				var birthday = $("#birthday").val();
				var constellation = $("#constellation").val();
				var realname = $("#realname").val();
				var email = $("#email").val();
				var telephone = $("#telephone").val();
				var address = $("#address").val();
				var profession = $("#profession").val();
				var workplace = $("#workplace").val();
				$(".input-unEditable").attr("class","input-editable");
				$(this).hide();
				$("#giveUpEditInfo").show();
				initEditable();
			}else{
				alert("不要调皮...你没有权限");
			}
		}else{
			$(".loginBox").fadeIn(400);
		}
	})
	$("#giveUpEditInfo").unbind().click(function(){
		var user_ID = getUserID();
		if(user_ID > 0){
			var person_ID = getUrlParam("ID");
			if(user_ID == person_ID){
				refreshInfo();
				$(".input-editable").attr("class","input-unEditable");
				$("#editInfo").show();
				$(this).hide();
				initEditable();
			}else{
				alert("不要调皮...你没有权限");
			}
		}else{
			$(".loginBox").fadeIn(400);
		}
	})
};
var initSaveInfo = function(){
	$("#saveInfo").unbind().click(function(){
		var user_ID = getUserID();
		if(user_ID > 0){
			var person_ID = getUrlParam("ID");
			if(user_ID == person_ID){
				if(checkRealname() && checkSex() && checkBirthday() && checkEmail() && checkTelephone()){
					var person_ID = getUrlParam('ID');
					var sex = $("#sex").val();
					var birthday = $("#birthday").val();
					var constellation = $("#constellation").val();
					var realname = $("#realname").val();
					var email = $("#email").val();
					var telephone = $("#telephone").val();
					var address = $("#address").val();
					var profession = $("#profession").val();
					var workplace = $("#workplace").val();
					$.post("saveUserInfo.php",{"person_ID":person_ID,"sex":sex,"birthday":birthday,"constellation":constellation,"realname":realname,"email":email,"telephone":telephone,"address":address,"profession":profession,"workplace":workplace},function(data){
						if(data=="noUser"){
							alert("请登录");
						}
						else if(data=="noPower"){
							alert("没有权限");
						}else{
							saveInfo(sex,birthday,constellation,realname,email,telephone,address,profession,workplace);
							$("#giveUpEditInfo").click();
						}
					});
				}
			}else{
				alert("不要调皮...你没有权限");
			}
		}else{
			$(".loginBox").fadeIn(400);
		}
		
	});
};
var checkSex = function(){
	var sex = $("#sex").val();
	if(sex=="男" || sex=="女" || sex=="man" || sex=="woman" || sex=="male" || sex=="female" || !sex){
		$("#sex-error").hide();
		return true;
	}else{
		$("#sex-error").html("男/女,man/woman,male/female").show();
		return false;
	}
}
var checkBirthday = function(){
	var birthday = $("#birthday").val();
	if(birthday.match(/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|2[0-9]|3[0-1])$/) || !email){
		$("#birthday-error").hide();
		return true;
	}else{
		$("#birthday-error").html("格式错误,xxxx-xx-xx").show();
		return false;
	}
}
var checkRealname = function(){
	var realname = $("#register-realname").val();
	if(realname.match(/^[A-Za-z\u4e00-\u9fa5]+$/) || !realname){
		$("#realname-error").hide();
		return true;
	}else {
		$("#realname-error").html("你这坑爹名字谁取的").show();
		return false;
	}
}
var checkEmail = function(){
	var email = $("#email").val();
	if(email.match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) || !email){
		$("#email-error").hide();
		return true;
	}else {
		$("#email-error").html("邮箱格式错误").show();
		return false;
	}
};
var checkTelephone = function(){
	var telephone = $("#telephone").val();
	if(telephone.match(/^1[3|4|5|8][0-9]\d{4,8}$/) || !telephone){
		$("#telephone-error").hide();
		return true;
	}else {
		$("#telephone-error").html("手机号格式错误").show();
		return false;
	}
};
var initDeleteQuestion = function(){
	$(".question-delete").unbind().click(function(){
		var user_ID = getUserID();
		if(user_ID > 0){
			var person_ID = getUrlParam("ID");
			if(user_ID == person_ID){
				var question_ID = $(this).parent().find(".question-ID").val();
				var question_field = $(this).parent().parent();
				if(confirm("删除问题将删除所有回答和评论，并扣除10点积分，是否继续?")){
					$.post("deleteQuestion.php",{"ID":question_ID},function(data){
						if(data == "deleteSuccess"){
							question_field.remove();
							//积分变化
							var point = (Number)($(".personIndex-headPanel-info-point").html().split(" ")[1]) - 10;
							$(".personIndex-headPanel-info-point").html("积分: "+point);
						}else if(data == "noPoint"){
							alert("您的积分不足");
						}else if(data == "noPower"){
							alert("这不是你提出的问题");
						}else if(data == "noQuestion"){
							alert("该问题不存在");
						}
					})
				}
			}else{
				alert("不要调皮...你没有权限");
			}
		}else{
			$(".loginBox").fadeIn(400);
		}
		
	});
}
var initSubmitMessage = function(){
	$("#message-submit").click(function(){
		var user_ID = getUserID();
		var content = $("#message-content").val();
		if(user_ID > 0){
			if(content){
				var person_ID = getUrlParam("ID");
				$.post("saveMessage.php",{person_ID:person_ID,content:content},function(data){
					if(data=="noUser"){
						alert("请登录");
					}else{
						$(".personIndex-messageBoard-messageList").html(data);
						$("#message-content").val("");
						checkLogin();
						initDeleteMessage();
					}
				})
			}else{
				alert("没有留言内容");
			}
		}else{
			$(".loginBox").fadeIn(400);
		}
	})
}
var initDeleteMessage = function(){
	$(".message-delete").unbind().click(function(){
		var message_ID = $(this).parent().find(".message-ID").val();
		var user_ID = getUserID();
		if(user_ID > 0){
			var person_ID = getUrlParam("ID");
			if(user_ID == person_ID){
				$.post("deleteMessage.php",{message_ID:message_ID,person_ID:person_ID},function(data){
					if(data=="noUser"){
						alert("请登录");
					}else if(data=="noPower"){
						alert("没有权限");
					}
					else if(data=="noMessageOfPerson"){
						alert("用户留言错误")
					}
					else if(data=="invalidID"){
						alert("无效的ID");
					}
					$(".personIndex-messageBoard-messageList").html(data);
					checkLogin();
					initDeleteMessage();
				})
			}else{
				alert("不要调皮...你没有权限");
			}
		}else{
			$(".loginBox").fadeIn(400);
		}
	})
}
$(function(){
	checkLogin();
	initUploadPortrait();//上传头像
	initEditable();//输入框不可编辑
	initEditInfo();//编辑信息
	initSaveInfo();//保存信息
	initTab();//切换
	initDeleteQuestion();//删除问题
	initSubmitMessage();//留言
	initDeleteMessage();
	ajaxLogin();
	ajaxLogout();
})
