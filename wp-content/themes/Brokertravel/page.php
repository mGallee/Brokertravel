<?php get_header(); ?>
	<div class="row entrycontent boxshadow">
    	<div class="col-xs-12 col-md-12">
             <?php  
				 if (have_posts()) : while (have_posts()) : the_post(); 
				   the_content();
            	 endwhile; endif; 
			?>
        </div>
	</div>
    <br />
<?php get_footer(); ?>