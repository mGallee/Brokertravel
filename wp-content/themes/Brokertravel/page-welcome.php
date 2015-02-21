<?php get_header(); ?>
  	<div class="row">
    	<div class="col-xs-12 col-md-12 slider">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators ">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                  </ol>
                
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                        <?php
							$args = array('numberposts' => 3, 'category' => 0 );
							$recent_posts = wp_get_recent_posts($args);
							
							foreach( $recent_posts as $key => $recent ){
								
								$imageUrl = wp_get_attachment_image_src( get_post_thumbnail_id($recent["ID"]),full,false);
								if($imageUrl[0] == "")
									$imageUrl[0] = "wp-content/themes/Brokertravel/images/blue.jpg";
									
								if($key == 0)
									echo "<div class='item active'>";
								else
									echo "<div class='item'>";
							
								
								echo "<a href='".get_permalink($recent["ID"])."' ><img src='".$imageUrl[0]."' alt='".$recent["post_title"]."' style='height:100%;width:100%'/>";
								echo '<div class="carousel-caption">
										<h4>'.$recent["post_title"].'</h4>
										<p class="caption-price">ab '.get_post_meta($recent["ID"], 'Preis', true).'&euro;</p>
										<p class="caption-content">'.get_post_meta($recent["ID"], 'Kurzfassung', true).'</p>
									  </div></div></a>';
									  
							}
						?>
                  </div>
                  
            </div>
		</div>
	</div>    
  	<div class="row entrycontent">
          <div class="col-sm-3 col-md-3">
        <div class="thumbnail welcome-info-box" >
          <img src="wp-content/themes/Brokertravel/images/about.png" width="203"  alt="Über mich">
          <div class="caption" >

            <p><a href="<?php echo get_page_link(340); ?>" class="btn btn-primary" role="button">Über mich</a></p>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-6">
        <div class="thumbnail welcome-info-box" >
        	<div class="caption">
				<?php 
					$page = get_post(350);
					$content = apply_filters('the_content', $page->post_content);
					$content = str_replace(']]>', ']]>', $content);
					echo $content;
				 ?>
    		</div>
        </div>
      </div>

	  <div class="col-sm-3 col-md-3">
        <div class="thumbnail welcome-info-box">
          <div class="caption">
          	<h3>Newsletter</h3>	
            <p>		
			<?php 	
                $widgetNL = new WYSIJA_NL_Widget(true);
                echo $widgetNL->widget(array('form' => 1, 'form_type' => 'php')); 
            ?>
            </p>
          </div>
        </div>
        <img src="wp-content/themes/Brokertravel/images/newsletter.png" alt="Newsletter"   >
      </div>
	</div>
    <br />
<?php get_footer(); ?>