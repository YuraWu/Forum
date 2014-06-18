$(function(){
	$("#user-info").mouseenter(function(){
		$("#user-menu").stop(true).slideToggle(300);
	}).mouseleave(function(){
		$("#user-menu").stop(true).slideToggle(300);
	});
});
var ajaxLogin = function(){
	$(".header-login").click(function(){
		$(".loginBox").fadeIn(400);
		return false;
	});
	$(".loginBox-close").click(function(){
		hideAllError();
		$("#loginBox-username").attr("value","");
		$("#loginBox-password").attr("value","");
		$(".loginBox").fadeOut(400);
	});
	$(".loginBox-submit").click(function(){
		var username = $("#loginBox-username").val();
		var password = $("#loginBox-password").val();
		if(!username){
			$("#loginBox-username-error").html("用户名为空").fadeIn(200);
			$("#loginBox-username").focus(function(){
				$("#loginBox-username-error").fadeOut(200);
			});
			return false;
		}
		if(!password){
			$("#loginBox-password-error").html("密码为空").fadeIn(200);
			$("#loginBox-password").focus(function(){
				$("#loginBox-password-error").fadeOut(200);
			});
			return false;
		}
		$.getJSON("ajaxLogin.php",{"username":username,"password":password},function(json){
			var data = "";
			var ID = "";
			$.each(json,function(i,item){
				if(i == 0){
					data = item;
				}else{
					ID = item;
				}
			});
			if(data == "usernameUnexited"){
				$("#loginBox-username-error").html("用户名不存在").fadeIn(200);
				$("#loginBox-username").focus(function(){
					$("#loginBox-username-error").fadeOut(200);
				});
			}else if(data == "passwordError"){
				$("#loginBox-password-error").html("密码错误").fadeIn(200);
				$("#loginBox-password").focus(function(){
				$("#loginBox-password-error").fadeOut(200);
			});
			}else{
				$("#user-info").html(data);
				$("#loginBox-username").attr("value","");
				$("#loginBox-password").attr("value","");
				$(".loginBox").hide();
				login(ID);
				ajaxLogout();
			}
		});	
	});
}
var ajaxLogout = function(){
	$("#logout").click(function(){
		$("#user-info").html("<a class='header-login' href='index.php?action=account'> 登录 </a><a href='index.php?action=account'> 注册 </a>");
		$.post("ajaxLogout.php");
		logout();
		ajaxLogin();
		return false;
	});
}

var hideAllError = function(){
	$(".loginBox-error").hide();
}
function getUrlParam(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r!=null) return unescape(r[2]); return null; //返回参数值
}