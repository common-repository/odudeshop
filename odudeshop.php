<?php 
    /*
    Plugin Name:  ODude Shop
    Plugin URI: http://www.odude.com/
    Description: ODude Shop is a free full-featured Shopping Cart / eCommerce Plugin. Make your shop online.
    Author: ODude Network
    Version: 1.1.7
    Author URI: http://www.odude.com/
	Text Domain: odudeshop
    */

    @session_start();  
   

    define('odudes_UPLOAD_DIR',WP_CONTENT_DIR.'/uploads/odudes-products/');
    define('odudes_IMAGE_DIR',WP_CONTENT_DIR.'/uploads/odudes-previews/');
    define('odudes_IMAGE_URL',content_url('/uploads/odudes-previews/'));
    define('odudes_BASE_DIR',WP_CONTENT_DIR.'/plugins/odudeshop/');
	define( 'ODUDESHOP_ROOT_URL', plugin_dir_url( __FILE__ ) );


    function odudes_languages() {
        load_plugin_textdomain( 'odudeshop', false, dirname(plugin_basename( __FILE__ )).'/languages/' ); 
    }


    include(dirname(__FILE__)."/libs/functions.php");
	include(dirname(__FILE__)."/libs/lib.php");
    include(dirname(__FILE__)."/libs/class.plugin.php");
    include(dirname(__FILE__)."/libs/class.order.php");
    include(dirname(__FILE__)."/libs/class.payment.php");
    include(dirname(__FILE__)."/libs/cart.php");
    include(dirname(__FILE__)."/libs/print_invoice.php");
    include(dirname(__FILE__)."/libs/hooks.php");
    include(dirname(__FILE__)."/libs/install.php");
    include(dirname(__FILE__)."/libs/stock.php");
    include(dirname(__FILE__)."/widget.php");
	//  include(dirname(__FILE__)."/dynamic_widget.php");
    include(dirname(__FILE__)."/libs/custom_user_info.php");
    include(dirname(__FILE__)."/libs/custom_column.php");

add_action('wp_ajax_get_item_in_cart', 'get_item_in_cart'); // For logged in users
add_action('wp_ajax_nopriv_get_item_in_cart', 'get_item_in_cart'); // For non-logged in users

//change section title


add_action('loop_start','condition_filter_title');
add_filter( 'wp_title', 'modified_post_title', 10, 2);
add_filter('wpseo_title', 'modified_post_title');
function condition_filter_title($query)
{
	global $wp_query;
	if($query === $wp_query){
		add_filter( 'the_title', 'modified_post_title', 10, 2);
		
	}else{
		remove_filter('the_title','modified_post_title', 10, 2);
	}
}
function modified_post_title( $title ) 
{
    if ( is_page( 'section' ) ) 
	{
			
		
		global $wp;
		$view = $wp->query_vars['section'];
		$cates = get_term_by('slug', $view, 'ptype');
		$cates_name=$cates->name;
        return $cates_name;
    }
    return $title;
}


//Own rewrite rules for product categories
  add_action('init','odudeshop_rewrite_init');
function odudeshop_rewrite_init() 
{
  global $wp,$wp_rewrite;
  $wp->add_query_var('section');
  //$wp_rewrite->add_rule('section/([^/]+)','index.php?section=$matches[1]', 'top');
 $wp_rewrite->add_rule('section/([^/]+)','index.php?section=$matches[1]&pagename=section', 'top');
  // Once you get working, remove this next line
  $wp_rewrite->flush_rules(false);  
}


//End
add_action('wp_head','odudeshop_ajaxurl');
function odudeshop_ajaxurl() 
{
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<?php
}
//echo time();

/*	
function odude_add_to_cart_subtotal($total)
{
	return $total+100;
}
add_filter( 'odudes_cart_subtotal', 'odude_add_to_cart_subtotal' );
*/




    //auto load default payment mothods
    global $payment_methods;
    $pdir=WP_PLUGIN_DIR."/odudeshop/libs/payment_methods/";
    $methods=scandir($pdir,1);
    //array_shift($methods);
    //array_shift($methods);
    foreach($methods as $method){
        if($method !="." && $method !=".."){
            $payment_methods[]=$method;
            if(file_exists($pdir.$method."/class.{$method}.php")){           
                include_once($pdir.$method."/class.{$method}.php");
            }
        }

    }

    global $sap;//seperator
    if(function_exists('get_option')){
        if ( get_option('permalink_structure') != '' ) $sap = '?';
        else $sap = "&";
    }


    $odudes_plugin = new ahm_plugin('odudeshop');

    function odudes_check_dir()
	{
        if(!file_exists(odudes_UPLOAD_DIR))
		{
            @mkdir(odudes_UPLOAD_DIR,0755);
			
        }
		if(!file_exists(odudes_IMAGE_DIR))
		{
            @mkdir(odudes_IMAGE_DIR,0755);    
		}
        if(!file_exists(odudes_UPLOAD_DIR)) {
            echo '<div class="updated error">
            <p> '.__("Failed to create product dir autometically. You have to create the dir ","odudeshop").' "'.odudes_UPLOAD_DIR.'" '.__("manually.","odudeshop").'</p>
            </div>';
        }
        if(!file_exists(odudes_IMAGE_DIR)) {
            echo '<div class="updated error">
            <p> '.__("Failed to create product image dir autometically. You have to create the dir ","odudeshop").' "'.odudes_IMAGE_DIR.'" '.__("manually.","odudeshop").'</p>

            </div>';
        }
			
    }
	//Adding popup button
	
	// Hooks your functions into the correct filters
function odude_add_mce_button() 
{
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) 
	{
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) 
	{
		add_filter( 'mce_external_plugins', 'odude_add_tinymce_plugin' );
		add_filter( 'mce_buttons', 'odude_register_mce_button' );
	}
}
add_action('admin_head', 'odude_add_mce_button');

// Declare script for new button
function odude_add_tinymce_plugin( $plugin_array ) 
{
	$plugin_array['my_mce_button'] = plugin_dir_url(__FILE__) . 'js/products_button_pop.js';
	return $plugin_array;
}

// Register new button in the editor
function odude_register_mce_button( $buttons ) 
{
	array_push( $buttons, 'my_mce_button' );
	return $buttons;
}
	

	
	
	//Remove wordpress logo
	add_action( 'admin_bar_menu', 'odude_remove_wp_logo', 999 );

