(function($){
$.fn.exportMembers = function(){
    
//===============================================================
// GLOBAL VARS
//===============================================================

var _base = this;
var _self = $(this);

$("#dd_all_members").click(function(){
	if( $(this).is(":checked") ){
		$("input[name='members[]']").attr("checked",true);
	} else {	
		$("input[name='members[]']").attr("checked",false);
	}
});

$("#dd_all_fields").click(function(){
	if( $(this).is(":checked") ){
		$("input[name='fields[]']").attr("checked",true);
	} else {	
		$("input[name='fields[]']").attr("checked",false);
	}
});

$("#dd_all_customs").click(function(){
	if( $(this).is(":checked") ){
		$("input[name='customs[]']").attr("checked",true);
	} else {	
		$("input[name='customs[]']").attr("checked",false);
	}
});

this.init = function(){
    return _base;
}

//===============================================================
// PRIVATE METHODS
//===============================================================



//===============================================================
// INIT PLUGIN
//===============================================================

return this.init();
};
})(jQuery);

$("#dd_cpanel").exportMembers();