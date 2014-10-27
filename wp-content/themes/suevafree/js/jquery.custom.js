jQuery(document).ready(function(){
	jQuery('nav#mainmenu').mobileMenu();
});
		
jQuery(document).ready(function($){

jQuery('a.social').tipsy({fade:true, gravity:'s'});

jQuery('nav#mainmenu li').hover(
		function () {
			jQuery(this).children('ul').stop(true, true).fadeIn(100);
 
		}, 
		function () {
			jQuery(this).children('ul').stop(true, true).fadeOut(400);		
		}
		

);

jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
			// Parameters for PrettyPhoto styling
			animationSpeed:'fast',
			slideshow:5000,
			theme:'pp_default',
			show_title:false,
			overlay_gallery: false,
			social_tools: false
});

});          