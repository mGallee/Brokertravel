<?php get_header(); ?>
	<div class="row entrycontent" id="page">
    	<div class="col-xs-12 col-md-12">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; endif; ?>
        </div>
	</div>
<?php get_footer(); ?>