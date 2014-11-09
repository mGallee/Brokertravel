<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    
	<title><?php wp_title(); ?> - <?php bloginfo('name'); ?></title>
    
    <!-- CSS Einfügen -->
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="wp-content/themes/Brokertravel/bootstrap-3.3.0/dist/css/bootstrap.min.css">
    
    <!-- Optional theme -->
    <link rel="stylesheet" href="wp-content/themes/Brokertravel/bootstrap-3.3.0/dist/css/bootstrap-theme.min.css">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="wp-content/themes/Brokertravel/bootstrap-3.3.0/dist/js/bootstrap.min.js"></script>



	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
 	<?php wp_head(); ?>
</head>

<body>
    <div class="container">
        <div class="row" >
              	<div class="col-xs-6 col-md-4">
                		<a href="<?php bloginfo('url'); ?>"><div id="logo"></div></a>
                </div>
              	<div class="col-xs-6 col-md-4"></div>
            	<div class="col-xs-6 col-md-4 menubar"><?php the_category('&nbsp;-&nbsp;') ?></div>
         </div>