<?php 

	/* Template Name: Left Sidebar */
	get_header(); 

?>

<!-- start content -->

<div class="container">
    <div class="row" >
    
    <div class="pin-article span8 left-sidebar" >
		
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
    
	<section id="sidebar" class="pin-article span4">
    
    	<div class="sidebar-box">
            
			<?php if ( is_active_sidebar('sidebar-area')) { 
            
                dynamic_sidebar('sidebar-area');
            
            } else { 
                
                the_widget( 'WP_Widget_Calendar',
				array("title"=> __('Calendar','wip')),
				array('before_widget' => '<div class="widget-box">',
					  'after_widget'  => '</div>',
					  'before_title'  => '<h3 class="title">',
					  'after_title'   => '</h3>'
				)
				
				);

                the_widget( 'WP_Widget_Archives','',
				array('before_widget' => '<div class="widget-box">',
					  'after_widget'  => '</div>',
					  'before_title'  => '<h3 class="title">',
					  'after_title'   => '</h3>'
				)

				);

                the_widget( 'WP_Widget_Categories','',
				array('before_widget' => '<div class="widget-box">',
					  'after_widget'  => '</div>',
					  'before_title'  => '<h3 class="title">',
					  'after_title'   => '</h3>'
				)

				);

            
             } ?>

		</div>

	</section>

	<?php endwhile; endif;?>
           
    </div>
</div>

<?php get_footer(); ?>