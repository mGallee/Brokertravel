<?php

require_once get_template_directory() . '/core/metaboxes-fields.php';

function suevafree_addmetabox() {
	add_meta_box( 'content', 'Content Settings', 'suevafree_contents', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'suevafree_addmetabox' );

function suevafree_contents( $post, $post_id )
{
	global $suevafree_article; ?>
    
    <?php
	
	foreach ($suevafree_article as $value) {
	switch ( $value['type'] ) { 
	
	case 'title':  ?>
    
 	<h2 class="title"><?php echo $value['name']; ?></h2>

	<?php break;
	
	case 'start':  ?>
 	<div class="postformat" id="<?php echo $value['id']; ?>">

	<?php break;
	
	case 'end':  ?>
 	</div>

	<?php break;
	case 'select':  ?>
    
 	<p class="wip_input">
		
		<div class="input-left">
            <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label><br />
            <em> <?php echo $value['desc']; ?> </em>
		</div>
		<div class="input-right">
		<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="width:100%">
			<?php foreach ($value['options'] as $option => $values) { ?>
			<option <?php if (get_post_meta( $post->ID , $value['id'] , TRUE) == $option) { echo 'selected="selected"'; } ?> value="<?php echo $option; ?>"><?php echo $values; ?></option><?php } ?>
		</select>
		</div>
        <div class="clear"></div>
	</p>
    
    
	<?php break;
		  case 'text':  
	?>

 	<p class="wip_input">
		
		<div class="input-left">
            <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label><br />
            <em> <?php echo $value['desc']; ?> </em>
		</div>
		<div class="input-right">
        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_post_meta( $post->ID , $value['id'] , TRUE) != "") { echo get_post_meta( $post->ID , $value['id'] , TRUE); } else { echo $value['std']; } ?>" style="width:100%"/>
		</div>
        <div class="clear"></div>
	</p>

	<?php break;
			
	case 'textarea':  ?>
			
 	<p class="wip_input">
		
		<div class="input-left">
            <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label><br />
            <em> <?php echo $value['desc']; ?> </em>
		</div>
		<div class="input-right">
		<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" style="width:100%"><?php if ( get_post_meta( $post->ID , $value['id'] , TRUE) != "") { echo stripslashes(get_post_meta( $post->ID , $value['id'] , TRUE)); } else { echo $value['std']; } ?></textarea>
		</div>
        <div class="clear"></div>
	</p>
			
	<?php break;
		
		}
	}

}

add_action( 'save_post', 'suevafree_metabox_saves' );

function suevafree_metabox_saves( $post_id  ) {
	
		global $suevafree_article ;
		
		foreach ($suevafree_article as $value) {
		
		if(isset($_POST[$value['id']])) 
			$new = $_POST[$value['id']];

		if (isset($new)) 	
			update_post_meta( $post_id , $value['id'], $new );

		}

}

?>