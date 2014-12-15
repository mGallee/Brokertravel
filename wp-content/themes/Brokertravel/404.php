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
    
    <!-- jQuery Plugin -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="wp-content/themes/Brokertravel/bootstrap-3.3.0/dist/js/bootstrap.min.js"></script>
    
    <!-- My own Javascript -->
    <script type="text/javascript" src="wp-content/themes/Brokertravel/script.js"></script>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
 	<?php wp_head(); ?>
    
</head>

<body>
    <div class="container">
	<div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="error-template">
                <h1> Uups!</h1>
                <h2>404 Not Found</h2>
                <div class="error-details">
                    Ein Fehler ist aufgetreten: Seite wurde nicht gefunden!
                </div>
                <div class="error-actions">
                    <a href="<?php bloginfo('url'); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                        Zur Startseite </a><a href="<?php echo get_page_link(36); ?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Fehler melden </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>