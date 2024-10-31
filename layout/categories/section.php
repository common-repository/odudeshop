
<?php
//odudes_all_section shortcode function here

 global $wp;
$view = $wp->query_vars['section'];
$ptype=$view;
$cates = get_term_by('slug', $ptype, 'ptype');
$catesid=$cates->term_id;
$cates_name=$cates->name;
$cates_desp=$cates->description;

$output='<div class="odude-shop">
<div id="catalog" class="row-fluid">';
global $wp_query;
$settings = maybe_unserialize(get_option('_odudes_settings'));
$postsperpage = 15;
$perrow = 2;
$orderby='';
$page ='on';

if(isset($params['perpage'])&&$params['perpage']>0) $postsperpage = $params['perpage'];
if(isset($params['perrow'])&&$params['perrow']>0) $perrow = $params['perrow'];

if(isset($params['orderby'])) $orderby = $params['orderby'];


if(isset($params['layout']))
	$layout = $params['layout'];
else
	$layout="list";


$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;


if(isset($ptype))
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
	$output.="Layout not found : ".$layout;

while($query->have_posts()) : $query->the_post();
$permalink=get_permalink();
$thetitle=get_the_title();
$odude_img=generateThumbnail_postid('icon');
if($odude_img!="")
	$img='<img src="'.$odude_img.'">';
else
	$img='<img src="'.WP_PLUGIN_URL.'/odudeshop/images/noimg.png">';

if($settings['showcart']==1)
	{
	if(function_exists('odudes_addtocart_link'))
		$cart_but= odudes_addtocart_link(get_the_ID()); 
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
$price= get_option('_odudes_curr_sign','$').odudes_product_price(get_the_ID());

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


