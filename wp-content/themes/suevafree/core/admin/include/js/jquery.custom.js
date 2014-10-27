jQuery(document).ready(function($){ 

jQuery('.voobis_message').delay(1000).fadeOut(1000);

jQuery('.wip_mainbox').css({'display':'none'});
jQuery('.inactive').next('.wip_mainbox').css({'display':'block'});
		
jQuery('.wip_container h5.element').each(function(){	
		
	if(jQuery(this).next('.wip_mainbox').css('display')!='none') {	
		jQuery(this).next().append('<input type="hidden" name="element-opened" value="'+jQuery(this).attr('id')+'" />');
	}
				
});
		
jQuery('.wip_container h5.element').click(function(){	
		
	if(jQuery(this).next('.wip_mainbox').css('display')=='none') {	
	
		jQuery(this).addClass('inactive');
		jQuery(this).children('img').addClass('inactive');
		jQuery('input[name="element-opened"]').remove();	
		jQuery(this).next().append('<input type="hidden" name="element-opened" value="'+jQuery(this).attr('id')+'" />');
	}
					
	else {	
	
		jQuery(this).removeClass('inactive');
		jQuery(this).children('img').removeClass('inactive');
		jQuery(this).next('input[name="element-opened"]').remove();	
			
	}
					
	jQuery(this).next('.wip_mainbox').stop(true,false).slideToggle('slow');

});
		
function getSelectedTabIndex() { 
    return $tabs.tabs('option', 'selected');
}
		
});          