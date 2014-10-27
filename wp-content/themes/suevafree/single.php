<?php get_header(); ?>

<!-- start content -->

<div class="container">
	<div class="row">
       
    <div <?php post_class(array('pin-article', suevafree_template('span') , suevafree_template('sidebar'))); ?> >
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        
		<?php do_action('suevafree_postformat'); ?>
	        
        <div style="clear:both"></div>
        
    </div>

	<?php get_sidebar(); ?>

	<?php endwhile; get_template_part('pagination'); endif;?>
           
    </div>
</div>

<?php get_footer(); ?>