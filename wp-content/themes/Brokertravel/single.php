<?php get_header(); ?>
    <div id="main">
    	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        	<h2><?php the_title(); ?></h2>
        	<div class="entry">
            	<?php the_content(); ?>
                <?php  /*
				https://www.youtube.com/watch?v=xt0Yx8p9xTQ
				
				$hotel = get_post_meta(get_the_ID(), 'Hotel', true);
				if($hotel != ''){
					echo $hotel;
				}*/
				?>
         	</div>
      	<?php endwhile; endif; ?>
    </div>
<?php get_footer(); ?>