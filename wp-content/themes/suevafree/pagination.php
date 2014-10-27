<div class="clear"></div>

<?php 
global $wp_query;
$big = 999999999; // need an unlikely integer
if ( (is_category()) || (is_search()) ) { 


    $paginate_links = paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
    'prev_text'    => '&laquo;',
    'next_text'    => '&raquo;',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages
) );

if (!empty($paginate_links)) {
	echo '<div class="wp-pagenavi">';
	echo $paginate_links;
	echo '</div>';
}
}
?>

<?php if (is_home() ) { 

	$total = $wp_query->max_num_pages ; 
    $paginate_links = paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
    'prev_text'    => '&laquo;',
    'next_text'    => '&raquo;',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $total
) );

if (!empty($paginate_links)) {
	echo '<div class="wp-pagenavi">';
	echo $paginate_links;
	echo '</div>';
}
}
?>

<?php 

if (is_page() ) { 

	$paged1 = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args1 = array('post_type' => get_post_type( $post->ID ),'paged' => $paged1,'posts_per_page' => get_option('posts_per_page'));
	$query1 = new WP_Query( $args1 );

    $paginate_links = paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
    'prev_text'    => '&laquo;',
    'next_text'    => '&raquo;',
	'current' => $paged1,
	'total' => $query1->max_num_pages ,
) );

if (!empty($paginate_links)) {
	echo '<div class="wp-pagenavi">';
	echo $paginate_links;
	echo '</div>';
}

}

?>