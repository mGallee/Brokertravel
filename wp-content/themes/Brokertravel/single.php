<?php get_header(); ?>
	<div class="row">
          <div class="col-xs-12 col-md-12">
              <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="row entryheader">
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
                    		<?php the_content(); ?>
                            <!-- <hr class="verticalrule" /> -->
                            <hr class="horizontalrule" />
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
                            	<button type="button" class="btn btn-primary btn-lg btn-block">Zur Buchung &rsaquo;&rsaquo;</button>
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
									if($validfrom != '')
										echo  "Gültig von ".$validfrom;
									$validuntil = get_post_meta(get_the_ID(), 'gueltig_bis', true);
									if($validuntil != '')
										echo  " bis ".$validuntil;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row entrygallery">
                    	<div class="col-xs-12 col-md-12">
                            TEST TEST<br /><br />
                        </div>
                    </div>
            <?php endwhile; endif; ?>
          </div>
    </div>
<?php get_footer(); ?>