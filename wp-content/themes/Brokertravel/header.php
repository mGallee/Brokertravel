<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title(); ?> - <?php bloginfo('name'); ?></title>
    
    <!-- CSS Einfühgen -->

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
 	<?php wp_head(); ?>
</head>

<body>
    <div id="wrapper">
        <div id="header">
            	<a href="<?php bloginfo('url'); ?>"><div id="logo"></div></a>
            <div id="category">
            	<?php the_category('&nbsp;-&nbsp;') ?>
            </div>
        </div>