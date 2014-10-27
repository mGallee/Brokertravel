<?php get_header(); ?>

<!-- start content -->

<div class="container">
    <div class="row" >
    
    <div class="pin-article span12 full" >
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        
			<?php if ( has_post_thumbnail() ) : ?>
                    
                <div class="pin-container">
                    <?php the_post_thumbnail('blog'); ?>
                </div>
                    
            <?php endif; ?>
                
            <article class="article">
            
                <h1 class="title"><?php the_title(); ?></h1>
                
                <div class="line"></div>
            
                <?php 
					
					the_content();  
					
					wp_link_pages(); 
					
					if (suevafree_setting('suevafree_view_comments') == "on" ) :
						comments_template();
					endif;
					
				?>

            </article>
	        
        <div style="clear:both"></div>
        
    </div>
    
	<?php endwhile; endif;?>
           
    </div>
</div>

<?php get_footer(); ?>