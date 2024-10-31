<?php
global $post; 

//odudes_all_products shortcode function here

$output='<div class="odude-shop">
<div id="catalog" class="row-fluid">';
global $wp_query;
$settings = maybe_unserialize(get_option('_odudes_settings'));
$postsperpage = 15;
$perrow = 2;
$ptype='';
$orderby='';
$page='';
$hide_price=$settings['hide_price'];

if(isset($params['perpage'])&&$params['perpage']>0) $postsperpage = $params['perpage'];
if(isset($params['perrow'])&&$params['perrow']>0) $perrow = $params['perrow'];
if(isset($params['ptype'])) $ptype = $params['ptype'];
if(isset($params['orderby'])) $orderby = $params['orderby'];
if(isset($params['page'])) $page = $params['page'];

if(isset($params['layout']))
	$layout = $params['layout'];
else
	$layout="list";

//query_posts('post_type=odudeshop&posts_per_page='.$postsperpage.'&paged='.$wp_query->query_vars['paged'].'&ptype='.$ptype);
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

/* $args = array(  
'post_status' => 'publish',
'taxonomy' => 'ptype',
'term' => $ptype,
'posts_per_page' => $postsperpage,
'paged' => $paged,
'post_type' => 'odudeshop'); */

if(isset($params['ptype']))
{
$args = array(
	'post_type' => 'odudeshop',
	'paged' => $paged,
	'posts_per_page' => $postsperpage,
	'orderby' => $orderby,
	'order'   => 'DESC',
	'tax_query' => array(
		array(
			'taxonomy' => 'ptype',
			'field'    => 'slug',
			'terms'    => explode(',',$ptype),
			//'terms'    => array( 'mobile', 'sports' ),
		),
		
	),
);
}
else
{
	$args = array(
	'post_type' => 'odudeshop',
	'paged' => $paged,
	'posts_per_page' => $postsperpage,
);
}

$query = new WP_Query($args); 


if(file_exists(WP_PLUGIN_DIR."/odudeshop/layout/".$layout."_up.php"))
	$output.=include(WP_PLUGIN_DIR."/odudeshop/layout/".$layout."_up.php");
	else
	$output.=__("Layout Not Found","odudeshop").": ".$layout;

while($query->have_posts()) : $query->the_post();
$permalink=get_permalink();
$thetitle=get_the_title();

if($settings['showcart']==1)
	{
	if(function_exists('odudes_addtocart_link'))
		if($hide_price=='0' || (odudeshop_current_user_role()=='odude_buyer') || current_user_can('edit_others_pages'))
		$cart_but= odudes_addtocart_link(get_the_ID()); 
		else
		$cart_but= '<a class="pure-button" href="'.$permalink.'">Check Details</a>';	
	}
	else if($settings['showcart']==2)
	{
	if(function_exists('odudes_addtocart_link'))
		$cart_but=  odudes_addtoenquiry_link(get_the_ID()); 
	}
	else
	{
		$cart_but=  "&nbsp;";
	}

if(function_exists('odudes_product_price'))
if($hide_price=='0' || (odudeshop_current_user_role()=='odude_buyer') || current_user_can('edit_others_pages'))
	$price= get_option('_odudes_curr_sign','$').odudes_product_price(get_the_ID());
else
	$price= '';

if(file_exists(WP_PLUGIN_DIR."/odudeshop/layout/$layout.php"))
	$output.=include(WP_PLUGIN_DIR."/odudeshop/layout/$layout.php"); 



endwhile;

if(file_exists(WP_PLUGIN_DIR."/odudeshop/layout/".$layout."_down.php"))
	$output.=include(WP_PLUGIN_DIR."/odudeshop/layout/".$layout."_down.php");



$output.='</div>
</div>';
$output_page="";


if(function_exists('wp_pagenavi'))
{
	if($page!='')
	$output.=wp_pagenavi( array( 'query' => $query ) );
}


wp_reset_query();
return $output;
?>


