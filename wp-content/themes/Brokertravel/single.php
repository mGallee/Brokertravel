<?php get_header(); ?>
	<div class="row">
    	<div class="col-xs-12 col-md-12">
    	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        	<div class="entry">
            	<h2><?php the_title(); ?></h2>
                <?php  /*
				https://www.youtube.com/watch?v=xt0Yx8p9xTQ
				
				$hotel = get_post_meta(get_the_ID(), 'Hotel', true);
				if($hotel != ''){
					echo $hotel;
				}*/
				?>
         	</div>
            <div class="entrycontent">
           		<?php the_content(); ?>
            </div>
      	<?php endwhile; endif; ?>
    	</div>
    </div>
<?php get_footer(); ?>