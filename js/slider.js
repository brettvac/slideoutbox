jQuery(function() {
	jQuery(window).scroll(function(){
		/* when reaching the element with id "last" we want to show the slidebox. Let's get the distance from the top to the element */
		var distanceTop = jQuery('#last').offset().top - jQuery(window).height();
		
		if  (jQuery(window).scrollTop() > distanceTop)
			jQuery('#slidebox').animate({'right':'0px'},300);
		else 
			jQuery('#slidebox').stop(true).animate({'right':'-1200px'},100);	
	});
	
	/* remove the slidebox when clicking the cross */
	jQuery('#slidebox .close').bind('click',function(){
		jQuery(this).parent().remove();
	});
});