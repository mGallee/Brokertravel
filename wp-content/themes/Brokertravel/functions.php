<?php
add_theme_support( 'post-thumbnails' );


function get_images($post_id) {
 
    // Get images for this post
    $images =& get_children('post_type=attachment&post_mime_type=image&post_parent=' . $post_id );
 
    // If images exist for this page
    if($images) {
        // Get the  image attachments
		foreach ($images as $index => $image){
			
			$thumbnailUrl = wp_get_attachment_thumb_url($index);
			$imageUrl = wp_get_attachment_url($index);
			$imagesHtml = $imagesHtml. "<a href='" .$imageUrl. "' data-lightbox='gallery' ><img src='" . $thumbnailUrl . "' width='150' height='150' alt='Thumbnail Image' title='Thumbnail Image' class='img-thumbnail' /></a>";
							
		}
		echo $imagesHtml;
		
    }
}
?>