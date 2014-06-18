$(function(){
	initTab();
})
var initTab = function(){
	$(".tab").click(function(){
		$(".currentTab").removeClass("currentTab");
		$(this).addClass("currentTab");
		var showPanel = $(this).attr("linkPanel");
		$(".currentPanel").fadeOut(200,function(){
			$(this).removeClass("currentPanel");
			$(showPanel).fadeIn(200);
			$(showPanel).addClass("currentPanel");
		});
	});
}