function odude_remove_wp_logo( $wp_admin_bar ) 
{
	$wp_admin_bar->remove_node( 'wp-logo' );
}

//Adding menu for user
add_action( 'admin_menu', 'register_odude_user_menu_page' );

function register_odude_user_menu_page() 
{

add_menu_page( 'Track Order Page', 'My Order Page', 'subscriber', 'orders', '',plugins_url().'/odudeshop/images/odude.png', 6 );
  add_menu_page( 'Products in my Cart', 'My Cart', 'subscriber', 'cart', '',plugins_url().'/odudeshop/images/odude.png', 7 );
   add_menu_page( 'Back to Site', 'Back to Site', 'subscriber', '../index.php', '',plugins_url().'/odudeshop/images/odude.png', 8 );

}


	
	//Redirect after urser profile update
	add_action( 'profile_update', 'odude_custom_profile_redirect', 12 );

	function odude_custom_profile_redirect() 
	{
		 $settings = get_option('_odudes_settings');
		wp_redirect( trailingslashit( get_permalink($settings['orders_page_id']) ) );
		exit;
		
	}
	
    function odudes_the_content($content)
	{
        global $post;      
        $settings = get_option('_odudes_settings');    
       
	   if(!is_single()||!isset($settings['generate_product_page_content']))
		return $content;
        
		
		if($post->post_type!='odudeshop')
			return $content;     
        
		@extract(get_post_meta($post->ID,"odudes_list_opts",true)); 
        
		
		
       if( is_singular() && is_main_query() ) 
	   {
		    require_once("layout/product/default.php");
			return odude_product_content($post);
	   }
    }


    //pricing meta box
    function odudes_meta_box_pricing($post)
	{     

        include(dirname(__FILE__).'/tpls/metaboxes/pricing.php');

    }




    //pricing, icon, tax, stock metabox called from here
    function odudes_meta_boxes()
	{
		
		
        $settings = maybe_unserialize(get_option('_odudes_settings'));
		$whatsell='';
		if(isset($settings['whatsell']))  
		$whatsell=$settings['whatsell'];	
		
		if($whatsell=='d')
		{
			$meta_boxes = array(
				'odudes-info'=>array('title'=>__('Pricing & Discounts',"odudeshop"),'callback'=>'odudes_meta_box_pricing','position'=>'normal','priority'=>'low'),
			      'odudes-weight'=>array('title'=>__('Basic Features',"odudeshop"),'callback'=>'odudes_meta_box_weight','position'=>'side','priority'=>'core'),
				'odudes-status'=>array('title'=>__('Product Status',"odudeshop"),'callback'=>'odudes_meta_box_status','position'=>'side','priority'=>'core'),
				'odudes-tab'=>array('title'=>__('ODudeShop Tab',"odudeshop"),'callback'=>'odudes_meta_box_tabs','position'=>'side','priority'=>'core')				
			);

			    

			$meta_boxes = apply_filters("odudes_meta_box", $meta_boxes);
			foreach($meta_boxes as $id=>$meta_box)
			{
				extract($meta_box);
				add_meta_box($id, $title, $callback,'odudeshop', $position, $priority);
			}    
		}
		else
		{
			
				
			$meta_boxes = array(
				'odudes-info'=>array('title'=>__('Pricing & Discounts',"odudeshop"),'callback'=>'odudes_meta_box_pricing','position'=>'normal','priority'=>'low'),
			   'odudes-weight'=>array('title'=>__('Basic Features',"odudeshop"),'callback'=>'odudes_meta_box_weight','position'=>'side','priority'=>'core'),                            
				'odudes-status'=>array('title'=>__('Product Status',"odudeshop"),'callback'=>'odudes_meta_box_status','position'=>'side','priority'=>'core'),
				'odudes-tab'=>array('title'=>__('ODudeShop Tab',"odudeshop"),'callback'=>'odudes_meta_box_tabs','position'=>'side','priority'=>'core')					
			);

			//check the settings to add stock metabox
			if(isset($settings['stock']['enable']) && $settings['stock']['enable']==1)
			{
				$meta_boxes['odudes-stock']=array('title'=>__('Stock',"odudeshop"),'callback'=>'odudes_meta_box_stock','position'=>'side','priority'=>'core'); 
			}                   
			if(isset($settings['purchase']['enable']) && $settings['purchase']['enable']==1)
			{
				$meta_boxes['odudes-qty']=array('title'=>__('Minimum Quantity',"odudeshop"),'callback'=>'odude_meta_box_purchase_min_qty','position'=>'side','priority'=>'core');
			}   
			$meta_boxes = apply_filters("odudes_meta_box", $meta_boxes);
			foreach($meta_boxes as $id=>$meta_box)
			{
				extract($meta_box);
				add_meta_box($id, $title, $callback,'odudeshop', $position, $priority);
			}    
		}
    }
	//***********
	
	
/*   function postSearchRebuild( $query ) 
{
	if ( !is_admin() && $query->is_search ) 
	{
    $custom_fields= array(
        // Put your custom field items to be searched over here.
        "weight"
    );
    $newsearchTerm= $query->query_vars['s'];
  
    $query->query_vars['s'] = "";

    if ($newsearchTerm != "") 
	{
        $meta_query = array('relation' => 'OR');
        foreach($custom_fields as $cfitem) {
            array_push($meta_query, array(
                'key' => $cfitem,
                'value' => $newsearchTerm,
                'compare' => 'LIKE'
            ));
        }
       
		 $query->set('post_type', array( 'post', 'odudeshop' ) );
		 $query->set("meta_query", $meta_query);
		 
	
    }
	}
}
// the filter to modify the search query
add_filter( "pre_get_posts", "postSearchRebuild");  */  

