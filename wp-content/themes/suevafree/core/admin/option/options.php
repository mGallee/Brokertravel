<?php

require_once get_template_directory() . '/core/admin/option/default.php';

$panel = array (

/* =================== NAV =================== */

array( "name" => "Navigation",  
       "type" => "navigation",  
       "item" => array( "General" => __( "General","wip") , "Fonts" => __( "Fonts","wip") , "Colors" => __( "Colors","wip") , "Backgrounds" => __( "Backgrounds","wip")),   
       "start" => "<ul>", 
       "end" => "</ul>"),  
	   
/* =================== END NAV =================== */

/* =================== GENERAL TAB =================== */

array( "type" => "begintab",
	   "tab" => "General",
	   "element" =>
	   
/* START SKINS */ 

	array( "type" => "form",
	       "name" => "General"),

	array( "type" => "start",
	       "id" => "Skins",
	       "name" => __( "Skins","wip")),

	array( "name" => __( "Theme skin","wip"),
	       "desc" => __( "Select a skin, the options will be charged in accordance with the chosen style.","wip"),
	       "id" => $shortname."_skins",
	       "type" => "select",
	       "options" => array(
	   	   "Cyan" => __( "Cyan","wip"),
	   	   "Orange" => __( "Orange","wip"),
	   	   "Blue" => __( "Blue","wip"),
	   	   "Red" => __( "Red","wip"),
	   	   "Pink" => __( "Pink","wip"),
	   	   "Purple" => __( "Purple","wip"),
	   	   "Yellow" => __( "Yellow","wip"),
	   	   "Green" => __( "Green","wip"),
		   ),
	       "std" => ""),

	array( "type" => "save-button",
	       "value" => "Save",
	       "class" => "General"),

	array( "type" => "end"),

/* END SKINS */ 

/* START MAIN */ 

	array( "type" => "start",
	       "id" => "General",
	       "name" => __( "General","wip")),

	array( "name" => __( "Home Blog Layout","wip"),
	       "desc" => __( "If you don't select a single page, select a layout for homepage","wip"),
	       "id" => $shortname."_home",
	       "type" => "select",
	       "options" => array(
		   "full" => __( "Full Width","wip"),
	   	   "left-sidebar" => __( "Left Sidebar","wip"),
	   	   "right-sidebar" => __( "Right Sidebar","wip"),
		   ),
	       "std" => ""),

	array( "name" => __( "Category Layout","wip"),
	       "desc" => __( "Select a layout for category pages","wip"),
	       "id" => $shortname."_category_layout",
	       "type" => "select",
	       "options" => array(
		   "full" => __( "Full Width","wip"),
	   	   "left-sidebar" =>  __( "Left Sidebar","wip"),
	   	   "right-sidebar" => __( "Right Sidebar","wip"),
		   ),
	       "std" => ""),

	array( "name" => __( "Read more","wip"),
	       "desc" => __( "You want to display the read more button?","wip"),
	       "class" => "hidden",
	       "id" => $shortname."_view_readmore",
	       "type" => "on-off",
	       "std" => "on"),

	array( "name" => __( "Comments","wip"),
	       "desc" => __( "You want to view the comments after articles?","wip"),
	       "class" => "hidden",
	       "id" => $shortname."_view_comments",
	       "type" => "on-off",
	       "std" => "1"),
	
	array( "name" => __( "Custom css","wip"),
	       "desc" => __( "Insert your custom css code","wip"),
	       "id" => $shortname."_custom_css_code",
	       "type" => "textarea",
	       "std" => ""),

	array( "type" => "save-button",
	       "value" => "Save",
	       "class" => "General"),

	array( "type" => "end"),

/* END GENERAL */ 

/* START HEADER */ 

	array( "type" => "start",
	       "id" => "Header",
	       "name" => __( "Header","wip")),

	array( "name" => __( "Custom Logo","wip"),
	       "desc" => __( "Insert the url of your custom logo","wip"),
           "id" => $shortname."_custom_logo",     
           "data" => "array",
           "type" => "text",
	       "std" => ""),
		   
	array( "name" => __( "Custom Favicon","wip"),
	       "desc" => __( "Insert the url of your custom favicon","wip"),
           "id" => $shortname."_custom_favicon",     
           "data" => "array",
           "type" => "text",
	       "std" => ""),

	array( "type" => "save-button",
	       "value" => "Save",
	       "class" => "General"),

	array( "type" => "end"),

/* END HEADER */ 

/* START FOOTER */ 

	array( "type" => "start",
	       "id" => "Footer",
	       "name" => __( "Footer","wip")),

	array( "name" => __( "Copyright Text","wip"),
	       "desc" => __( "Insert copyright text","wip"),
	       "id" => $shortname."_copyright_text",
	       "type" => "textarea",
	       "std" => ""),
		   
	array( "name" => __( "Facebook Url","wip"),
	       "desc" => __( "Insert Facebook Url (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_facebook_button",
	       "type" => "text",
	       "std" => ""),
		   
	array( "name" => __( "Twitter Url","wip"),
	       "desc" => __( "Insert Twitter Url (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_twitter_button",
	       "type" => "text",
	       "std" => ""),

	array( "name" => __( "Twitter Url","wip"),
	       "desc" => __( "Insert Flickr Url (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_flickr_button",
	       "type" => "text",
	       "std" => ""),
	
	array( "name" => __( "Google Url","wip"),
	       "desc" => __( "Insert Google Url (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_google_button",
	       "type" => "text",
	       "std" => ""),

	array( "name" => __( "Linkedin Url","wip"),
	       "desc" => __( "Insert Linkedin Url (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_linkedin_button",
	       "type" => "text",
	       "std" => ""),

	array( "name" => __( "Myspace Url","wip"),
	       "desc" => __( "Insert Myspace Url (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_myspace_button",
	       "type" => "text",
	       "std" => ""),

	array( "name" => __( "Pinterest Url","wip"),
	       "desc" => __( "Insert Pinterest Url (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_pinterest_button",
	       "type" => "text",
	       "std" => ""),
		   
	array( "name" => __( "Tumblr Url","wip"),
	       "desc" => __( "Insert Tumblr Url (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_tumblr_button",
	       "type" => "text",
	       "std" => ""),

	array( "name" => __( "Youtube Url","wip"),
	       "desc" => __( "Insert Youtube Url (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_youtube_button",
	       "type" => "text",
	       "std" => ""),
		   
	array( "name" => __( "Youtube Vimeo","wip"),
	       "desc" => __( "Insert Vimeo Url (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_vimeo_button",
	       "type" => "text",
	       "std" => ""),

	array( "name" => __( "Skype Url","wip"),
	       "desc" => __( "Insert Skype Url (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_skype_button",
	       "type" => "text",
	       "std" => ""),

	array( "name" => __( "Email Address","wip"),
	       "desc" => __( "Insert Email Address (empty if you want to hide the button)","wip"),
	       "id" => $shortname."_footer_email_button",
	       "type" => "text",
	       "std" => ""),
		   
	array( "name" => __( "Feed Rss Button","wip"),
	       "desc" => __( "You want display the Feed Rss button?","wip"),
	       "class" => "hidden",
	       "id" => $shortname."_footer_rss_button",
	       "type" => "on-off",
	       "std" => "1"),
		   
	array( "type" => "save-button",
	       "value" => "Save",
	       "class" => "General"),

array( "type" => "end"),

/* END FOOTER */ 

),

array( "type" => "endtab"),
	   

/* =================== FONTS OPTION TAB =================== */

array( "type" => "begintab",
	   "tab" => "Fonts",
	   "element" =>
	   
/* START LOGO FONT */ 

	array( "type" => "form",
	       "name" => "Fonts"),

	array( "type" => "start",
	       "id" => "Fonts",
	       "name" => __( "Fonts","wip")),

	array( "name" => __( "Font size","wip"),
	       "desc" => __( "Select a size for logo","wip"),
	       "id" => $shortname."_logo_font_size",
	       "type" => "select",
			"options" => $fontsize,
	       "std" => ""),
		   
	array( "name" => __( "Description font size","wip"),
	       "desc" => __( "Select a size for logo description","wip"),
	       "id" => $shortname."_logo_description_font_size",
	       "type" => "select",
			"options" => $fontsize,
	       "std" => ""),

	array( "type" => "save-button",
	       "value" => "Save",
	       "class" => "Fonts"),

	array( "type" => "end"),

/* END LOGO FONT */ 

/* START MENU FONT */ 

	array( "type" => "start",
	       "id" => "Menu font",
	       "name" => __( "Menu font","wip")),

	array( "name" => __( "Menu size","wip"),
	       "desc" => __( "Select a size for menu","wip"),
	       "id" => $shortname."_menu_font_size",
	       "type" => "select",
			"options" => $fontsize,
	       "std" => ""),
		   
	array( "type" => "save-button",
	       "value" => "Save",
	       "class" => "Menu font"),

	array( "type" => "end"),

/* END MENU FONT */ 

/* START CONTENT FONT */ 

	array( "type" => "start",
	       "id" => "Contents font",
	       "name" => __( "Contents font","wip")),

	array( "name" => __( "Contents font size","wip"),
	       "desc" => __( "Select a size for the contents (articles and pages)","wip"),
	       "id" => $shortname."_content_font_size",
	       "type" => "select",
		   "options" => $fontsize,
	       "std" => "14px"),
		   
	array( "type" => "save-button",
	       "value" => "Save",
	       "class" => "Menu font"),

	array( "type" => "end"),

/* END CONTENT FONT */ 

/* START HEADLINE FONT SIZES */ 
	   
	array( "type" => "start",
	       "id" => "Headline font sizes",
	       "name" => __( "Headline font sizes","wip")),

	array( "name" => __( "H1 headline","wip"),
	       "desc" => __( "Select a size for H1 elements","wip"),
	       "id" => $shortname."_h1_font_size",
	       "type" => "select",
			"options" => $fontsize,
	       "std" => "26px"),

	array( "name" => __( "H2 headline","wip"),
	       "desc" => __( "Select a size for H2 elements","wip"),
	       "id" => $shortname."_h2_font_size",
	       "type" => "select",
			"options" => $fontsize,
	       "std" => "24px"),

	array( "name" => __( "H3 headline","wip"),
	       "desc" => __( "Select a size for H3 elements","wip"),
	       "id" => $shortname."_h3_font_size",
	       "type" => "select",
			"options" => $fontsize,
	       "std" => "21px"),
		   
	array( "name" => __( "H4 headline","wip"),
	       "desc" => __( "Select a size for H4 elements","wip"),
	       "id" => $shortname."_h4_font_size",
	       "type" => "select",
			"options" => $fontsize,
	       "std" => "16px"),
		   
	array( "name" => __( "H5 headline","wip"),
	       "desc" => __( "Select a size for H5 elements","wip"),
	       "id" => $shortname."_h5_font_size",
	       "type" => "select",
			"options" => $fontsize,
	       "std" => "14px"),
		   
	array( "name" => __( "H6 headline","wip"),
	       "desc" => __( "Select a size for H6 elements","wip"),
	       "id" => $shortname."_h6_font_size",
	       "type" => "select",
			"options" => $fontsize,
	       "std" => "12px"),
		   
	array( "type" => "save-button",
	       "value" => "Save",
	       "class" => "Headline font sizes"),

	array( "type" => "end"),

/* END FONT SIZES */ 

),

array( "type" => "endtab"),

/* =================== END FONTS OPTION TAB =================== */


/* =================== COLORS OPTION TAB =================== */

array( "type" => "begintab",
	   "tab" => "Colors",
	   "element" =>
	   
/* START TEXT COLOR */ 

	array( "type" => "form",
	       "name" => "Colors"),

	array( "type" => "startopen",
	       "name" => __( "Colors","wip")),

	array( "name" => __( "Text color","wip"),
	       "desc" => __( "Select a color for general text","wip"),
	       "id" => $shortname."_text_font_color",
	       "type" => "text",
	       "std" => "#616161"),

	array( "name" => __( "Copyright color","wip"),
	       "desc" => __( "Select a color for copyright text","wip"),
	       "id" => $shortname."_copyright_font_color",
	       "type" => "text",
	       "std" => "#fff"),

	array( "name" => __( "Link color","wip"),
	       "desc" => __( "Select a color for link","wip"),
	       "id" => $shortname."_link_color",
	       "type" => "text",
	       "std" => "#ff6644"),

	array( "name" => __( "Link color hover","wip"),
	       "desc" => __( "Select a color for link hover","wip"),
	       "id" => $shortname."_link_color_hover",
	       "type" => "text",
	       "std" => "#d14a2b"),

	array( "name" => __( "Border color","wip"),
	       "desc" => __( "Select a color for borders","wip"),
	       "id" => $shortname."_border_color",
	       "type" => "text",
	       "std" => "#ff6644"),

	array( "type" => "save-button",
	       "value" => "Save",
	       "class" => "General"),

	array( "type" => "end"),

/* END TEXT COLOR */ 

),

array( "type" => "endtab"),
	   
/* =================== END COLORS OPTION TAB =================== */
	   
/* =================== BEGIN BACKGROUNDS TAB =================== */

array( "type" => "begintab",
	   "tab" => "Backgrounds",
	   "element" =>
	   
/* START BACKGROUNDS */ 

	array( "type" => "form",
	       "name" => "Backgrounds"),
	   
/* START FOOTER BACKGROUNDS */ 

	array( "type" => "start",
	       "id" => "Footer Background",
	       "name" => __( "Footer Background","wip")),

	array( "name" => __( "Color","wip"),
	       "desc" => __( "Select a color for footer background.","wip"),
	       "id" => $shortname."_footer_background_color",
	       "type" => "text",
	       "std" => ""),
	   
	array( "name" => __( "Default image background","wip"),
	       "desc" => __( "Select a image for footer background.","wip"),
	       "id" => $shortname."_footer_background",
	       "type" => "select",
	       "options" => $backgrounds,
	       "std" => ""),
	   
	array( "name" => __( "Repeat","wip"),
	       "desc" => __( "Repeat","wip"),
	       "id" => $shortname."_footer_background_repeat",
	       "type" => "select",
	       "options" => array(
	   	   		"repeat" => __( "Repeat","wip"),
				"no-repeat" => __( "No repeat","wip"),
	   			"repeat-x" => __( "Repeat orizzontal","wip"),
				"repeat-y" => __( "Repeat vertical","wip"),
		    ),
	       "std" => ""),
	   
	array( "name" => __( "Background Position","wip"),
	       "desc" => __( "Background Position","wip"),
	       "id" => $shortname."_footer_background_position",
	       "type" => "select",
	       "options" => array(
	   			"" => "None",
	   			"top left" => "top left",
				"top center" => "top center",
	   			"top right" => "top right",
				"center" => "center",
	   			"bottom left" => "bottom left",
				"bottom center" => "bottom center",
				"bottom right" => "bottom right",
		    ),
	       "std" => ""),
		   
	array( "name" => __( "Background Attachment","wip"),
	       "desc" => __( "Background Attachment","wip"),
	       "id" => $shortname."_footer_background_attachment",
	       "type" => "select",
	       "options" => array(
	   			"normal" => "normal",
				"fixed" => "fixed",
		    ),
	       "std" => ""),
	   
	array( "type" => "save-button",
	       "value" => "Save",
	       "class" => "Footer Background"),

	array( "type" => "end"),

/* END PAGE BACKGROUNDS */ 

),

array( "type" => "endtab"),
	   
/* END PAGE BACKGROUNDS */ 
	   
/* =================== END BACKGROUNDS TAB =================== */


array( "type" => "endpanel"),  

);

require_once get_template_directory() . '/core/admin/panel.php';

thepane( $panel ); 

?>