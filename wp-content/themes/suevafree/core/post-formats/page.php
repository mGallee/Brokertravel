<?php 
		
	if ( has_post_thumbnail() ) { ?>
        
		 <div class="pin-container">
			<?php the_post_thumbnail('blog'); ?>
		</div>
        
<?php } ?>
    
<article class="article">

    <h1 class="title"><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a></h1>
    
    <div class="line"></div>

	<?php 
	
	if ( is_search() ):
		
		suevafree_excerpt(); 
	
	else:

		the_content();
		
		echo "<div class='clear'></div>";
		
		wp_link_pages();
		
		if (suevafree_setting('suevafree_view_comments') == "on" ) :
			comments_template();
		endif;
		
	endif;
	
	
	?>

</article>