/* //Searching custom fields (Currently not is use)
add_filter( "pre_get_posts", "custom_search_query_one");
 function custom_search_query_one( $query ) 
{
	if ( !is_admin() && $query->is_search ) 
	{
			global $wpdb;

				// If you use a custom search form
				// $keyword = sanitize_text_field( $_POST['keyword'] );

				// If you use default WordPress search form
				$keyword = get_search_query();
				$keyword = '%' . $wpdb->esc_like( $keyword ) . '%'; // Thanks Manny Fleurmond

				// Search in all custom fields
				$post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT post_id FROM {$wpdb->postmeta}
				WHERE meta_value LIKE '%s'
			", $keyword ) );

				// Search in post_title and post_content
				$post_ids_post = $wpdb->get_col( $wpdb->prepare( "
					SELECT DISTINCT ID FROM {$wpdb->posts}
					WHERE post_title LIKE '%s'
					OR post_content LIKE '%s'
				", $keyword, $keyword ) );

				$post_ids = array_merge( $post_ids_meta, $post_ids_post );

				// Query arguments
				$args = array(
					//'post_type'   => array('page', 'post', 'odudeshop'),
					'post_type'   => 'odudeshop',
					'post_status' => 'publish',
					'post__in'    => $post_ids,
					'paged' => max( get_query_var( 'paged' ), 1 ) 	
				);

				$query = new WP_Query( $args );
				//return $query;
				//echo "<pre>";
				//print_r($query);
				//echo "</pre>";
					
			

	}
}  */


//List tabs
 function odudes_meta_box_tabs()
{
	global $post;
        @extract(get_post_meta($post->ID,"odudes_list_opts",true));
		
		if(!isset($odudetab))
			$odudetab="";
	wp_dropdown_categories( 'show_count=1&hierarchical=1&taxonomy=tabcat&name=odudes_list[odudetab]&selected='.$odudetab );
	
}	 
	//
