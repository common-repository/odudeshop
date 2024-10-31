<?php
			
	function get_item_in_cart()
{
	//this function is for ajax call
	  $settings = get_option('_odudes_settings');
	   $currency_sign = get_option('_odudes_curr_sign','$');
		$shopping_cart=load_odude_cart();
		$shopping_total_item=$shopping_cart['total_item'];
		$shopping_total_value=$shopping_cart['total_price'];
        if(count($shopping_total_item)==0)
		$cart = __("No item in cart.","odudeshop")."<br/><a href='".$settings['continue_shopping_url']."'>".__("Continue shopping","odudeshop")."</a>";
	echo $shopping_total_item. " Items";
	echo " - ".$currency_sign.' '.$shopping_total_value;
	die(); // Important
}
function load_odude_cart()
{
    
       
       $cart_data = odudes_get_cart_data();
	   $cart_['total_item']=count($cart_data);
        $cart_['total_price']=number_format((double)str_replace(',','',wpmpz_get_cart_total()),2);
        return $cart_;
    
}
function odudes_check_min_purchase()
{
	
	$settings = get_option('_odudes_settings');

	if(isset($settings['min_amt']))
	{
		if(wpmpz_get_cart_total()<$settings['min_amt'])
		{
			add_filter("checkout_button","odudes_checkout_button_disable");
			echo '<div class="odude_warning"><i class="fa fa-warning"></i> Minimum Purchase must be '.get_option('_odudes_curr_sign','$').''.$settings['min_amt'].'</div>';
		}
		
	}
	
}


function odudes_checkout_button_disable()
{
	$button="<button class='pure-button pure-button-primary' disabled type='button' onclick='location.href=\"".get_permalink($settings['check_page_id'])."\"'><i class='fa fa-shopping-cart fa-lg'></i> ".__("Checkout","odudeshop")."</button>";
	return $button;
}
function odudes_checkout_button_enabled()
{
	$button="<button class='pure-button pure-button-primary' type='button' onclick='location.href=\"".get_permalink($settings['check_page_id'])."\"'><i class='fa fa-shopping-cart fa-lg'></i> ".__("Checkout","odudeshop")."</button>";
	return $button;
}
function odudes_checkout_button($status="")
{
	$settings = get_option('_odudes_settings');
	$button="<button class='pure-button pure-button-primary' ".$status." type='button' onclick='location.href=\"".get_permalink($settings['check_page_id'])."\"'><i class='fa fa-shopping-cart fa-lg'></i> ".__("Checkout","odudeshop")."</button>";
	return apply_filters("checkout_button",$button);
}
function odude_min_qty($now,$id)
{
	$settings = get_option('_odudes_settings');
	if(isset($settings['purchase']['enable']) && $settings['purchase']['enable']==1)
			{
				global $post;
				$pinfo = get_post_meta($id, 'odudes_list_opts', true);
				if($now>=$pinfo['qty'])
				{
					return "";
				}
				else
				{
					add_filter("checkout_button","odudes_checkout_button_disable");
					return "<br>Minium  Quantity: ".$pinfo['qty'];
				}
			}
			return "";
}
 function odude_product_image($id,$size)
 {
	 if($size=="icon")
		$size="odude_75_";
	 else if($size=="medium")
		 $size="odude_200_";
	 else
		 $size=0;
	 
	 
	 
	$uiu = odudes_IMAGE_URL;
	$post=get_post( $id ); 
	@extract(get_post_meta($post->ID,"odudes_list_opts",true));

	$previews=WP_PLUGIN_URL.'/odudeshop/images/noimg.png';

	if($images)
	{
	$previews = trim($uiu)."".$size."".trim($images[0]);
	}
	
	return $previews;
 }
		
function generateThumbnail($attachmentId, $size = 100)
{
    $imageArr = wp_get_attachment_image_src($attachmentId, 'single-post-thumbnail');
    $imageSrc = $imageArr[0];
    $imagePath = realpath(str_replace(get_bloginfo('url'), '.', $imageSrc));
    $name = basename($imagePath);
    $newImagePath = str_replace($name, 'odude_' . $size . '_' . $name, $imagePath);
    $newImageSrc = str_replace($name, 'odude_' . $size . '_' . $name, $imageSrc);
    if (!file_exists($newImagePath)) 
	{
        $image = wp_get_image_editor($imagePath);
        if (!is_wp_error($image)) {
            $image->resize($size, $size, false);
            $image->save($newImagePath);
        }
    }
    return $newImageSrc;
}
function generateThumbnail_sub($src, $size = 100)
{
    
    $imageSrc = $src;
    $imagePath = realpath(str_replace(get_bloginfo('url'), '.', $imageSrc));
    $name = basename($imagePath);
    $newImagePath = str_replace($name, 'odude_' . $size . '_' . $name, $imagePath);
    $newImageSrc = str_replace($name, 'odude_' . $size . '_' . $name, $imageSrc);
    if (!file_exists($newImagePath)) 
	{
		
        $image = wp_get_image_editor($imagePath);
        if (!is_wp_error($image)) 
		{
            $image->resize($size, $size, false);
            $image->save($newImagePath);
        }
		else
		{
			//echo $imagePath."--".$src;
		}
    }
    return $newImageSrc;
}

function generateThumbnail_postid($size)
{
	 $uiu = odudes_IMAGE_URL;
	global $post; 
 @extract(get_post_meta($post->ID,"odudes_list_opts",true));
 if($size=="icon")
	 $size=75;
 else if($size=="medium")
	 $size=200;
 else
	 $size=0;
 if(isset($images))
 if($images)
	{
	$odude_large_sub =trim($uiu)."".trim($images[0]);
	if($size!=0)
	{
	$odude_img = generateThumbnail_sub($odude_large_sub, $size);
	}
	else
	{
	$odude_img=$odude_large_sub;
	}

	return $odude_img;
	}
	else
	{
		return "";
	}
	
}
function odude_img($size)
{
	$odude_img=generateThumbnail_postid($size);
		if($odude_img!="")
			$img='<img src="'.$odude_img.'">';
		else
			$img='<img src="'.WP_PLUGIN_URL.'/odudeshop/images/noimg.png">';
		
		return $img;
}
?>