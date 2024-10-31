
<?php


function odude_product_content($post)
{
	include_once("header.php");
	$abc="";
	 $home = home_url('/');
	ob_start ();
	echo msg_product_position1();
	?>
	
	<style>
.thumb{margin-right:10px}
.thumb {
  display: inline-block;
  background: #f6f8f9;
  position: relative;
  margin: 0 10px 10px 0;
  border-radius: 3px;
  transition: all 0.2s ease-in-out;
}
.thumb:before {
  content:'';
  position:absolute;
  top:0;
  left:0;
  bottom:0;
  right:0;
  border: 1px solid rgba(0,0,0,0.1);
  border-radius: 3px;
}
.thumb img { 
  display: block; 
  border-radius: 3px;
}
.thumb:hover:before { 
   box-shadow: 0 0 5px #81bce3;
   border: 1px solid rgba(0,0,0,0.4);
}

</style>
<div itemscope itemtype="http://schema.org/Product">
<div class="odude_hide">
<span itemprop="name"><?php echo $post->post_title; ?></span>
 <span itemprop="brand"><?php echo get_bloginfo( 'name' ); ?></span>
 
</div>
	<div class="pure-g">
    <div class="pure-u-1 pure-u-md-1-2">
		<div class="pure-g obox">
		<div class="pure-u-1 pure-u-md-1" style="text-align:center;"><?php echo odude_product_prime_image(); ?></div>
		<div class="pure-u-1 pure-u-md-1"><?php echo odude_product_sub_image(); ?>
		
		
		</div>
		
		</div>
		
	</div>
	

	
	
	
    <div class="pure-u-1 pure-u-md-1-2">
	<form method="post" action="<?php echo $home; ?>" name="cart_form" class="pure-form cart_form">
        <input type="hidden" name="add_to_cart" value="add">
        <input type="hidden" name="pid" value="<?php echo $post->ID; ?>">
        <input type="hidden" name="discount" value="0">

	<?php
	
	echo odude_product_price();
	
?>
		<?php echo odude_product_price_variations(); ?>
	
		
		
		<?php echo odude_features();?>
		<br>
		<?php echo odude_product_cart_button(); ?>
		<img src="<?php echo odude_product_status(); ?>" border="0">
			<br><br><?php echo msg_product_position2(); ?>
		
</form>		
	
	
	</div>
	
		
	
	 <div class="pure-u-1 pure-u-md-1">
	 <div class="article">
	 <span itemprop="description">
			<?php

			$cnt = do_shortcode(wpautop($post->post_content));

			
			echo $cnt;

			?>
	 </span>
	 </div>
	 </div>
	 <div class="pure-u-1 pure-u-md-1"><?php echo odude_tabs($post); ?></div>
	 
</div>	 
	 <br>
	 	<?php
$tags = wp_get_post_terms( get_queried_object_id(), 'post_tag', ['fields' => 'ids'] );
$args = [
    'post__not_in'        => array( get_queried_object_id() ),
    'posts_per_page'      => 5,
    'ignore_sticky_posts' => 1,
    'orderby'             => 'rand',
	'post_type' => 'odudeshop',
    'tax_query' => [
        [
            'taxonomy' => 'post_tag',
            'terms'    => $tags
        ]
    ]
];
$my_query = new wp_query( $args );
if( $my_query->have_posts() ) 
{
   $i=0; 
	echo '<div class="pure-g">';
        while( $my_query->have_posts() ) 
		{
			echo '<div class="pure-u-1 pure-u-md-1-3">';
			$i++;
            $my_query->the_post();
			$odude_img=generateThumbnail_postid('icon');
			if($odude_img!="")
				$img='<img src="'.$odude_img.'">';
			else
				$img='<img src="'.WP_PLUGIN_URL.'/odudeshop/images/noimg.png">';
			?>
            <div class="obox" style="text-align:center">
				
                <a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>" rel="nofollow"><?php echo $img; ?>
                </a>
<div class="footer" style="text-align:center"><?php the_title(); ?></div>
            </div>
        <?php 
		 if( $i == 3 )break;
		echo "</div>";
		}
       wp_reset_query();
	   echo "</div>";
   
}
?> 
	 
	 
	 <br><?php echo msg_product_position3(); ?>
</div>
	<?php
	$abc=ob_get_clean (); 
	return $abc;
}
