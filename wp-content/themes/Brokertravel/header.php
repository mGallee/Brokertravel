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
                <div class="col-xs-3 col-md-3">
                        <a href="<?php bloginfo('url'); ?>"><div class="logo boxshadow"></div></a>
                </div>
             </div>
             <div class="row" >
                     <div class="col-xs-9 col-md-9 menubar">
                        <nav>
                            <!-- http://codex.wordpress.org/Creating_Horizontal_Menus -->
                            <ul id="categories">
                            <?php
                                $args = array('title_li'    => '',
                                              'current_category'   => 0); 
                                wp_list_categories($args); 
                            ?>
                            </ul>
                        </nav>
                    </div>
              </div>
          </header>
          <br />
         