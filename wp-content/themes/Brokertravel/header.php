<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    
	<title><?php bloginfo('name'); ?></title>
    
    <!-- CSS Einfügen -->
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="wp-content/themes/Brokertravel/bootstrap-3.3.0/dist/css/bootstrap.min.css">
    
    <!-- Optional theme -->
    <link rel="stylesheet" href="wp-content/themes/Brokertravel/bootstrap-3.3.0/dist/css/bootstrap-theme.min.css">
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="wp-content/themes/Brokertravel/bootstrap-3.3.0/dist/js/bootstrap.min.js"></script>
    
    <!-- jQuery Plugin -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
    <!-- My own Javascript -->
    <script type="text/javascript" src="wp-content/themes/Brokertravel/script.js"></script>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
 	<?php wp_head(); ?>
    
</head>

<body>
    <div class="container">
        <div class="row" >
            <div class="col-xs-3 col-md-3">
                    <a href="<?php bloginfo('url'); ?>"><div class="logo boxshadow"></div></a>
            </div>
         </div>
         <div class="row" >
                 <div class="col-xs-9 col-md-9 menubar">
                
                    <!-- http://codex.wordpress.org/Creating_Horizontal_Menus -->
                    <ul id="categories">
                   <?php
				   		$args = array('title_li'    => '',
									  'current_category'   => 0); 
				   		wp_list_categories($args); 
					?>
                    </ul>
                </div>
          </div>
          <br />
         