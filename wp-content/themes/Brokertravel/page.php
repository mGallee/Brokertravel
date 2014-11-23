<?php get_header(); ?>
	<div class="row">
    	<div class="col-xs-12 col-md-12">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="entrycontent">
                <?php the_content(); ?>
            </div>
            <?php endwhile; endif; ?>
        </div>
	</div>
<?php get_footer(); ?>