//Purchase Minimum Quantity	
function odude_meta_box_purchase_min_qty()
{
	
	 global $post;
        @extract(get_post_meta($post->ID,"odudes_list_opts",true));
		?>
		<input size="10" type="text" name="odudes_list[qty]" value="<?php if(isset($qty)) echo $qty; else echo 0;?>">
		<?php
}
    //weight metabox
    function odudes_meta_box_weight()
	{
        global $post;
        @extract(get_post_meta($post->ID,"odudes_list_opts",true));
    ?>
	<table border='0' width="100%">
	<tr><td>Key</td><td>Value</td></tr>
	<tr><td><input size="10" type="text" name="odudes_list[weight1]" value="<?php if(isset($weight1)) echo $weight1;?>"> </td><td><input size="10" type="text" name="odudes_list[weight]" value="<?php if(isset($weight)) echo $weight;?>"></td></tr>
	<tr><td><input size="10" type="text" name="odudes_list[pwidth1]" value="<?php if(isset($pwidth1)) echo $pwidth1;?>"> </td><td><input size="10" type="text" name="odudes_list[pwidth]" value="<?php if(isset($pwidth)) echo $pwidth;?>"></td></tr>
	<tr><td><input size="10" type="text" name="odudes_list[pheight1]" value="<?php if(isset($pheight1)) echo $pheight1;?>"> </td><td><input size="10" type="text" name="odudes_list[pheight]" value="<?php if(isset($pheight)) echo $pheight;?>"></td></tr>
</table>
    <?php
    }
	 function odudes_meta_box_status()
	{
        global $post;
        @extract(get_post_meta($post->ID,"odudes_list_opts",true));
    ?>
		<table border='0' width="100%">
		<tr><td> <input type="radio" <?php if($status=="ok" || $status=="") echo "checked='checked'";?> value="ok" name="odudes_list[status]"></td><td><img src="<?php echo plugins_url().'/odudeshop/images/ok.png'; ?>" title="Available"><b> Available</b></td></tr>
	<tr><td> <input type="radio" <?php if($status=="sold") echo "checked='checked'";?> value="sold" name="odudes_list[status]"></td><td><img src="<?php echo plugins_url().'/odudeshop/images/sold.png'; ?>" title="Sold"></td></tr>
	<tr><td> <input type="radio" <?php if($status=="nostock") echo "checked='checked'";?> value="nostock" name="odudes_list[status]"></td><td><img src="<?php echo plugins_url().'/odudeshop/images/nostock.png'; ?>" title="Out Of Stock"></td></tr>
		<tr><td> <input type="radio" <?php if($status=="soon") echo "checked='checked'";?> value="soon" name="odudes_list[status]"></td><td><img src="<?php echo plugins_url().'/odudeshop/images/soon.png'; ?>" title="Comming Soon"></td></tr>
	</table>
	
	<?php
	}
    
    //stock metabox
    function odudes_meta_box_stock()
	{
        global $post;
        @extract(get_post_meta($post->ID,"odudes_list_opts",true)); 
    ?>
    <label ><?php echo __("Manage Stock","odudeshop"); ?></label> <input <?php if($manage_stock==1)echo 'checked="checked"';?> type="checkbox" id="mng_stock" name="odudes_list[manage_stock]" value="1"><br />
    <div id="stk_qty">
        <label ><?php echo __("Stock Quantity","odudeshop"); ?></label><input type="text" name="odudes_list[stock_qty]" value="<?php echo $stock_qty;?>" size="20"> 
    </div>
    <?php
    }

    function odudes_save_meta_data($postid, $post)
	{               
        if(isset($_POST['odudes_list']))
		{ 
            //echo "<pre>"; print_r($_POST['odudes_list']); echo "</pre>"; die();
            update_post_meta($postid,"odudes_list_opts",$_POST['odudes_list']);  
            foreach($_POST['odudes_list'] as $k=>$v)
			{
                update_post_meta($postid,$k,$v);
            }
           

        }
        if(isset($_POST['post_author']))
			{
            $userinfo=get_userdata($_POST['post_author']);

            if($userinfo->roles[0]!="administrator"){
                if($_POST['original_post_status']=="draft" && $_POST['post_status']=="publish"){
                    global $current_user; 
                    $siteurl=home_url("/");
                    $admin_email=get_bloginfo("admin_email");
                    $to= $userinfo->user_email; //post author
                    $from= $current_user->user_email;
                    $link=get_permalink($post->ID);
                    $message="Your product {$post->post_title} {$link} is approved to {$siteurl} ";
                    $email['subject']=$subject;
                    $email['body']=$message;
                    $email['headers'] = 'From:  <'.$from.'>' . "\r\n";
                    $email = apply_filters("product_approval_email", $email);            
                    wp_mail($to,$email['subject'],$email['body'],$email['headers']);
                    //wp_mail($admin_email,$email['subject'],$email['body'],$email['headers']);
                }
            }
        }
    }

    //ODudeShop settings
    function odudes_settings()
	{ 
        include("settings/settings.php");
    }
	    //ODudeShop Dashboard
    function odudes_dashboard()
	{ 
        include("settings/dashboard.php");
    }
    //orders list section
    function odudes_orders()
	{ 
        $order1 = new Order();
        global $wpdb;
        //$wpdb->show_errors();
        $l = 15;
        $currency_sign = get_option('_odudes_curr_sign','$');
        //if(isset($_GET['paged'])) {
        $p = isset($_GET['paged'])?$_GET['paged']:1;
        $s = ($p-1)*$l;
        //}
//        echo "<pre>";
//        print_r($_REQUEST);
//        echo "</pre>";
        if(isset($_GET['task']) && $_GET['task']=='vieworder'){
            $order = $order1->getOrder($_GET['id']);
//                echo "<pre>";
//                print_r($order);
//                echo "</pre>";
            include('tpls/view-order.php');        
        }
        
        else {
            if(isset($_GET['task']) && $_GET['task']=='delete_order'){
                $order_id  = esc_attr($_GET['id']);
                $ret = $wpdb->query( 
                $wpdb->prepare( 
                        "
                        DELETE FROM {$wpdb->prefix}os_orders
                         WHERE order_id = %s
                        ",
                        $order_id 
                            )
                    );
                if($ret){
                    //echo $ret;
                    $ret = $wpdb->query(
                    $wpdb->prepare( 
                        "
                        DELETE FROM {$wpdb->prefix}os_order_items
                         WHERE oid = %s
                        ",
                        $order_id 
                            )
                    );
                   //echo $ret;
                   if($ret) $msg = "Record Deleted for Order ID $order_id...";     
                }        
                
            }
            else if(isset($_GET['delete_selected'],$_GET['delete_confirm']) && $_GET['delete_confirm']==1 ){
                $order_ids = $_GET['id'];
                if(!empty($order_ids) && is_array($order_ids)){
                    foreach($order_ids as $key => $order_id){
                        $order_id  = esc_attr($order_id);
                        $ret = $wpdb->query( 
                        $wpdb->prepare( 
                                "
                                DELETE FROM {$wpdb->prefix}os_orders
                                 WHERE order_id = %s
                                ",
                                $order_id 
                                    )
                            );
                        if($ret){
                            //echo $ret;
                            $ret = $wpdb->query(
                            $wpdb->prepare( 
                                "
                                DELETE FROM {$wpdb->prefix}os_order_items
                                 WHERE oid = %s
                                ",
                                $order_id 
                                    )
                            );
                           //echo $ret;
                           if($ret) $msg[] = "Record Deleted for Order ID $order_id...";     
                        }
                    }
                }
            }
            else if(isset($_GET['delete_by_payment_sts'],$_GET['delete_all_by_payment_sts']) && $_GET['delete_all_by_payment_sts']!= "" ){
                $payment_status = esc_attr($_GET['delete_all_by_payment_sts']);
                
                $order_ids = $wpdb->get_results( 
                                "
                                SELECT order_id 
                                FROM {$wpdb->prefix}os_orders
                                WHERE payment_status = '$payment_status'
                                "
                        ,ARRAY_A);
                if($order_ids)
				{
                    foreach($order_ids as $row)
					{
                        //print_r($row);
                        $order_id  = $row['order_id'];
                       
					   $ret = $wpdb->query( 
                        $wpdb->prepare( 
                                "
                                DELETE FROM {$wpdb->prefix}os_orders
                                 WHERE order_id = %s
                                ",
                                $order_id 
                                    )
                            );
                        if($ret)
						{
                            //echo $ret;
                            $ret = $wpdb->query(
                            $wpdb->prepare( 
                                "
                                DELETE FROM {$wpdb->prefix}os_order_items
                                 WHERE oid = %s
                                ",
                                $order_id 
                                    )
                            );
                           //echo $ret;
                           if($ret) $msg[] = "Record Deleted for Order ID $order_id...";     
                        }
                    }
                }
                
                
            }
            
            
            //$wpdb->print_error();
            if(isset($_REQUEST['oid']) && $_REQUEST['oid'])    
                $qry[] = "order_id='$_REQUEST[oid]'" ;   
            if(isset($_REQUEST['ost']) && $_REQUEST['ost'])    
                $qry[] = "order_status='$_REQUEST[ost]'" ;   
            if(isset($_REQUEST['pst']) && $_REQUEST['pst'])
                $qry[] = "payment_status='$_REQUEST[pst]'";    
            if(isset($_REQUEST['sdate'],$_REQUEST['edate']) && ($_REQUEST['sdate']!=''||$_REQUEST['edate']!='')){
                $_REQUEST['edate'] = $_REQUEST['edate']?$_REQUEST['edate']:$_REQUEST['sdate'];
                $_REQUEST['sdate'] = $_REQUEST['sdate']?$_REQUEST['sdate']:$_REQUEST['edate'];
                $sdate = strtotime("$_REQUEST[sdate] 00:00:00");
                $edate = strtotime("$_REQUEST[edate] 23:59:59");
                $qry[] = "(`date` >=$sdate and `date` <=$edate)";
            }

            if(isset($qry))
                $qry = "where ".implode(" and ", $qry);
            else $qry = "";
            $t = $order1->totalOrders($qry); 
            $orders = $order1->GetAllOrders($qry,$s, $l);
            include('tpls/orders.php');    
        }
    }
    //fronend orders list 
    function odudes_myorders($content)
	{
        global $current_user, $_ohtml;
        get_currentuserinfo();
        $order = new Order();         
        $myorders = $order->GetOrders($current_user->ID);
        $_ohtml = '';        
        include('tpls/orders_purchases.php');
        $content = str_replace('[my-orders]',$_ohtml, $content);
        return $content;

    }

    //frontend user profile
    function odudes_user_order(){ 
        global $current_user, $_ohtml;
        get_currentuserinfo();
        $order = new Order();         
        $myorders = $order->GetOrders($current_user->ID);
        $_ohtml = '';  
        $dashboard = true;
        include('tpls/orders_purchases.php');
        return $_ohtml;
    }


    function odudes_set_post_type( $query ) {  
        if(!is_admin()){
            if(!is_page())
                $query->set( 'post_type', array('post','odudeshop'));         
            else
                $query->set( 'post_type', array('post','odudeshop','page'));         
        }
        return $query;
    } 

    
    function odudes_extension_styles()
	{
      //  wp_enqueue_style('odude-shop', plugins_url() . '/odudeshop/bootstrap/css/bootstrap.css');
     //   wp_enqueue_style('wp-extends-css', plugins_url() . '/odudeshop/css/extends_page.css');
    }
    
    function odudes_extension_scripts()
	{
     
    }

    //menus for the ODudeShop
    function odudes_menu()
	{     
      
	  
		add_submenu_page( 'edit.php?post_type=odudeshop', __('List Orders &lsaquo; ODudeShop',"odudeshop"), __('Order',"odudeshop"), 'manage_options', 'order', 'odudes_orders');    
        add_submenu_page( 'edit.php?post_type=odudeshop', __('Settings &lsaquo; ODudeShop',"odudeshop"), __('Settings',"odudeshop"), 'manage_options', 'settings', 'odudes_settings');    
		  add_submenu_page( 'edit.php?post_type=odudeshop', __('Dashboard &lsaquo; ODudeShop',"odudeshop"), __('Dashboard',"odudeshop"), 'manage_options', 'dashboard', 'odudes_dashboard');    

    }

   
    //admin settings options save
    function odudes_save_settings()
	{
        
        //remove odudeshop capabilities
        global $wp_roles; // global class wp-includes/capabilities.php
        $cap = 'odudeshop_user';
        $roles = $wp_roles->get_names(); // administrator => Adminis...
        foreach($roles as $key => $value){
            $wp_roles->remove_cap( $key,  $cap);
        }
        //now add roles
		if(isset($_POST['_odudes_settings']['user_role']))
        $user_role = $_POST['_odudes_settings']['user_role'];
        if(!empty($user_role)):
            foreach($user_role as $key => $value){
                $role = get_role( $value );
                $role->add_cap( $cap ); 
            }
            endif;
        //$_POST['']

        update_option('_odudes_settings',$_POST['_odudes_settings']);  
        //
        die(__('Settings Saved Successfully',"odudeshop"));
    }

    function odudes_download(){    
        $get_file = isset($_GET['odudefile']) ? (int) $_GET['odudefile'] : 0 ;
        if(!$get_file) return;
        global $wpdb, $current_user;
        get_currentuserinfo();
        $order = new Order();
        $odata = $order->GetOrder($_GET['oid']);
        $items = unserialize($odata->items);    
        $meta = get_post_meta($get_file,"odudes_list_opts",true);

        @extract($meta);

        $post = get_post($get_file);

        if($base_price==0 && $get_file>0){      
            //product jodi free hoi...
            include("libs/process.php");
        }
        if(@in_array($get_file,$items) && $_GET['oid'] != '' && is_user_logged_in() && $current_user->ID == $odata->uid && $odata->payment_status=='Completed'){   
            //product jodi non free hoi
            @extract(get_post_meta($get_file,"odudes_list_opts",true));
            include("libs/process.php");
        }
    }
    //logging in the user from frontend
    function odudes_do_login(){
        if(isset($_POST['checkout_login_nonce']) && check_ajax_referer('checkout_login_form','checkout_login_nonce', false)){
            if((isset($_REQUEST['checkout_login']) && $_REQUEST['checkout_login']=="login") || (isset($_POST['login_form']) && $_POST['login_form']=="login")):
                global $wp_query, $post, $sap;      
                if(!$_POST['login']) return;
                unset($_SESSION['login_error']);
                the_post();
                $creds = array();
                $creds['user_login'] = $_POST['login']['log'];
                $creds['user_password'] = $_POST['login']['pwd'];
                $creds['remember'] = $_POST['rememberme'];
                $user = wp_signon( $creds, false );
                if ( is_wp_error($user) ){                
                    $_SESSION['login_error'] = $user->get_error_message();
                    //header("location: ".$_POST['permalink'].$sap.'task=login');
                    if($_REQUEST['login_form']=="login") header("location: ".$_POST['permalink']);
                    die("failed");
                } else {
                    //header("location: ".$_POST['permalink']); 
                    if($_REQUEST['login_form']=="login") header("location: ".$_POST['permalink']);
                    echo 'success';
                    die();
                }
            endif;
        }
    }
    //registering from the frontend
    function odudes_do_register(){
        if(isset($_POST['checkout_register_nonce']) && check_ajax_referer('checkout_register_form','checkout_register_nonce', false)){
            if((isset($_REQUEST['checkout_register']) && $_REQUEST['checkout_register']=="register") || (isset($_POST['register_form']) && $_POST['register_form']=="register")):           
                global $wp_query, $sap;
                if(!$_POST['reg'])  die("error");;
                extract($_POST['reg']);

                $_SESSION['tmp_reg_info'] = $_POST['reg'];    
                $user_id = username_exists( $user_login );
                if($user_login==''){
                    $_SESSION['reg_error'] =  __('Username is Empty!');                     
                    die($_SESSION['reg_error']);
                }
                if($user_email==''||!is_email($user_email)){
                    $_SESSION['reg_error'] =  __('Invalid Email Address!');        
                    die($_SESSION['reg_error']);
                }
                if ( !$user_id ) {
                    $user_id = email_exists( $user_email );
                    if ( !$user_id ) {
                        //$user_pass = wp_generate_password( 12, false );
                        //echo $user_pass;
                        $user_id = wp_create_user( $user_login, $user_pass, $user_email );
                        $email = get_option('admin_email');
                        $headers = "From: ".get_bloginfo('sitename')." <$email>\r\nContent-type: text/html";
                        $message = "Hello $user_login,<br/>\r\nThanks for registering to ".get_bloginfo('sitename')."<br/>Here is your login info:<br/>\r\nUsername: $user_login<br/>\r\nPassword: $user_pass<br/>\r\n<br/>\r\nThanks<br/><b>".get_bloginfo('sitename')."</b>";
                        //echo $user_id;
                        if($user_id){
                            wp_mail($user_email,"Welcome to ".get_bloginfo('sitename'),$message,$headers);
                            unset($_SESSION['tmp_reg_info']);
                            unset($_SESSION['login_error']);
                            $creds = array();
                            $creds['user_login'] = $user_login;
                            $creds['user_password'] = $user_pass;
                            $creds['remember'] = "forever";
                            $user = wp_signon( $creds, false );
                            //echo $user->get_error_message();exit;
                            if ( is_wp_error($user) ){                
                                $_SESSION['login_error'] = $user->get_error_message();                
                                //if(isset($_REQUEST['wpmpnrd'])) 
                                    die("failed");
                                //else
                                //    header("location: ".$_POST['permalink']); 
                            } else {                              
                               // if(isset($_REQUEST['wpmpnrd'])) 
                                    die("success");
                                //else
                                //    header("location: ".$_POST['permalink']); 
                            }

                        }
                        //header("location: ".$_POST['permalink'].$sap.'task=login'); 
                        die();
                    } else {
                        $_SESSION['reg_error'] =  __('Email already exists.');        
                        //header("location: ".$_POST['permalink'].$sap.'task=register');
                        die($_SESSION['reg_error']);
                    }
                } else {
                    $_SESSION['reg_error'] =  __('User already exists.');        
                    //header("location: ".$_POST['permalink'].$sap.'task=register');
                    die($_SESSION['reg_error']);
                }

            endif;
        }
    }
    
    //saving billing info from checkout process 
    function odudes_save_billing_info()
	{
        if(isset($_REQUEST['checkout_billing']) && $_REQUEST['checkout_billing']=="save")
		{
            global $current_user;
            get_currentuserinfo();
            $order = new Order();
            if(isset($_SESSION['orderid']))
			{
                $order_info=$order->GetOrder($_SESSION['orderid']);
                if($order_info->order_id)
				{
                    $data=array(
                        'billing_shipping_data'=>serialize($_POST['checkout']),        
                        'cart_data'=>serialize(odudes_get_cart_data()),        
                        'items'=>serialize(array_keys(odudes_get_cart_data()))        
                    ); 
                    $order->UpdateOrderItems(odudes_get_cart_data(),$_SESSION['orderid']); 
                    $insertid = $order->Update($data, $_SESSION['orderid']);
                }
				else
				{
                    $cart_data = serialize(odudes_get_cart_data());
                    $items=serialize(array_keys(odudes_get_cart_data()));
                    //print_r($cart_data);
                    $insertid=$order->NewOrder($_SESSION['orderid'], "", $items, 0,$current_user->ID,'Pending','Pending',$cart_data,"","","",0.0,serialize($_POST['checkout']));
                    $order->UpdateOrderItems($cart_data,$_SESSION['orderid']);
                }
            }
			else
			{
                $cart_data = serialize(odudes_get_cart_data());
                $items=serialize(array_keys(odudes_get_cart_data()));
                $insertid=$order->NewOrder(uniqid(), "", $items, 0,$current_user->ID,'Processing','Processing',$cart_data,"","","",0.0,serialize($_POST['checkout']));            
                $_SESSION['orderid']=$insertid;
                $order->UpdateOrderItems($cart_data,$_SESSION['orderid']); 
            }
            update_user_meta($current_user->ID, 'user_billing_shipping', serialize($_POST['checkout']));        
            include_once("layout/checkout/shipping_method.php");
            die();
        }
    }
    //saving shipping info from checkout process 
    function odudes_save_shipping_info()
	{
        if(isset($_REQUEST['checkout_shipping']) && $_REQUEST['checkout_shipping']=="save"){
            global $current_user;
            get_currentuserinfo();
            $data=array(
                'shipping_method'=>$_POST['shipping_method'],
                'shipping_cost'=>$_POST['shipping_rate']
            );
            $order = new Order();
            $od = $order->Update($data, $_SESSION['orderid']);
            $order_total= $order->CalcOrderTotal($_SESSION['orderid']);
            $shipping = odudes_calculate_shipping();
            $order_total = $order_total + $shipping['cost'];
            if($order_total>0)
                include_once("layout/checkout/payment_method.php");
            else {
                $order_info=$order->GetOrder($_SESSION['orderid']);
                include_once("layout/checkout/order_review.php");
            }
            die();
        }
    }
    //saving payment method info from checkout process 
    function odudes_save_payment_method_info()
	{
        if(isset($_REQUEST['checkout_payment']) && $_REQUEST['checkout_payment']=="save"){
            global $current_user;
            get_currentuserinfo();

            $data=array(
                'payment_method'=>$_POST['payment_method']        
            );
            $order = new Order();
            $od=$order->Update($data, $_SESSION['orderid']);
            $order_info=$order->GetOrder($_SESSION['orderid']);
            include_once("layout/checkout/order_review.php"); 
            die();
        }
    } 
	
	function odude_cart_for_nouser()
	{
		$current_user=$_SESSION["uid"];
           // get_currentuserinfo();
            $order = new Order();
            if($_SESSION['orderid'])
			{
                $order_info=$order->GetOrder($_SESSION['orderid']);
                if($order_info->order_id)
				{
                    $data=array(
                        'billing_shipping_data'=>serialize($_POST['checkout']),        
                        'cart_data'=>serialize(odudes_get_cart_data()),        
                        'items'=>serialize(array_keys(odudes_get_cart_data()))        
                    ); 
                    $order->UpdateOrderItems(odudes_get_cart_data(),$_SESSION['orderid']); 
                    $insertid = $order->Update($data, $_SESSION['orderid']);
                }
				else
				{
                    $cart_data = serialize(odudes_get_cart_data());
                    $items=serialize(array_keys(odudes_get_cart_data()));
                    //print_r($cart_data);
                    $insertid=$order->NewOrder($_SESSION['orderid'], "", $items, 0,$current_user,'Processing','Processing',$cart_data,"","","",0.0,serialize($_POST['checkout']));
                    $order->UpdateOrderItems($cart_data,$_SESSION['orderid']);
                }
            }
			else
			{
                $cart_data = serialize(odudes_get_cart_data());
                $items=serialize(array_keys(odudes_get_cart_data()));
                $insertid=$order->NewOrder(uniqid(), "", $items, 0,$current_user,'Processing','Processing',$cart_data,"","","",0.0,serialize($_POST['checkout']));            
                $_SESSION['orderid']=$insertid;
                $order->UpdateOrderItems($cart_data,$_SESSION['orderid']); 
            }
            update_user_meta($current_user, 'user_billing_shipping', serialize($_POST['checkout']));        
            
            
	}
	
	
	
	//Checking if user already in database, if not create a new one.
	 function odudes_check_user()
	{
        if(isset($_REQUEST['checkout_user']) && $_REQUEST['checkout_user']=="save"){
            

            $data=array(
                'billing_first_name'=>$_POST['billing_first_name'],
				'billing_last_name'=>$_POST['billing_last_name'] ,
				'billing_email'=>$_POST['billing_email'] 				
            );
            //echo "Searchig for user ".$data['billing_email'];
			//print_r($data);
			
			
			$user = get_user_by( 'email', $data['billing_email'] );
			session_start();
			if($user->id=='')
			{
				//echo "No user found<br>";
				$user_id = username_exists( $data['billing_email'] );
				$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
				
				if ( !$user_id and email_exists($user_email) == false )
				{
				//$user_id = wp_create_user( $data['billing_email'], $random_password, $data['billing_email'] );
				
				$userdata = array(
								'user_login'  =>  $data['billing_email'],
								'user_pass'   =>  $random_password,
								'user_email'  =>  $data['billing_email'],
								'first_name'  =>  $data['billing_first_name'],
								'last_name'    =>  $data['billing_last_name']
								);

				$user_id = wp_insert_user( $userdata ) ;

				$_SESSION["uid"] = $user_id;
				$_SESSION["msg"] = "Please login as ".$data['billing_email']." and password is ".$random_password." to track your order status.";
				
				//echo "new user id is".$user_id;
				}
				else
				{
					echo "Error during registgratoin.";
					die();
				}
			}
			else
			{
				//echo 'User is ' . $user->first_name . ' ' . $user->last_name.' '.$user->id;
				$_SESSION["uid"] = $user->id;
				$_SESSION["msg"] = "Please login as ".$data['billing_email']." to track your order status.";
				
			}
			odude_cart_for_nouser();
			 include_once("layout/checkout/shipping_method.php");
			
            die();
        }
    } 
    //placing order from checkout process 
    function odudes_place_order()
	{
        if(isset($_REQUEST['wpmpaction']) && $_REQUEST['wpmpaction']=='placeorder')
		{
            //save 

            $order = new Order();          
            $order_total= $order->CalcOrderTotal($_SESSION['orderid']);
            $data=array(
                'order_notes'=>$_POST['order_comments'],
                'total' => $order_total
            );
            $od = $order->Update($data, $_SESSION['orderid']);
            //update order items
            $order->UpdateOrderItems(serialize($_POST['cart_items']), $_SESSION['orderid']);
            // If order total is not 0 then go to payment gateway
            do_action('odudes_before_placing_order',$_SESSION['orderid']);
            if($order_total>0)
			{
                $payment = new Payment();
                $payment->InitiateProcessor($_POST['payment_system']);
                $payment->Processor->OrderTitle = 'Order# '.$_SESSION['orderid'];
                $payment->Processor->InvoiceNo = $_SESSION['orderid'];
                $payment->Processor->Custom = $_SESSION['orderid'];
                $payment->Processor->Amount = $order_total;
				$_SESSION['oid_for_nouser']=$_SESSION['orderid'];
                odudes_empty_cart();
                echo $payment->Processor->ShowPaymentForm(1);
            } 
			else 
			{

                // if order total is 0 then complete order immediately
                order::complete_order($_SESSION['orderid']);
				$_SESSION['oid_for_nouser']=$_SESSION['orderid'];
                odudes_empty_cart(); 
                odudes_js_redirect(odudes_orders_page());
            }
            odudes_empty_cart(); 
            die();
        }
    }
    //payment notification process
    function odudes_payment_notification()
	{
        if(isset($_REQUEST['action']) && $_REQUEST['action']=="odudes-payment-notification")
		{
            include_once(WP_PLUGIN_DIR."/odudeshop/libs/payment_methods/".$_REQUEST['class']."/class.".$_REQUEST['class'].".php");
            $payment_method=new $_REQUEST['class']();
            if($payment_method->VerifyNotification())
			{
                global $wpdb;              
                order::complete_order($payment_method->order_id);   
				echo "Order Completed ".$payment_method->order_id;
            }

        }
    }

    //withdraw money from paypal noti
   
    //payment using ajax
    function odudes_ajax_payfront(){
        if(isset($_POST['task'],$_POST['action']) && $_POST['task']=="paymentfront" && $_POST['action']=="odudes_ajax_call"){
            $data['order_id']=$_POST['order_id'];
            $data['payment_method']=$_POST['payment_method'];

            PayNow($data);
            die();
        }
    }

    function odudes_ajax_call(){
        if(function_exists($_POST['execute'])){
            echo call_user_func($_POST['execute']);
            die();
        }
    }
      
    
    function odudes_plu_admin_enqueue() {
        wp_enqueue_script('plupload-all'); 
    }

    function plupload_admin_head() {
        // place js config array for plupload
        $plupload_init = array(
            'runtimes' => 'html5,silverlight,flash,html4',
            'browse_button' => 'plupload-browse-button', // will be adjusted per uploader
            'container' => 'plupload-upload-ui', // will be adjusted per uploader
            'drop_element' => 'drag-drop-area', // will be adjusted per uploader
            'file_data_name' => 'async-upload', // will be adjusted per uploader
            'multiple_queues' => true,
            'max_file_size' => wp_max_upload_size() . 'b',
            'url' => admin_url('admin-ajax.php'),
            'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
            'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
            'filters' => array(array('title' => __('Allowed Files'), 'extensions' => '*')),
            'multipart' => true,
            'urlstream_upload' => true,
            'multi_selection' => false, // will be added per uploader
            // additional post data to send to our ajax hook
            'multipart_params' => array(
                '_ajax_nonce' => "", // will be added per uploader
                'action' => 'plupload_action', // the ajax action name
                'imgid' => 0 // will be added per uploader
            )
        );
    ?>
    <script type="text/javascript">
        var base_plupload_config=<?php echo json_encode($plupload_init); ?>;
        var pluginurl = "<?php echo plugins_url("odudeshop/"); ?>";
        var odudes_image_url = "<?php echo odudes_IMAGE_URL; ?>";
    </script>
    <?php
    }
    function g_plupload_action() {

        // check ajax noonce
        $imgid = $_POST["imgid"];
        check_ajax_referer($imgid . 'pluploadan');

        // handle file upload
        $status = wp_handle_upload($_FILES[$imgid . 'async-upload'], array('test_form' => true, 'action' => 'plupload_action'));

        // send the uploaded file url in response
        echo $status['url'];
        exit;
    }


    function odudes_move_upload_previewfile(){
        $adpdir = odudes_IMAGE_DIR;
        $uploads = wp_upload_dir();
        $tempFile=$uploads['basedir'].str_replace("uploads","",strstr($_POST['fileurl'],"uploads"));
        $filename=basename($_POST['fileurl']);
        $fname="odudes-adp-". time().'-'.$filename;
        $targetFile =  $adpdir.$fname;
        rename($tempFile, $targetFile);
        die($fname);
    }

    function odudes_move_upload_productfile(){
        $adpdir = odudes_UPLOAD_DIR;
        $uploads = wp_upload_dir();
        $tempFile=$uploads['basedir'].str_replace("uploads","",strstr($_POST['fileurl'],"uploads"));
        $filename=basename($_POST['fileurl']);
        $fname="odudes-p-". time().'-'.$filename;
        $targetFile =  $adpdir.$fname;
        rename($tempFile, $targetFile);
        die($fname);
    }

    function odudes_edit_profile(){
        include(dirname(__FILE__).'/layout/profile/edit-profile.php');
    }
    function odudes_my_orders(){

    }

    function odudes_move_upload_featuredfile(){

        die($_POST['fileurl']);
    }

    function odudes_update_profile(){
        global $current_user;
        if(!is_user_logged_in()||!isset($_POST['profile'])) return;

        $userdata = $_POST['profile'];
        $userdata['ID'] = $current_user->ID;
        if($_POST['password']==$_POST['cpassword']){
            wp_update_user($userdata);
            $userdata['user_pass'] = $_POST['password'];
            update_user_meta($current_user->ID, 'payment_account',$_POST['payment_account']);
            update_user_meta($current_user->ID, 'phone',$_POST['phone']);
            $_SESSION['member_success'] = __("Profile Updated Successfully","odudeshop");

        } else {
            $_SESSION['member_error'][] = __("Confirm Password Not Matched. Profile Update Failed!","odudeshop");
        }
        update_user_meta($current_user->ID, 'user_billing_shipping', serialize($_POST['checkout']));

        odudes_redirect($_SERVER['HTTP_REFERER']);
        die();

    }

    //auto sugession function
    function odudes_autosuggest()
	{
        if($_REQUEST['tag']){
            global $wpdb;
            $featured_products=$wpdb->get_results("select * from  {$wpdb->prefix}posts p  where p.post_type='odudeshop' and p.post_title like '%{$_REQUEST['tag']}%' and p.post_status='publish' ");

            $rtn="[";
            foreach($featured_products as $value){
                $fp[] = array('key'=>$value->ID, 'value'=>$value->post_title);
            }

            echo json_encode($fp);
            die(); 
        } 
    }

    function odudes_remove_featured(){
        if($_POST['id']){
            global $wpdb;
            $wpdb->query("delete from {$wpdb->prefix}os_feature_products where id='{$_POST['id']}'");
            die();
        }
    }

    //default currency saving function
    function odudes_default_currency(){
        update_option('_odudes_curr_key',$_POST['currency_key']);  
        update_option('_odudes_curr_name',$_POST['currency_name']);  
        update_option('_odudes_curr_sign',$_POST['currency_value']);  
        die("success");    
    }

    //default currency delete
    function odudes_default_currency_del(){
        $cur_key = get_option('_odudes_curr_key');
        if($cur_key == $_POST['currency_key']){
            delete_option('_odudes_curr_key');
            delete_option('_odudes_curr_name');
            delete_option('_odudes_curr_sign');
        }
    }
	

    function odudes_enqueue_scripts()
	{
        global $odudes_plugin,$current_screen;
		
       wp_enqueue_script('jquery');
       wp_enqueue_script('jquery-form');
       wp_enqueue_script('jquery-ui-core');
       wp_enqueue_script('jquery-ui-datepicker'); 
       wp_enqueue_script('jquery-ui-tabs');// enqueue jQuery UI Tabs
	   wp_enqueue_script('jquery-ui-accordion');
	  
	
//wp_register_style('wpb-jquery-ui-style', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', false, null);
//wp_enqueue_style('wpb-jquery-ui-style');
//wp_register_script('wpb-custom-js', plugins_url('/js/site/accordion.js', __FILE__ ), array('jquery-ui-accordion'), '', true);
//wp_enqueue_script('wpb-custom-js');


		
        $settings = get_option('_odudes_settings'); 
        if((is_admin() && $current_screen->post_type=="odudeshop")||(!is_admin() && !isset($settings['disable_fron_end_css'])))
		{
          
        wp_enqueue_style('odude-shop-pure', plugins_url() . '/odudeshop/css/pure-min.css');
		  wp_enqueue_style('font-awesome-css','https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
		 wp_enqueue_style('odude-shop-pure-grid', plugins_url() . '/odudeshop/css/grids-responsive-min.css');
		 wp_enqueue_style('jquery-ui-style','//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
	   }
	   
        $odudes_plugin->load_styles();
        $odudes_plugin->load_scripts();


    }

    function odudes_init(){
        add_theme_support('post-thumbnails');
    }

    function add_zip_profile_fields( $user ) {
        // add extra zip fields to user edit page

    ?>

    <table class="form-table">
        <tr><th>Zip/Postal Code</th>
            <td>

                <?php
                    $user_zip = get_user_meta($user->ID,"user_zip",true);


                ?>
                <input type="text" name="user_zip" value="<?php echo $user_zip;?>">
            </td>
        </tr>
    </table>
    <?php
    }

    function save_userzip_data($user_id, $old_user_data){
        update_user_meta($user_id, 'user_zip', $_POST['user_zip']);
    }


    register_activation_hook(__FILE__,'odudes_install');
    $odudes_plugin->load_modules();  
   

//Thease function will be used by developers to add extra tabs
/* function odude_add_tab_title($fruits) 
{
 
	$extra_fruits = array(
		'plums',
		'kiwis'
	);
 
	// combine the two arrays
	$fruits = array_merge($fruits,$extra_fruits);
	return $fruits;
}
add_filter('odude_add_tab_title', 'odude_add_tab_title');

function odude_add_tab_content($fruits) 
{
 
	$extra_fruits = array(
		'pluuuuuuuu',
		'zzzzzzzzzzzzzz'
	);
 
	// combine the two arrays
	$fruits = array_merge($fruits,$extra_fruits);
 
	return $fruits;
}
add_filter('odude_add_tab_content', 'odude_add_tab_content');
 */
