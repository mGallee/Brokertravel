<?php 

/*-----------------------------------------------------------------------------------*/
/* START SEARCH WIDGET
/*-----------------------------------------------------------------------------------*/ 
   
class suevafree_search_widget extends WP_Widget
{
	public function __construct() 
    {
		parent::WP_Widget( "suevafree_search_widget", "Wip Search Widget", array("description" => "Wip Search Widget"));
	}
		public function form( $instance )
	{
        /* Impostazioni di default del widget */
		$defaults = array( 
			'title' => 'Search Form',
        );
		
		$instance = wp_parse_args( (array) $instance, $defaults ); 

		?>
        
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				Title:
			</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
			
		</p>  

		<?php
	}
	
	public function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
	}                     

	public function widget( $args, $instance )
	{
		extract( $args );
		
		echo $before_widget;

		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( $title ) {
			echo $before_title.$title.$after_title;
		}

		?>
		<section class="contact-form">
			<form method="get" id="searchform" action="<?php esc_url( home_url( '/' ) ); ?>">
   				 <div>
    		     <input type="text" placeholder="<?php _e( 'Search here', 'wip' ) ?>"  name="s" id="s" class="input-search"/>
    			 </div>
			</form>
        <div class="clear"></div>  
		</section>
		<?php
		echo $after_widget;
	}
	}
function add_suevafree_search_widget()
{
	register_widget( 'suevafree_search_widget' );
}
add_action( 'widgets_init', 'add_suevafree_search_widget' );

/*-----------------------------------------------------------------------------------*/
/* END SEARCH WIDGET
/*-----------------------------------------------------------------------------------*/    
?>