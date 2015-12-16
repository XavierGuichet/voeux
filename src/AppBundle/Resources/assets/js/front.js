$(document).ready( function($) {
	$(".js-slide-label").click( function() {
		pos = $(this).parents('.reponse-item').index();
		$('#slider-bar li.slide-puce:eq('+pos+')').addClass("done");
		if(pos < ($('.reponse-item').length - 1)) {
			pos++;
			$(".reponse-item:lt("+pos+")").css("margin-left","-20%");		
		}
	});
	$(".js-slide-bar-btn").click( function() {
		pos = $(this).index();
		$(".reponse-item").css("margin-left","0");
		$(".reponse-item:lt("+pos+")").css("margin-left","-20%");	
		
	});
	
	$(".js-edit-form").click( function() {
		$(this).parents('.profil-form-block').find("input").removeAttr("readonly");
	});
	
});
