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

/**
 * Tests if any of a post's assigned categories are descendants of target categories
 *
 * @param int|array $cats The target categories. Integer ID or array of integer IDs
 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
 * @uses get_term_children() Passes $cats
 * @uses in_category() Passes $_post (can be empty)
 * @version 2.7
 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
 */
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
	function post_is_in_descendant_category( $cats, $_post = null ) {
		foreach ( (array) $cats as $cat ) {
			// get_term_children() accepts integer ID only
			$descendants = get_term_children( (int) $cat, 'category' );
			if ( $descendants && in_category( $descendants, $_post ) )
				return true;
		}
		return false;
	}
}
?>