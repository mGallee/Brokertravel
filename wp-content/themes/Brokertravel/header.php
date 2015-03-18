<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		include("header_include.php");
	?>
</head>

<body>
<!-- Google Analytics -->
<?php include_once("analyticstracking.php") ?>

    <div class="container">
    	<?php 
		$categoryArray = get_the_category(); 
		$category = $categoryArray[0]->cat_ID;

		if($_SESSION['catID'] == 23 ){
			$imagename = "home";
			if(cat_is_ancestor_of( 23, $category )){
				$imagename = 'cat-item-' . $category;
			}
		}
		if($_SESSION['catID'] == 7 )
			$imagename = "cat-item-7";
	
		?>
    	<header class="boxshadow" style="background-image:url(wp-content/themes/Brokertravel/images/<?php echo $imagename; ?>.png)">
        	<div class="row">
            	<div class="col-xs-12 col-md-12">
                	<div class="header-container">
                		<div class="logo-container boxshadow"><a href="<?php bloginfo('url'); ?>"><div class="logo"></div></a>
                        <span class="glyphicon glyphicon-phone" aria-hidden="true"></span> +43 664 520 3609<br />
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
											  'child_of'           => $_SESSION['catID'],
											  'orderby'			   => 'id'); 
                                		wp_list_categories($args); 
                            	?>
                          	
                          </ul>
                          <?php
						  	if(!$_SESSION['loggedIn']){
                        		// Wird ein andermal hinzugefügt: 
								// echo '<a href="'.get_page_link(342).'"><div class="accessButton"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Anmelden</div></a>';
							}else{
								echo '<a href="'.get_page_link(366).'"><div class="accessButton"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Abmelden</div></a>';
							}
							?>
                        </div><!-- /.navbar-collapse -->
                      </div><!-- /.container-fluid -->
                    </nav>
            	</div>
          	</div><!-- Row ende -->
          </header>
          <br />
         