<?php if ( suevafree_template('span') == "span8" ) : ?>
        
	<section id="sidebar" class="pin-article span4">
    
    	<div class="sidebar-box">
            
			<?php if ( is_active_sidebar('sidebar-area')) { 
            
                dynamic_sidebar('sidebar-area');
            
            } else { 
                
                the_widget( 'WP_Widget_Calendar',
				array("title"=> __('Calendar','wip')),
				array('before_widget' => '<div class="widget-box">',
					  'after_widget'  => '</div>',
					  'before_title'  => '<h3 class="title">',
					  'after_title'   => '</h3>'
				)
				
				);

                the_widget( 'WP_Widget_Archives','',
				array('before_widget' => '<div class="widget-box">',
					  'after_widget'  => '</div>',
					  'before_title'  => '<h3 class="title">',
					  'after_title'   => '</h3>'
				)

				);

                the_widget( 'WP_Widget_Categories','',
				array('before_widget' => '<div class="widget-box">',
					  'after_widget'  => '</div>',
					  'before_title'  => '<h3 class="title">',
					  'after_title'   => '</h3>'
				)

				);

            
             } ?>

		</div>

	</section>
    
<?php endif; ?>