<?php

function suevafree_add_menu() {
	global $suevafree_themename, $suevafree_adminmenuname,$suevafree_optionfile;
	
	add_theme_page("Theme Options", "Theme Options", 'administrator',  'themeoption', 'suevafree_themeoption');
	add_theme_page("Get Premium", "Get Premium", 'administrator',  'getpremium', 'suevafree_getpremium');
}

add_action('admin_menu', 'suevafree_add_menu'); 

function suevafree_add_script() {
	
	 global $wp_version;
     wp_enqueue_style( "thickbox" );
     add_thickbox();

	 $file_dir = get_template_directory_uri()."/core/admin/include";
	 
	 wp_enqueue_script( 'jquery.custom', $file_dir.'/js/jquery.custom.js',array('jquery','media-upload','thickbox'),'1.0',true ); 
	 wp_enqueue_script( 'wip_on_off', $file_dir.'/js/wip_on_off.js','3.5', true); 
	 wp_enqueue_style ( 'custom.style', $file_dir.'/css/custom.style.css' ); 
	 wp_enqueue_style ( 'wip_on_off', $file_dir.'/css/wip_on_off.css' );
}

add_action('admin_init', 'suevafree_add_script');

function suevafree_save_option ( $panel ) {
	
	global $suevafree_message_action;
	
	$suevafree_setting = get_option( suevafree_themename() );
	
	if ( $suevafree_setting != false ) 
						
		{
			$suevafree_setting = maybe_unserialize( $suevafree_setting );
		} 
						
	else 
						
		{
			$suevafree_setting = array();
		}      
		
	if ( "Save" == suevafree_request('action') )

	{
				

		foreach ($panel as $element ) {
			
			if ( ( isset($element['tab']) )  && ( $element['tab'] == $_GET['tab'] ) ){
					
				foreach ($element as $value )
		
					{
		
						if ( $_REQUEST['element-opened'] == "Skins" )
		
							{
								require_once get_template_directory() . '/core/admin/option/skins.php';
								update_option( suevafree_themename(), array_merge( $suevafree_setting  ,$current) );
								break;
							} 
						
						else if ( ( isset( $value['id']) ) && ( isset( $_POST[$value["id"]] ) ) ) 	
			
							{	
								if ( $value["id"] == "suevafree_copyright_text"):
									$current[$value["id"]] = $_REQUEST[$value["id"]];
								else:
									$current[$value["id"]] = sanitize_text_field( $_REQUEST[$value["id"]] );
								endif; 
								
								update_option( suevafree_themename(), array_merge( $suevafree_setting  ,$current) );
							}
							
								
							
						$suevafree_message_action = 'Options saved successfully.';
					
					}
				
				}
		
			}
		}
}

function suevafree_message () {
		global $suevafree_message_action;
		if (isset($suevafree_message_action))
		echo '<div id="message" class="updated fade message_save voobis_message"><p><strong>'.$suevafree_message_action.'</strong></p></div>';
	}


function suevafree_themeoption() {

		$suevafree_themename = "Sueva";
		$shortname = "suevafree";
		require_once get_template_directory() . '/core/admin/option/options.php';   

	}

function suevafree_getpremium() {	?>

	<a href="http://www.themeinprogress.com/sueva/?ref=panel" target="_blank" >
    	<img src="http://www.themeinprogress.com/images/suevapremium.jpg" alt="Get Premium" style="margin:15px auto" />
    </a>

<?php } ?>