<?php get_header(); ?>
	<div class="row entrycontent boxshadow">
    	<div class="col-xs-12 col-md-12">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(96);?>
            <?php endwhile; endif; ?>
        </div>
	</div>
    <br />
<?php get_footer(); ?>