<?php

	function thepane( $panel ) { 
	
	suevafree_save_option ( $panel );

	$suevafree_setting = get_option( suevafree_themename() );

	if (!isset($_GET['tab']))  { $_GET['tab'] = "General"; }
	
	foreach ($panel as $element) {

		switch ( $element['type'] ) { 
		
			case 'navigation':
			
				suevafree_message($panel); ?>
	
    			<h2 class="voobis"> <?php _e( 'General Settings','wip'); ?>  </h2>

				<div id="tabs">
                
                <ul>
    
   				<?php 
				
   				foreach ($element['item'] as $option => $name ) {
					if (str_replace(" ", "", $option) == $_GET['tab'] ) $class = "class='ui-state-active'"; else $class = ""; 
					echo "<li ".$class."><a href='themes.php?page=themeoption&tab=".str_replace(" ", "", $option)."'>".$name."</a></li>";
				}
				?>
               
                </ul>
               
                <?php	
			
			break;
			
			case 'endpanel':  ?>
				
				</div>
				<div style="margin:10px 0; font-size:11px">Icons by: <a href="http://www.woothemes.com/2009/09/woofunction/" target="_blank">WooFunction</a> </div>
			
			<?php break;
			
		}
		
	if (isset($element['tab'])) : 

	switch ( $element['tab'] ) { 
			
		case $_GET['tab']:  

			foreach ($element as $value) {
			
				if ( isset( $value['type']) ) { 
				
					switch ( $value['type'] ) { 
					
						case 'form':  ?>
							
							<div id="<?php echo str_replace(" ", "", $value['name']); ?>">
							<form method="post" action="?page=themeoption&tab=<?php echo $_GET['tab']; ?>">
						
						<?php break;
						
						case 'endtab':  ?>
							
							</form>
							</div>
						
						<?php break;
							
						case 'start':  ?>
				
						<?php 
			
							if ( ('Save' == suevafree_request('action'))  && ( $value['id'] == suevafree_request('element-opened')) ) { 
								$class=" inactive"; $style='style="display:block;"'; } else { $class="";  $style=''; 
							}  
				
							?>
							
							<div class="wip_container">
			
							<h5 class="element<?php echo $class; ?>" id="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></h5>
				   
							<div class="wip_mainbox" <?php echo $style; ?> > 
			
						<?php break;
				
						case 'startopen':  ?>
				
							<div class="wip_container">
			
							<h5 class="element-open"><?php echo $value['name']; ?></h5>
				   
							<div class="wip_mainbox2"> 
			
						<?php break;
				
						case 'end':  ?>
				
							</div>            
			
							</div>
			   
						<?php break;
			
						case 'multicategory': ?>
			
							<div class="wip_inputbox">
			
							<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					
							<?php foreach ($value['options'] as $val => $option ) { 
			
								$checked ='';
			
								if ( suevafree_setting($value['id']) != false ) {
			
									foreach (suevafree_setting($value['id']) as $check ) { 
			
									if ($check == $val )  { $checked ='checked="checked"'; } } 
			
								} ?> 
			
								<p><input name="<?php echo $value['id']; ?>[]" type="checkbox" value="<?php echo $val; ?>" <?php echo $checked; ?> /> <?php echo $option; ?> 					</p> <?php } ?>  
								<p><?php echo $value['desc']; ?></p>
			
								</div>
			
							<?php break;
			
							case 'pages': ?>
			
								<div class="wip_inputbox">
			
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			
								<?php foreach ( $value['options'] as $page ) { 
			
								$checked ='';
			
								if ( suevafree_setting($value['id']) != false ) {
			
									foreach (suevafree_setting($value['id']) as $check ) { 
			
									if ($check == $page->ID )  { $checked ='checked="checked"'; } } 
			
								} ?> 
				  
								<p><input name="<?php echo $value['id']; ?>[]" type="checkbox" value="<?php echo $page->ID; ?>" <?php echo $checked; ?> /> <?php echo $page->post_title; ?></p>
			
								<?php } ?>  
								
								<p><?php echo $value['desc']; ?></p>
			 
								</div>
			 
							<?php break;
								
							case 'text': ?>
			
								<div class="wip_inputbox">
			
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								
								<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( suevafree_setting($value['id']) != "") { echo stripslashes(suevafree_setting($value['id'])); } else { echo $value['std']; } ?>" />
								
								<p> <?php echo $value['desc']; ?> </p>
			
								</div>
			
							<?php break;
				
							case 'form':  ?>
				
							<?php break;
				
							case 'navigation':  ?>
				
								<?php echo $value['start']; ?>
			
								<?php foreach ($value['item'] as $option) { echo "<li><a href='#".str_replace(" ", "", $option)."'>".$option."</a></li>"; } ?>
			
								<?php echo $value['end']; ?>
			   
							<?php break;
			 
							case 'textarea':  ?>
				
								<div class="wip_inputbox">
			
								<label for="bl_custom_style"> <?php echo $value['name']; ?> </label>
								
								<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( suevafree_setting($value['id']) != "") { echo stripslashes(suevafree_setting($value['id'])); } else { echo $value['std']; } ?></textarea>
			
								<p><?php echo $value['desc']; ?></p>
			
								</div> 
				
							<?php break;
			
							case "on-off": ?>
			
								<div class="wip_inputbox">
			
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			
								<div class="bool-slider <?php if ( suevafree_setting($value['id']) != "") { echo stripslashes(suevafree_setting($value['id'])); } else { echo $value['std']; } ?>">
									<div class="inset">
										<div class="control"></div>
									</div>
									<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="on-off" type="hidden" value="<?php if ( suevafree_setting($value['id']) != "") { echo stripslashes(suevafree_setting($value['id'])); } else { echo $value['std']; } ?>" />
								</div>  
								
								<div class="clear"></div>      
								
								<p><?php echo $value['desc']; ?></p>
								
								</div>
			
							<?php break;
				 
							case 'categoria': ?>
				
								<div class="wip_inputbox">
			
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			
								<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( suevafree_setting($value['id']) == get_cat_id($option)) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?> value="<?php echo get_cat_id($option); ?>" ><?php echo $option; ?></option><?php } ?></select>
			 
								<p><?php echo $value['desc']; ?></p>
			
								</div>
				
							<?php break;
				 
							case 'select': ?>
				
								<div class="wip_inputbox">
			
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			
								<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">  
								
								<?php foreach ( $value['options'] as $val => $option ) { ?>  
								
								<option <?php if (( suevafree_setting( $value['id'] ) == $val) || ( ( !suevafree_setting($value['id'])) && ( $value['std'] == $val) )) { echo 'selected="selected"'; } ?> value="<?php echo $val; ?>"><?php echo $option; ?></option><?php } ?>  
								</select>  
			 
								<p><?php echo $value['desc']; ?></p>
			
								</div>
				
							<?php break;
							
							case "save-button": ?>
			
								<div class="wip_inputbox">
			
								<input name="action" id="element-open" type="submit" value="<?php echo $value['value']; ?>" class="button"/>
			
								</div>
			
							<?php break;
					}
				}
			}
		}
		
		endif;	

	}	
} 

?>