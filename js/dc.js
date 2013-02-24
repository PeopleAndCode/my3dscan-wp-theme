$(document).ready(function() {
	
	$('.iosSlider').iosSlider({
		autoSlide: true,
		snapToChildren: true,
		desktopClickDrag: true,
		keyboardControls: true,
		onSliderLoaded: sliderTest,
		onSlideStart: sliderTest,
		onSlideComplete: slideComplete,
		navNextSelector: $('.next'),
	    navPrevSelector: $('.prev'),
	});
	
	//CALCUATE
	$("#industry a").click(function(){
		var messageItem = $(this).attr("id");

		if(!$("#m" + messageItem).hasClass("active")){
			$(".message-item").removeClass("active").delay(200);
			$("#m" + messageItem).addClass("active");
			
			$("#industry a").removeClass("active");
			$(this).addClass("active");
		}
		return false;
	});

	//FORM VALIDATION
	$('.error').hide(); 
	
	$('#fname').focus(function() {
		$('.nameError').fadeOut(700);
	}); 
	
	$('#femail').focus(function() {
		$('.emailError').fadeOut(700);
	});
	
	$('#fphone').focus(function() {
		$('.phoneError').fadeOut(700);
	});
		
	$("#fsend").click(function() {  
		$('.error').hide();
		
		var fname = $('#fname').val();
		var femail = $('#femail').val();
		var fphone = $('#fphone').val();

		var findustry = $('#findustry').val();
		var finterest = $('#finterest').val();

		var fdescribe = $('#fdescribe').val();
		
		if (fname == "" || femail == "" || fphone == "") {
			if(fname=="") {
				$('.nameError').fadeIn(1000);
				//$('#fname').focus();
			}
			
			if(femail=="") {
				$('.emailError').fadeIn(1000);
				//$('#femail').focus();
			}
			
			if(fphone=="") {
				$('.phoneError').fadeIn(1000);
				//$('#fphone').focus();
			}
			
			return false;
		}
		
		var dataString = 'fname='+ fname + '&femail=' + femail + '&fphone=' + fphone + '&findustry=' + findustry + '&finterest=' + finterest + '&fdescribe=' + fdescribe;  
 
		$.ajax({  
		  type: "POST",  
		  url: "/submit.php",  
		  data: dataString,  
		  success: function(html) { 
			$('#contactForm').html("<div id='message'></div>");  
			$('#message').html('<div class="update success">Thanks! we will be in touch very soon.</div>')
			.hide()  
			.fadeIn(1500);
		  }  
		});  
		return false;
  	});


});

function sliderTest(args) {
	try {
		console.log(args);
	} catch(err) {
	}
}

function slideComplete(args) {

	$('.next, .prev').removeClass('unselectable');
	
    if(args.currentSlideNumber == 1) {

        $('.prev').addClass('unselectable');

    } else if(args.currentSliderOffset == args.data.sliderMax) {

        $('.next').addClass('unselectable');

    }

}