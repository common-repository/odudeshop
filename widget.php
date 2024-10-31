<?php
class odudeshopMiniCart extends WP_Widget 
{
    
    function __construct() 
	{
        global $pagenow;
        //parent::WP_Widget( /* Base ID */'odudeshopMiniCart', /* Name */'ODude Shop Mini Cart widget', array( 'description' => 'odudeshop Mini Cart widget' ) );
		parent::__construct( /* Base ID */'odudeshopMiniCart', /* Name */'ODude Shop Mini Cart widget', array( 'description' => 'odudeshop Mini Cart widget' ) );
        
    }

    /** @see WP_Widget::widget */
    function widget( $args, $instance ) 
	{
       extract( $args );
	   if(isset($instance['title']))
       $title =  $instance['title'] ;
		else
		$title="";
         $settings = get_option('_odudes_settings');
       echo $before_widget;
      // if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 
       
        $currency_sign = get_option('_odudes_curr_sign','$');
		$shopping_cart=load_odude_cart();
		$shopping_total_item=$shopping_cart['total_item'];
		$shopping_total_value=$shopping_cart['total_price'];
        if(count($shopping_total_item)==0) $cart = __("No item in cart.","odudeshop")."<br/><a href='".$settings['continue_shopping_url']."'>".__("Continue shopping","odudeshop")."</a>";
        ?>
		
      
<style>

#btn-cart a {
  background: -webkit-linear-gradient(top, #F0915B, #D76E2C);
  border: 1px solid #aa5800;
  float: left;
  border-radius: 6px;
  color: #FFF;
  display: block;
  text-shadow: 0 1px #555;
  font-weight: bold;
  text-decoration: none;
  font-size: 13px;
  height: 25px;
  padding-right: 5px;
  position: relative;
  box-shadow: 0 1px 2px #999, 0 1px 1px #EFEFEF inset;
}
#btn-cart a > span {
  display: block;
  line-height: 22px;
  padding: 2px 5px 0px 40px;
}
#btn-cart a:before {
  font-family: 'FontAwesome';
  content: "\f07a";
  position: absolute;
  top: 8px;
  left: 10px;
  height: 20px;
}
#btn-cart a:after {
  content: "";
  position: absolute;
  height: 24px;
  width: 0;
  border-right: 1px solid #D76E2C;
  border-left: 1px solid #F0915B;
  top: 1px;
  left: 31px;
}


</style>
<div id="odude_widgets_total">
<div id="btn-cart" class="fr">
  <a href="<?php echo get_permalink($settings['page_id']); ?>" title="View your Shopping Cart">
    <span>
	 <span id="odude_default"><?php echo $shopping_total_item; ?> Item -  <?php echo $currency_sign; ?> <?php echo $shopping_total_value; ?></span>
  <span id="odude_ajax_loading" style="width:100px; display:none;"><i class="fa fa-refresh fa-spin"></i></span>&nbsp;

    </span>
  </a>
</div>
</div><br>	
	   <?php
	    echo $after_widget;
		
	}
	
}
add_action( 'widgets_init', create_function( '', 'register_widget("odudeshopMiniCart");' ) );

?>