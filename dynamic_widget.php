<?php
class odudeshopDynamicProduct extends WP_Widget 
{
    
    function __construct() 
	{
        global $pagenow;
        //parent::WP_Widget( /* Base ID */'odudeshopMiniCart', /* Name */'ODude Shop Mini Cart widget', array( 'description' => 'odudeshop Mini Cart widget' ) );
		parent::__construct( /* Base ID */'odudeshopDynamicProduct', /* Name */'ODude Shop Dynamic Product widget', array( 'description' => 'odudeshop Dynamic Product widget' ) );
        
    }

    /** @see WP_Widget::widget */
    function widget( $args, $instance ) 
	{
       extract( $args );
       $settings = get_option('_odudes_settings');
       echo $before_widget;
      
	  
        ?>
		
      

DDDDDDDDDd
	   <?php
	    echo $after_widget;
		
	}
	
}
add_action( 'widgets_init', create_function( '', 'register_widget("odudeshopDynamicProduct");' ) );

?>