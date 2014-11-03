<?php get_header(); ?>
    <div id="main">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <a href="<?php the_permalink() ?>">
                <div id="bloglink">
                	<div id="blackbox">
                		<h2><?php the_title(); ?></h2>
                    </div>
            		<br />
        		</div>
            </a>
        <?php endwhile; endif; ?>
    </div>
<?php get_footer(); ?>