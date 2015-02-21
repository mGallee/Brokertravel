<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		include("header_include.php");
	?>
</head>

<body>
    <div class="container">
    	<?php 
		$imagename = "home";
		$categories = get_the_category(); 
		$category_id = $categories[0]->cat_ID;
		if($category_id)
			$imagename = 'cat-item-'.$category_id;
		else
			$imagename = "home";
		?>
    	<header class="boxshadow" style="background-image:url(wp-content/themes/Brokertravel/images/<?php echo $imagename; ?>.png)">
        	<div class="row">
            	<div class="col-xs-12 col-md-12">
                	<div class="header-container">
                		<div class="logo-container boxshadow"><a href="<?php bloginfo('url'); ?>"><div class="logo"></div></a>
                        <span class="glyphicon glyphicon-phone" aria-hidden="true"></span> +43 2243 32888<br />
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"> </span> office@brokertravel.at</div>
            		</div>
                </div>
          	</div>
            <div class="row">
            	<div class="col-xs-12 col-md-12">
                    <nav class="navbar navbar-inverse">
                      <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </button>
                        </div>
                        
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                          <ul class="nav navbar-nav">
								<?php
                                		$args = array('title_li'   => '',
                                              'current_category'   => 0,
											  'orderby'			   => 'id'); 
                                		wp_list_categories($args); 
                            	?>
                          </ul>
                        </div><!-- /.navbar-collapse -->
                      </div><!-- /.container-fluid -->
                    </nav>
            	</div>
          	</div><!-- Row ende -->
          </header>
          <br />
         