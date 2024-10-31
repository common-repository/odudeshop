<?php
//Getting user role name
	function odudeshop_current_user_role() 
	{
	global $wp_roles;
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);
	return $role;
	//return isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
}

//Adding facebook image meta tag for product page
function odude_metatag_facebook_head() 
{
	if(get_post_type( get_the_ID() )=='odudeshop')
	{
		
	echo '<meta property="og:image" content="'.generateThumbnail_postid('large').'" />';
	}

}

//number of total sales
function odudes_total_purchase($pid=''){
     global $wpdb;
     if(!$pid) $pid = get_the_ID();
     $sales = $wpdb->get_var("select count(*) from {$wpdb->prefix}os_orders o, {$wpdb->prefix}os_order_items oi where oi.oid=o.order_id and oi.pid='$pid' and o.payment_status='Completed'");
     return $sales;
}



function odudes_weightndim($content)
{
    global $post;
    $pinf = get_post_meta($post->ID, 'odudes_list_opts', true);
    if(isset($pinf['digital_activate'])||$pinf['weight']=='') return $content;
    $dim = ""; //"<h3>".__('Product Info')."</h3>";
    $dim .= "<table class='table'>";
    $dim .= "<tr><td>{$pinf['weight1']}</td><td>{$pinf['weight']}</td></tr>";
	if($pinf['pwidth']!='')
    $dim .= "<tr><td>{$pinf['pwidth1']}</td><td>{$pinf['pwidth']}</td></tr>";
	if($pinf['pheight']!='')
    $dim .= "<tr><td>{$pinf['pheight1']}</td><td>{$pinf['pheight']}</td></tr>";
    $dim .= "</table>";
    return $dim.$content;
}
 
  
 //count the total number of product
 function total_product(){
   global $wpdb;
   $total_product=$wpdb->get_var("select count(ID) from {$wpdb->prefix}posts where post_type='odudeshop' and post_status='publish'");
   return $total_product;  
 }

 


 function odudes_redirect($url){
     if(!headers_sent())
         header("location: ". $url);
     else
         echo "<script>location.href='{$url}';</script>";
     die();
 }
 function odudes_js_redirect($url){

         echo "&nbsp;Redirecting...<script>location.href='{$url}';</script>";
     die();
 }


 function odudes_members_page(){
     $settings = get_option('_odudes_settings');
     return get_permalink($settings['members_page_id']);
 }
 
  function odudes_orders_page(){
     $settings = get_option('_odudes_settings');
     return get_permalink($settings['orders_page_id']);
  }






function odudes_product_price($pid)
{
    $pinfo = get_post_meta($pid,"odudes_list_opts",true);
    $expire = FALSE;
    if(isset($pinfo['sales_price_expire'])) {
        
        $today = strtotime(date('Y-m-d'));
        $end_date = strtotime($pinfo['sales_price_expire']);
        if($end_date<=$today){
            $expire = true;
        }
    }
    
		if($pinfo['sales_price']=='')
			$pinfo['sales_price']=0;
			if($pinfo['base_price']=='')
			$pinfo['base_price']=0;	
		
    $price = floatval($pinfo['sales_price'])>0 && $pinfo['sales_price']<$pinfo['base_price'] && $expire==FALSE ?$pinfo['sales_price']:$pinfo['base_price'];
    return number_format($price,2,".","");
}

