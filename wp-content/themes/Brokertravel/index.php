<?php get_header(); ?>
	<div class="row entrycategory">
        <div class="col-xs-12 col-sm-11 col-md-12">
        	<?php echo category_description(); ?>
        </div>
    </div>
    <div class="row">
    	<div class="col-xs-12 col-md-12">
            <?php if (have_posts()) : while (have_posts()) : the_post();
					if(!post_is_in_descendant_category($_SESSION['catID'])){
						continue;
					}
					if (has_post_thumbnail()) {
						$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()),full , false, '' );
					}
			?>
            <article>
                <a href="<?php the_permalink()?>">
                    <div class="row entryheader boxshadow" style="background:url(<?php echo $src[0]; ?>) center">
                        <div class="col-xs-12 col-md-12">
                            <div class="row entrytitle">
                                <div class="col-xs-12 col-sm-7 col-md-7">
                                    <div><h2 class="title"><?php the_title(); ?></h2></div>
                                    <div class="subtitle text-nowrap hidden-xs">
                                        <?php
                                    		$subtitle = get_post_meta(get_the_ID(), 'Untertitel', true);
                                        	if($subtitle != '')
                                        	    echo  $subtitle ;  
                                        ?>
									</div>
                                </div>
                                <div class="hidden-xs col-sm-5 col-md-5">
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
                <time datetime="<?php echo get_the_date('Y-m-d h:i:s'); ?>"></time>
            </article>
            <br />
            <?php endwhile; endif;?>
        </div>
    </div>
<?php get_footer(); ?>