
jQuery(function(j$) {
	
j$('.bxslider').bxSlider({
	mode: vMode,
	useCSS: false,
	easing: vEffect,
	speed: vSlide,
	auto: true,
	pager: false,
	adaptiveHeight: true,
	onSliderLoad: function(){
		j$('.flex-container').addClass('active');		
	},
	onSlideAfter: function(){
		j$('.flex-container').addClass('active');			
	},
	onSlideBefore:function(){
		j$('.flex-container').removeClass('active');
	}
});

});