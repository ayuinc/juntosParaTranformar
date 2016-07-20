$(document).ready(function(){
	$("#pop-up").find("img").on("click", function(){
		$("#pop-up").fadeOut(200);
		setTimeout(function(){
			$("#pop-up").addClass("sr-only");
		}, 200);
	});
});