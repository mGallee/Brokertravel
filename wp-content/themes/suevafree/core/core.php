<?php

/*-----------------------------------------------------------------------------------*/
/* Admin class */
/*-----------------------------------------------------------------------------------*/   

function suevafree_admin_body_class( $classes ) {
	
	global $wp_version;
	
	if ( ( $wp_version >= 3.8 ) && ( is_admin()) ) {
		$classes .= 'wp-8';
	}
		return $classes;
}
	
add_filter( 'admin_body_class', 'suevafree_admin_body_class' );

/*-----------------------------------------------------------------------------------*/
/* Post formats */
/*-----------------------------------------------------------------------------------*/   

function suevafree_setup() {

	add_theme_support( 'post-formats', array( 'aside','gallery','quote','video','audio','link' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	
	add_image_size( 'blog', 940,429, TRUE ); 
	add_image_size( 'large', 449,304, TRUE ); 
	add_image_size( 'medium', 290,220, TRUE ); 
	add_image_size( 'small', 211,150, TRUE ); 

	register_nav_menu( 'main-menu', 'Main menu' );

	add_theme_support( 'custom-background', array(
		'default-color' => 'f3f3f3',
		'default-image' => get_template_directory_uri() . suevafree_setting('suevafree_body_background'),
	) );

}

add_action( 'after_setup_theme', 'suevafree_setup' );

/*-----------------------------------------------------------------------------------*/
/* Tag Title */
/*-----------------------------------------------------------------------------------*/  
 
function suevafree_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}

add_filter( 'wp_title', 'suevafree_title', 10, 2 );

/*-----------------------------------------------------------------------------------*/
/* Theme name */
/*-----------------------------------------------------------------------------------*/ 

function suevafree_themename() {
	
	$suevafree_themename = "suevafree_theme_settings";
	return $suevafree_themename;	
	
}

/*-----------------------------------------------------------------------------------*/
/* Theme settings */
/*-----------------------------------------------------------------------------------*/ 

function suevafree_setting($id) {

	$suevafree_setting = get_option(suevafree_themename());
	if(isset($suevafree_setting[$id]))
		return $suevafree_setting[$id];

}

/*-----------------------------------------------------------------------------------*/
/* Post meta */
/*-----------------------------------------------------------------------------------*/ 

function suevafree_postmeta($id) {

	global $post;
	
	$val = get_post_meta( $post->ID , $id, TRUE);
	if(isset($val))
		return $val;

}

/*-----------------------------------------------------------------------------------*/
/* Content template */
/*-----------------------------------------------------------------------------------*/ 

function suevafree_template($id) {

	$template = array ("full" => "span12" , "left-sidebar" => "span8" , "right-sidebar" => "span8" );

	$span = $template["full"];
	$sidebar =  "full";

	if ( ( suevafree_setting('suevafree_home') )  && (  (is_home()) )  ){
		
		$span = $template[suevafree_setting('suevafree_home')];
		$sidebar =  suevafree_setting('suevafree_home');

	} else if ( ( suevafree_setting('suevafree_category_layout') )  && ( (is_category()) || (is_tag()) )  ){
		
		$span = $template[suevafree_setting('suevafree_category_layout')];
		$sidebar =  suevafree_setting('suevafree_category_layout');

	} else if ( ( suevafree_postmeta('suevafree_template') )  && ( (is_page()) || (is_single())  )  ){

		$span = $template[suevafree_postmeta('suevafree_template')];
		$sidebar =  suevafree_postmeta('suevafree_template');
			
	}
	
	return ${$id};
	
}

/*-----------------------------------------------------------------------------------*/
/* Excerpt */
/*-----------------------------------------------------------------------------------*/ 

function suevafree_hide_excerpt_more() {
	return '';
}

add_filter('the_content_more_link', 'suevafree_hide_excerpt_more');
add_filter('excerpt_more', 'suevafree_hide_excerpt_more');

function suevafree_excerpt() {
	
	global $post,$more;
	
	$more = 0;

	
	if ($pos=strpos($post->post_content, '<!--more-->')): 
		$content = the_content();
	else:
		$content = the_excerpt();
	endif;
	
	echo '<p>' . $content . ' <a class="button" href="'.get_permalink($post->ID).'" title="More">  ' . __( "Read More","wip") . '</a> </p>';

}

/*-----------------------------------------------------------------------------------*/
/* Request */
/*-----------------------------------------------------------------------------------*/ 

function suevafree_request($id) {
	
	if ( isset ( $_REQUEST[$id])) 
	return $_REQUEST[$id];	
	
}

/*-----------------------------------------------------------------------------------*/
/* Content width */
/*-----------------------------------------------------------------------------------*/ 

if ( ! isset( $content_width ) )
	$content_width = 940;

/*-----------------------------------------------------------------------------------*/
/* SCRIPTS */
/*-----------------------------------------------------------------------------------*/ 

function suevafree_enqueue_scripts_styles() {

	wp_enqueue_style( "bootstrap", get_template_directory_uri()."/css/bootstrap.min.css");
	wp_enqueue_style( "bootstrap-responsive", get_template_directory_uri()."/css/bootstrap-responsive.min.css");
	wp_enqueue_style( "font-awesome.min", get_template_directory_uri()."/css/font-awesome.min.css");
	wp_enqueue_style( "fonts.googleapis", "//fonts.googleapis.com/css?family=Maven+Pro|Abel|Oxygen|Allura|Handlee");
	wp_enqueue_style( "prettyPhoto", get_template_directory_uri()."/css/prettyPhoto.css");
	wp_enqueue_script( 'jquery.tipsy', get_template_directory_uri().'/js/jquery.tipsy.js',array('jquery'),"1.0.0",TRUE  ); 
	wp_enqueue_script( 'jquery.mobilemenu', get_template_directory_uri().'/js/jquery.mobilemenu.js',array('jquery'),"1.0.0",TRUE );
	wp_enqueue_script( 'jquery.prettyPhoto', get_template_directory_uri().'/js/jquery.prettyPhoto.js',array('jquery'),"1.0.0",TRUE ); 
	wp_enqueue_script( 'jquery.custom', get_template_directory_uri().'/js/jquery.custom.js',array('jquery') ,"1.0.0",TRUE); 
	wp_enqueue_script( 'comment-reply' );
	
}

add_action( 'wp_enqueue_scripts', 'suevafree_enqueue_scripts_styles' );


/*-----------------------------------------------------------------------------------*/
/* Add default style, at theme activation */
/*-----------------------------------------------------------------------------------*/         

if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	
	$suevafree_setting = get_option(suevafree_themename());

	if (!$suevafree_setting) {	
	
	$skins = array( 
	
    "suevafree_skins" => "Orange", 
    "suevafree_logo_font" => "Allura", 
    "suevafree_logo_font_size" => "70px", 
    "suevafree_logo_description_font" => "Abel", 
    "suevafree_logo_description_font_size" => "14px", 
	
    "suevafree_menu_font" => "Abel", 
    "suevafree_menu_font_size" => "18px", 
	
    "suevafree_titles_font" => "Abel", 
	
    "suevafree_text_font_color" => "#616161", 
    "suevafree_copyright_font_color" => "#ffffff", 
    "suevafree_link_color" => "#ff6644", 
    "suevafree_link_color_hover" => "#d14a2b", 
    "suevafree_border_color" => "#ff6644", 

	"suevafree_body_background" => "/images/background/patterns/pattern1.jpg",
	"suevafree_body_background_repeat" => "repeat",
	"suevafree_body_background_color" => "#f3f3f3",
	
	"suevafree_footer_background" => "/images/background/patterns/pattern2.jpg",
	"suevafree_footer_background_repeat" => "repeat",
	"suevafree_footer_background_color" => "#f3f3f3",

	"home-default" => "full",
	"suevafree_footer_facebook_button" => "#",
	"suevafree_footer_twitter_button" => "#",
	"suevafree_footer_skype_button" => "#",
	"suevafree_view_comments" => "on",
	"suevafree_footer_rss_button" => "on",
	"suevafree_category_layout" => "full",

	);

	update_option( suevafree_themename(), $skins ); 
	
}
}