function odudes_addtocart_link($id)
{
	$sys_settings = maybe_unserialize(get_option('_odudes_settings'));
    $pinfo = get_post_meta($id,"odudes_list_opts",true);
    @extract($pinfo);
    $settings = isset($pinfo['settings'])?$pinfo['settings']:array();
    $cart_enable="";
	if(!isset($sys_settings['instant_download']))
		$sys_settings['instant_download']=0;
	
    if($sys_settings['instant_download']==1 && ($pinfo['base_price']=='' || $pinfo['base_price']=='0.00') && $pinfo['digital_activate']==1)
	{
		return '<a href="'.home_url('/?odudefile='.$id).'" class="button-secondary pure-button"><i class="fa fa-download"></i> '.__('Download','odudeshop').'</a>';
	}
	else
	{
		//echo $sys_settings['instant_download']."-".$pinfo['base_price']."-".$pinfo['digital_activate'];
		
    if(isset($settings['stock']['enable'])&&$settings['stock']['enable']==1)
	{
        if($manage_stock==1)
		{
            if($stock_qty>0)$cart_enable=""; else $cart_enable=" disabled ";
        }
    }
	if($pinfo['status']!="ok")
	$cart_enable=" disabled ";
	
		
    $cart_enable = apply_filters("odudes_cart_enable", $cart_enable,$id);
    
    if(isset($pinfo['price_variation'])&&$pinfo['price_variation'])
	{
        $html = "<a href='".get_permalink($id)."' class='pure-button'><i class=\"fa fa-search-plus\"></i> ".__("Select Options","odudeshop")."</a>";
	}
   else
	{
        $html = <<<PRICE
                        <form method="post" action="" name="cart_form" class="cart_form">
                        <input type="hidden" name="add_to_cart" value="add">
                        <input type="hidden" name="pid" value="$id">
                         

PRICE;
        $html.='<button '.$cart_enable.' class="pure-button pure-button-primary" type="submit" > <i class="fa fa-plus-square-o"></i> '.__("Add to Cart","odudeshop").'</button></form>';

    }
    return $html;
	}
}
function odudes_addtoenquiry_link($id)
{
    $pinfo = get_post_meta($id,"odudes_list_opts",true);
    @extract($pinfo);
    $settings = isset($pinfo['settings'])?$pinfo['settings']:array();
    $cart_enable="";
    
    if(isset($settings['stock']['enable'])&&$settings['stock']['enable']==1){
        if($manage_stock==1){
            if($stock_qty>0)$cart_enable=""; else $cart_enable=" disabled ";
        }
    }
    $cart_enable = apply_filters("odudes_cart_enable", $cart_enable,$id);
    
    if(isset($pinfo['price_variation'])&&$pinfo['price_variation'])
        $html = "<a href='".get_permalink($id)."' class='btn btn-info btn-small cart_form'><i class='glyphicon glyphicon-shopping-cart icon-shopping-cart icon-white'></i> ".__("Check Details","odudeshop")."</a>";
    else{
        $html = <<<PRICE
                        <form method="post" action="" name="cart_form" class="cart_form">
                        <input type="hidden" name="add_to_cart" value="add">
                        <input type="hidden" name="pid" value="$id">
                         

PRICE;
        $html.='<button '.$cart_enable.' class="btn btn-info btn-small" type="submit" ><i class="glyphicon glyphicon-shopping-cart icon-shopping-cart icon-white"></i> '.__("Add to Enquiry","odudeshop").'</button></form>';

    }
    return $html;
}

function odudes_all_products($params)
{

	  
    $abc=include(odudes_BASE_DIR.'layout/catalog.php');
	return $abc;
	 
}
function odudes_all_catlist($params)
{

	  
    $abc=include(odudes_BASE_DIR.'layout/categories/catlist.php');
	return $abc;
	 
}
function odudes_all_section($params)
{

	  
    $abc=include(odudes_BASE_DIR.'layout/categories/section.php');
	return $abc;
	 
}

