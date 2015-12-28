$(document).ready( function($) {
	$(".js-slide-label").click( function() {
		pos = $(this).parents('.reponse-item').index();
		$('#slider-bar li.slide-puce:eq('+pos+')').addClass("done");
		if(pos < ($('.reponse-item').length - 1)) {
			pos++;
			$(".reponse-item:lt("+pos+")").css("margin-left","-20%");
		}
		else {
			$('html, body').animate({
				scrollTop:$("#profil").offset().top
			}, 'slow');
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

  $('#reponses_save').click(function(e) {
    e.preventDefault();
    var sendForm = true;
    if($('input[type=radio]:checked').length != 5) {
      $('.reponse-item').each(function() {
        if($(this).find("input[type=radio]:checked").length != 1) {
          sendForm = false;
          pos = $(this).index();
    			$(".reponse-item:eq("+pos+")").css("margin-left","0");
    			$(".reponse-item:gt("+pos+")").css("margin-left","0");
          $('html, body').animate({
    				scrollTop:$(".reponse-block").offset().top
    			}, 'slow');
          return false;
        }
      });
    }

    if (sendForm) {
        $('form').submit();
    }
});
});
