<?php get_header(); ?>
    <div class="row boxshadow">
        <div class="col-xs-12 col-md-12">
			<?php if (have_posts()) : while (have_posts()) : the_post(); 
					if (has_post_thumbnail()) {
						$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),full , false, '' );
					}
            ?>
            <article>
                <div class="row entryheader" style="background:url(<?php echo $src[0]; ?>) center">
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
                                    <div class="stars">
                                        <?php
                                        $stars = get_post_meta(get_the_ID(), 'Sterne', true);
                                        if($stars != '')
                                            for($i=1; $i<=$stars; $i++) 
                                                echo "&#9733;";                 
                                        ?>
                                    </div>
                                </div>
                            </div>
                      </div>
                </div>
                <div class="row entrycontent">
                    <div class="col-xs-9 col-md-9">
                        <div>
                            <?php the_content(); ?>
                            <time pubdate datetime="<?php the_date('Y-m-d h:i:s'); ?>"></time>
                            <hr class="horizontalrule" />
                        </div>
                        <div class="verticalrule"></div>
                    </div>
                    <div class="col-xs-3 col-md-3">
                        <div class="pricecontent">
                            <?php
                                $price = get_post_meta(get_the_ID(), 'Preis', true);
                                if($price != '')
                                    echo "<b>" . $price . "</b> &euro; pro Person ";                 
                            ?>
                        </div>
                        <div class="durationcontent">
                            <?php
                                $days = get_post_meta(get_the_ID(), 'Tage', true);
                                if($days != '')
                                    echo  $days . " Tage " . ($days-1) . " Nächte";
                            ?>
                        </div>
                        <div>
                            <form action="<?php echo get_page_link(163); ?>" method="post">
                                <input type="hidden" name="blogID" value="<?php echo $post->ID ?>" />
                                <button type="submit" class="btn btn-primary btn-lg btn-block" >Anfrage senden &rsaquo;&rsaquo;</button>
                            </form>
                        </div>
                        <div class="surcharges">
                            <br />
                            <?php
                                $costs = get_post_meta(get_the_ID(), 'Zuschlaege', true);
                                if($costs != '')
                                    echo  $costs;
                            ?>
                        </div>
                        <div class="available">
                            <br />
                            <?php
                                $validfrom = get_post_meta(get_the_ID(), 'gueltig_von', true);
                                echo "Gültig";
                                if($validfrom != '')
                                    echo  " von ".$validfrom;
                                $validuntil = get_post_meta(get_the_ID(), 'gueltig_bis', true);
                                if($validuntil != '')
                                    echo  " bis ".$validuntil;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row entrygallery">
                    <div class="col-xs-12 col-md-12">
                            <?php
                                $slideshowId = get_post_meta(get_the_ID(), 'DiashowID', true);
                                if($slideshowId != ''){
                                    do_action('slideshow_deploy', $slideshowId);
                                }else{
                                    echo "<div style='text-align:center'>";
                                        echo "<i>Zu diesem Beitrag ist keine Gallerie vorhanden!</i><br />";
                                    echo "</div>";
                                }
                            ?>
                    </div>
                </div>
            </article>
            <?php endwhile; endif; ?>
		</div>
    </div>
    <br  />
<?php get_footer(); ?>