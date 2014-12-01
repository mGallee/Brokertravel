<?php get_header(); ?>
    <div class="row">
    	<div class="col-xs-12 col-md-12">
              <?php if (have_posts()) : while (have_posts()) : the_post();
			  	if (has_post_thumbnail()) {
			  		$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,405 ), false, '' );
				}
			  ?>
                <a href="<?php the_permalink()?>">
                    <div class="row entryheader boxshadow" style="background:url(<?php echo $src[0]; ?>)">
                         <div class="col-xs-12 col-md-12">
                                <div class="row entrytitle">
                                	<div class="col-xs-8 col-md-8">
                                    	<div class="title"><?php the_title(); ?></div>
                                        <div class="subtitle"> 
                                        	<?php
                                        		$subtitle = get_post_meta(get_the_ID(), 'Untertitel', true);
                                            	if($subtitle != '')
                                            	    echo  $subtitle ;  
                                        	?>
										</div>
                                    </div>
                                    <div class="col-xs-4 col-md-4">
                                        <div class="priceheader">
											<?php
												$price = get_post_meta(get_the_ID(), 'Preis', true);
												if($price != '')
													echo "<b>" . $price . "</b> &euro; pro Person ";                 
                                            ?>
                                        </div>
                                        <div class="durationheader">
											<?php
												$days = get_post_meta(get_the_ID(), 'Tage', true);
												if($days != '')
													echo  $days . " Tage " . ($days-1) . " Nächte"; 
                                            ?>
                                        </div>
                                	</div>
                           </div>
                      </div>
                </div>
                </a>
                <br />
            <?php endwhile; endif; ?>
          </div>
    </div>
<?php get_footer(); ?>