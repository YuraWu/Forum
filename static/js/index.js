var login = function(user_ID){

};
var logout = function(){

}
var initTab = function(){
	$(".tab").click(function(){
		$(".showpanel").scrollTop(0);
		$(".showpanel").perfectScrollbar('update');
		$(".currentTab").removeClass("currentTab");
		$(this).addClass("currentTab");
		var showPanel = $(this).attr("linkPanel");
		$(".currentList").fadeOut(100,function(){
			$(this).removeClass("currentList");
			$(showPanel).fadeIn(100);
			$(showPanel).addClass("currentList");
		});
	});
}
var initLoginSubmit = function(){
	$(".loginForm").submit(function(){
		var username = $("#login-username").val();
		var password = $("#login-password").val();
		if(!username){
			$("#login-username").attr("class","error-input");
			$("#login-username-error").html("用户名为空<div class='error-arrow'></div>").fadeIn(200);
			return false;
		}
		if(!password){
			$("#login-password").attr("class","error-input");
			$("#login-password-error").html("密码为空<div class='error-arrow'></div>").fadeIn(200);
			return false;
		}
		var info = "";
		$.ajaxSetup({
			async:false
		})
		$.post("login.php",{"username":username,"password":password},function(data){
			info = data;
		})
		if(info == "hasUser"){
			alert("您已登录");
			return false;
		}
		if(info == "usernameUnexited"){
			$("#login-username").attr("class","error-input");
			$("#login-username-error").html("用户名不存在<div class='error-arrow'></div>").fadeIn(200);
			return false;
		}
		if(info == "passwordError"){
			$("#login-password").attr("class","error-input");
			$("#login-password-error").html("密码错误<div class='error-arrow'></div>").fadeIn(200);
			return false;
		}
		return true;
	});
	$(".login-username").focus(function(){
		$("#login-username-error").fadeOut(200);
	});
	$(".login-password").focus(function(){
		$("#login-password-error").fadeOut(200);
	});
}
var checkUsername = function(){
	var username = $("#register-username").val();
	if(username){
		var exited = false;
		$.ajaxSetup({
			async:false
		})
		$.get("checkUsername.php",{name:username},function(data){
			exited = data;
		});
		if(exited){
			$("#register-username").attr("class","error-input");
			$("#register-username-error").html("用户名已存在<div class='error-arrow'></div>").fadeIn(200);
			return false;
		}else{
			$("#register-username").attr("class","success-input");
			$("#register-username-error").fadeOut(200);
			return true;
		}
	}else{
		$("#register-username").attr("class","error-input");
		$("#register-username-error").html("用户名为空<div class='error-arrow'></div>").fadeIn(200);
		return false;
	}
};
var checkRepassword = function(){
	if($("#register-repassword").val()){
		if(!$("#register-password").val()){
			$("#register-password").attr("class","error-input");
			$("#register-password-error").html("密码为空<div class='error-arrow'></div>").fadeIn(200);
			return false;
		}else{
			if($("#register-password").val()!=$("#register-repassword").val()){
				$("#register-repassword").attr("class","error-input");
				$("#register-repassword-error").html("两次密码不一致<div class='error-arrow'></div>").fadeIn(200);
				return false;
			}else{
				$("#register-password").attr("class","success-input");
				$("#register-repassword-error").fadeOut(200);
				$("#register-repassword").attr("class","success-input");
				$("#register-repassword-error").fadeOut(200);
				return true;
			}
		}
	}else{
		if($("#register-password").val()){
			$("#register-repassword").attr("class","error-input");
			$("#register-repassword-error").html("重复密码为空<div class='error-arrow'></div>").fadeIn(200);
			$("#register-password").attr("class","inactive-input");
			$("#register-password-error").fadeOut(200);
			return false;
		}else{
			$("#register-password").attr("class","inactive-input");
			$("#register-password-error").fadeOut(200);
			$("#register-repassword").attr("class","inactive-input");
			$("#register-repassword-error").fadeOut(200);
			return false;
		}
	}
};
var checkPassword = function(){
	if($("#register-password").val()){
		if($("#register-repassword").val()){
			if($("#register-password").val()!=$("#register-repassword").val()){
				$("#register-repassword").attr("class","error-input");
				$("#register-repassword-error").html("两次密码不一致<div class='error-arrow'></div>").fadeIn(200);
				return false;
			}else{
				$("#register-password").attr("class","success-input");
				$("#register-password-error").fadeOut(200);
				$("#register-repassword").attr("class","success-input");
				$("#register-repassword-error").fadeOut(200);
				return true;
			}
		}else{
			$("#register-password").attr("class","success-input");
			$("#register-password-error").fadeOut(200);
			return true;
		}
	}else{
		if($("#register-repassword").val()){
			$("#register-password").attr("class","error-input");
			$("#register-password-error").html("密码为空<div class='error-arrow'></div>").fadeIn(200);
			$("#register-repassword").attr("class","inactive-input");
			$("#register-repassword-error").fadeOut(200);
			return false;
		}else{
			$("#register-password").attr("class","inactive-input");
			$("#register-password-error").fadeOut(200);
			$("#register-repassword").attr("class","inactive-input");
			$("#register-repassword-error").fadeOut(200);
			return false;
		}
		
	}
};
var initErrorHide = function(){
	$(".error").click(function(){
		$(this).fadeOut(400);
		$(this).parent().find("input").attr("class","inactive-input");
	})
}
var hideError = function(){
	$(this).attr("class","inactive-input");
	var id = "#" + $(this).attr("id") + "-error";
	$(id).fadeOut(200);
}
var initRegister = function(){
	$("#register-username").blur(checkUsername).focus(hideError);
	$("#register-repassword").blur(checkRepassword).focus(hideError);
	$("#register-password").blur(checkPassword).focus(hideError);	
	$(".registerForm").submit(function(){
		if(checkUsername() && checkPassword() && checkRepassword()){
			return true;
		}else{
			return false;
		}
	})
}
$(function(){
	initTab();
	initLoginSubmit();
	initRegister();
	initErrorHide();
})