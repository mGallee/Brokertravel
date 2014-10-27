<?php get_header(); ?>

<div class="container">
	<div class="row">
		
		<?php if ( have_posts() ) :  ?>
		
        <div class="pin-article span12">

			<article class="article search">

				<p><?php _e( '<span>Search </span> results for', 'wip' ) ?> <strong><?php echo $s; ?> </strong></p>
 
			</article>

    	</div>
		
		<?php while ( have_posts() ) : the_post(); ?>

            <div class="pin-article span12">
    
				<?php do_action('suevafree_postformat'); ?>
        
                <div style="clear:both"></div>
            
            </div>
		
		<?php endwhile; else:  ?>

        <div class="pin-article span12">

			<article class="article search">

				<p><?php _e( 'Sorry, no posts matched your criteria','wip' ) ?> <strong>: <?php echo $s; ?> </strong></p>
 
			</article>

    	</div>
	
		<?php endif; ?>
           
    </div>
</div>

<?php
	
	get_template_part('pagination');
	get_footer(); 

?>