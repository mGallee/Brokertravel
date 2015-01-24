<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		include("header_include.php");
	?>
</head>

<body>
    <div class="container">
    	<header>
             <div class="row" >
                     <div class="col-xs-12 col-md-12">
                     <!-- Navigation Bootstrap -->
                        <nav class="navbar navbar-default">
                          <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                              </button>
                              <a href="<?php bloginfo('url'); ?>"><div class="logo boxshadow navbar-brand"></div></a>
                            </div>
                            
                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse menubar" id="bs-example-navbar-collapse-1">
                              <ul class="nav navbar-nav navbar-right">
                              	<li><a href="<?php bloginfo('url'); ?>">Startseite <span class="sr-only">(current)</span></a></li>
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Unsere Angebote <span class="caret"></span></a>
                                  <ul class="dropdown-menu" role="menu">
                                    <?php
                                		$args = array('title_li'    => '',
                                              'current_category'   => 0); 
                                		wp_list_categories($args); 
                            		?>
                                  </ul>
                                </li>
                              </ul>
                            </div><!-- /.navbar-collapse -->
                          </div><!-- /.container-fluid -->
                        </nav>
                    <!-- Navigation Bootstrap Ende -->
                    </div>
              </div>
          </header>
          <br />
         