//delete product from front-end
function odudes_delete_product(){
    if(is_user_logged_in()&&isset($_GET['dproduct'])){
        global $current_user;
        $pid = intval($_GET['dproduct']);
        $pro = get_post($pid);
        
        if($current_user->ID==$pro->post_author){
            wp_update_post(array('ID'=>$pid,'post_status'=>'trash'));
            $settings = get_option('_odudes_settings');
            if($settings['frontend_product_delete_notify']==1){
                wp_mail(get_option('admin_email'),"I had to delete a product","Hi, Sorry, but I had to delete following product for some reason:<br/>{$pro->post_title}","From: {$current_user->user_email}\r\nContent-type: text/html\r\n\r\n");
            }
            $_SESSION['dpmsg'] = 'Product Deleted';
            header("location: ".$_SERVER['HTTP_REFERER']);
            die();
        } 
    }
}


 function odudes_head()
 {
    ?>
    
        <script language="JavaScript">
         <!--
         var odudes_base_url = '<?php echo plugins_url('/odudeshop/'); ?>';
         jQuery(function(){
             //jQuery('.odudes-thumbnails a').lightBox({fixedNavigation:true});
         });  
         //-->
         </script>
    
    <?php 
 }
 


function odudes_plugin_active($plugin = "odudeshop/odudeshop.php") {
    //$ret =  get_option( 'active_plugins', array() );
    //print_r($ret);
    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
}
//odudes_plugin_active();

/*
 * Category Fix
 */
function odudes_prouduct_meta($excerpt)
{
//Include in search results  

$odude_img=generateThumbnail_postid('icon');
if($odude_img!="")
	$img='<img src="'.$odude_img.'">';
else
	$img='<img src="'.WP_PLUGIN_URL.'/odudeshop/images/noimg.png">';

    global $post;
    if(get_post_type()!='odudeshop') return $excerpt;
    if(is_single()) return;
    ob_start();
?>    
<div class="obox">
  <div class="header"><?php the_title(); ?>
      <div class="date"> <?php if(function_exists('odudes_product_price')) echo get_option('_odudes_curr_sign','$').odudes_product_price(get_the_ID()); ?></div>
    </div>
	<div class="body" style="text-align:center"><a href="<?php echo get_permalink(); ?>"><?php echo $img; ?></a><?php echo $excerpt; ?></div>
	  <div class="footer" style="text-align:center">
	   <?php if(function_exists('odudes_addtocart_link')) echo odudes_addtocart_link(get_the_ID()); ?>
	  </div>   
</div>

<?php 
    //$test = ob_get_clean();
    //return $excerpt . $test;
}

//add_filter("the_content","odudes_prouduct_meta");
//add_filter("the_filter","odudes_prouduct_meta");
add_filter('the_excerpt', 'odudes_prouduct_meta',11);




//Add this to list in tag search
function query_post_type($query) {
  if ( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
    $post_type = get_query_var('post_type');
    if($post_type)
        $post_type = $post_type;
    else
        $post_type = array('post','odudeshop'); // replace cpt to your custom post type
    $query->set('post_type',$post_type);
    return $query;
    }
}
add_filter('pre_get_posts', 'query_post_type');




add_shortcode('odudes-category-list','odudes_category_list_sc');

function odudes_category_list_sc($atts,$content=null){
    extract( shortcode_atts( array(
		'cols' => '1'
	), $atts ) );
    
    $args = array(
        'orderby'       => 'name', 
        'order'         => 'ASC',
        'hide_empty'    => false, 
        'fields'        => 'all', 
        'hierarchical'  => true, 
        'pad_counts'    => true, 
    ); 
    
    $terms = get_terms('ptype',$args);
    $ret = '<div class="odude-shop"><ul style="list-style:none; list-style-type:none; margin-left:0px;">';
    foreach ($terms as $term) {
        //Always check if it's an error before continuing. get_term_link() can be finicky sometimes
        $term_link = get_term_link( $term, 'ptype' );
        if( is_wp_error( $term_link ) )
            continue;
        //We successfully got a link. Print it out.
        $ret .= '<li class="col-md-'.(12/(int)$cols).'" style="margin-left:0px;"><a href="' . $term_link . '">' . $term->name . ' (' . $term->count . ')</a></li>';
    }
    $ret .= '</ul></div>';
    return $ret;
}