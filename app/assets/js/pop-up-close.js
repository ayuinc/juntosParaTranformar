$(document).ready(function(){
	$("#pop-up").find("img").on("click", function(){
		$("#pop-up").fadeOut(200);
		setTimeout(function(){
			$("#pop-up").addClass("sr-only");
		}, 200);
	});
});

$(document).mouseup(function (e){
  var container = $(".pop-up__container");
  if (!container.is(e.target) && container.has(e.target).length === 0) {
    $("#pop-up").fadeOut(200);
		setTimeout(function(){
			$("#pop-up").addClass("sr-only");
		}, 200);
  }
});