/*-----------------------------------------------------------------------------------*/
/* Admin menu */
/*-----------------------------------------------------------------------------------*/   

function suevafree_option_panel() {
        global $wp_admin_bar, $wpdb;
    	
		$wp_admin_bar->add_menu( array( 'id' => 'theme_options', 'title' => '<span> Theme Options </span>', 'href' => get_admin_url() . 'themes.php?page=themeoption' ) );
        $wp_admin_bar->add_menu( array( 'id' => 'get_premium', 'title' => '<span> Get Premium </span>', 'href' => get_admin_url() . 'themes.php?page=getpremium' ) );

}

add_action( 'admin_bar_menu', 'suevafree_option_panel', 1000 );

/*-----------------------------------------------------------------------------------*/
/* Prettyphoto at post gallery */
/*-----------------------------------------------------------------------------------*/   

function suevafree_prettyPhoto( $html, $id, $size, $permalink, $icon, $text ) {
	
    if ( ! $permalink )
        return str_replace( '<a', '<a data-rel="prettyPhoto" ', $html );
    else
        return $html;
}

add_filter( 'wp_get_attachment_link', 'suevafree_prettyPhoto', 10, 6);

/*-----------------------------------------------------------------------------------*/
/* Localize theme */
/*-----------------------------------------------------------------------------------*/   

load_theme_textdomain('wip', get_template_directory(). '/languages');

/*-----------------------------------------------------------------------------------*/
/* Shortcode in widget */
/*-----------------------------------------------------------------------------------*/   

add_filter('widget_text', 'do_shortcode');

/*-----------------------------------------------------------------------------------*/
/* Remove category list rel */
/*-----------------------------------------------------------------------------------*/   

function suevafree_remove_category_list_rel($output)
{
	$output = str_replace('rel="category"', '', $output);
	return $output;
}
add_filter('wp_list_categories', 'suevafree_remove_category_list_rel');
add_filter('the_category', 'suevafree_remove_category_list_rel');

/*-----------------------------------------------------------------------------------*/
/* Remove thumbnail dimensions */
/*-----------------------------------------------------------------------------------*/ 

function suevafree_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

add_filter( 'post_thumbnail_html', 'suevafree_remove_thumbnail_dimensions', 10, 3 );
  
/*-----------------------------------------------------------------------------------*/
/* Remove css gallery */
/*-----------------------------------------------------------------------------------*/ 


function suevafree_my_gallery_style() {
    return "<div class='gallery'>";
}

add_filter( 'gallery_style', 'suevafree_my_gallery_style', 99 );

/*-----------------------------------------------------------------------------------*/
/* Dropdown options */
/*-----------------------------------------------------------------------------------*/ 

function suevafree_dropdown_options($dropdown_options) {
	$dropdown_options = '<script type="text/javascript" src="'. get_stylesheet_directory_uri().'/scripts/thematic-dropdowns.js"></script>';
	return $dropdown_options;
}

add_filter('thematic_dropdown_options','suevafree_dropdown_options');


/*-----------------------------------------------------------------------------------*/
/* Socials */
/*-----------------------------------------------------------------------------------*/ 

function suevafree_socials() {
	
	$socials = array ("facebook","twitter","flickr","google","linkedin","myspace","pinterest","tumblr","youtube","vimeo");
	
	foreach ( $socials as $social ) {
		
		if (suevafree_setting('suevafree_footer_'.$social.'_button')): 
		
			echo '<a href="'.esc_url(suevafree_setting('suevafree_footer_'.$social.'_button')).'" target="_blank" title="'.$social.'" class="social '.$social.'"> '.$social.'  </a> ';
				
		endif;

	}

	if (suevafree_setting('suevafree_footer_skype_button')): 
    	echo '<a href="skype:'.suevafree_setting('suevafree_footer_skype_button').'" title="Skype" class="social skype"> Skype  </a>'; 
	endif; 

	if (suevafree_setting('suevafree_footer_email_button')): 
    	echo '<a href="mailto:'.suevafree_setting('suevafree_footer_email_button').'" title="Email" class="social email"> Email  </a>'; 
	endif; 

	if (suevafree_setting('suevafree_footer_rss_button') == "on"): 
    	echo '<a href="'; bloginfo('rss2_url'); echo '" title="Rss" class="social rss"> Rss  </a> ';
	endif; 
}

?>