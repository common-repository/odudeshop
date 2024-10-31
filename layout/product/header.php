<?php



 add_thickbox();
 //Generate Tabs
 function odude_tabs($post)
{
	
	 $pinfo = get_post_meta($post->ID,"odudes_list_opts",true);
	@extract($pinfo);
	
	//print_r($pinfo);
	$op="";
	if(isset($pinfo['odudetab']))
	{
	$category_id=$pinfo['odudetab'];
			$args = array(
			'post_type' => 'odudeshop_tabs',
			'tax_query' => array(
				array(
					'taxonomy' => 'tabcat',
					'field'    => 'term_id',
					'terms'    => $category_id,
				),
			),
		);
		$q = new WP_Query( $args );
		$titleArray = array();
		$cocArray = array();
		//echo $q->post_count;
		
		// The Loop
		if ( $q->have_posts() ) 
		{
			
			while ( $q->have_posts() ) 
			{
				$q->the_post();
				//$po=$q->the_post();
				$titleArray[]=get_the_title();
				//$cocArray[]=$post->post_content;
				$cocArray[]=get_the_content();
			}
			
		}
		
		if(has_filter('odude_add_tab_title')) 
		{
		$titleArray = apply_filters('odude_add_tab_title', $titleArray);
		}
		if(has_filter('odude_add_tab_content')) 
		{
		$cocArray = apply_filters('odude_add_tab_content', $cocArray);
		}
		
		 $op.='<div id="accordion">';
		for($x = 0; $x < count($titleArray); $x++) 
		{
				$op.='<h3>' . $titleArray[$x] . '</h3>';
				$op.="<div>".$cocArray[$x]."</div>";
		}
		$op.='</div>'; 
	}
	 wp_reset_query();
		return $op;

}

 function odude_features()
{
    global $post;
    $pinf = get_post_meta($post->ID, 'odudes_list_opts', true);
	$dim="";
	if($pinf['weight1']=='') return $dim;
    $dim .= "<table class='table'>";
    $dim .= "<tr><td>{$pinf['weight1']}</td><td>{$pinf['weight']}</td></tr>";
	if($pinf['pwidth']!='')
    $dim .= "<tr><td>{$pinf['pwidth1']}</td><td>{$pinf['pwidth']}</td></tr>";
	if($pinf['pheight']!='')
    $dim .= "<tr><td>{$pinf['pheight1']}</td><td>{$pinf['pheight']}</td></tr>";
	/* if($pinf['pextra_one']!='')
    $dim .= "<tr><td>{$pinf['pextra_one1']}</td><td>{$pinf['pextra_one']}</td></tr>";
	if($pinf['pextra_two']!='')
    $dim .= "<tr><td>{$pinf['pextra_two1']}</td><td>{$pinf['pextra_two']}</td></tr>"; */
    $dim .= "</table>";
    return $dim;
}
 
 function msg_product_position1()
 {
	  $settings = maybe_unserialize(get_option('_odudes_settings'));
	  if(isset($settings['msg_product_position1']))
		  return $settings['msg_product_position1']."<br>" ;
	  else
		  return "" ;
 }
  function msg_product_position2()
 {
	  $settings = maybe_unserialize(get_option('_odudes_settings'));
	  if(isset($settings['short_msg_product_position2']))
		  if($settings['short_msg_product_position2']!='')
		  return do_shortcode( stripslashes($settings['short_msg_product_position2'] ) );
		else
		  return '';

	  else
		  return "" ;
 }
   function msg_product_position3()
 {
	  $settings = maybe_unserialize(get_option('_odudes_settings'));
	  if(isset($settings['short_msg_product_position3']))
		  if($settings['short_msg_product_position3']!='')
		  return do_shortcode( stripslashes($settings['short_msg_product_position3'] ) );
		else
		  return '';

	  else
		  return "" ;
 }
 
 function odude_product_price()
 {
	 global $post;
		$abc='';
		 $settings = maybe_unserialize(get_option('_odudes_settings'));
        $pinfo = get_post_meta($post->ID,"odudes_list_opts",true);
		@extract($pinfo);
	  $currency_sign = get_option('_odudes_curr_sign','$');
	   $base_price = (double)$base_price;
		$price_html = number_format($base_price,2,".","");
        $expire = false;
		
			 if(isset($sales_price_expire)) 
			 {
             $today = strtotime(date('Y-m-d'));
             $end_date = strtotime($sales_price_expire);
				if($end_date<=$today)
				{
					$expire = true;
				}
			}
			
			$hide_price=$settings['hide_price'];
			
		if($hide_price=='0' || (odudeshop_current_user_role()=='odude_buyer') || current_user_can('edit_others_pages'))
		{			
		if($sales_price>0 && $expire == false && $base_price>$sales_price)
			$price_html = "<sub><strike>{$currency_sign} {$price_html}</strike></sub> ".$currency_sign."<span itemprop=\"price\"> ".number_format($sales_price,2,".","")."</span>";
        else 
			$price_html = '<h3>'.$currency_sign.'<span itemprop="price">'.$price_html.'</span></h3>';
		}
		else
		{
			$price_html = '';
		}
		
        if($base_price==0)
		$price_html ='<span itemprop="price">'.__('', 'odudeshop').'</span>';
		
        $abc='<div class="odudes-regular-price"><span itemprop="offers" itemscope itemtype="http://schema.org/Offer">'.$price_html.'<meta itemprop="priceCurrency" content="'.get_option('_odudes_curr_name','USD').'" /></span></div>';	
return $abc;		
 }
 
 function odude_product_price_variations()
 {
	 $currency_sign = get_option('_odudes_curr_sign','$');
	 global $post;
		$abc='';
        $pinfo = get_post_meta($post->ID,"odudes_list_opts",true);
		@extract($pinfo);
		
		if(isset($price_variation))
		if($price_variation)
		{
          foreach($variation as $key=>$value)
		  {
              if(isset($value['multiple']))
			  {
                  $multiple = "multiple='multiple'";
              }
              else 
				  $multiple = "";
			  
              $abc.='<label for="state">'.ucfirst($value['vname']).'</label><div  style="display:block;"><select name="variation[]" id="var_price_'.uniqid().'"' . $multiple .' >';
             
              foreach($value as $optionkey=>$optionvalue)
			  {
                  if(is_array($optionvalue))
				  {
                    $vari = (intval($optionvalue['option_price'])!=0)?" ( + {$currency_sign}".number_format($optionvalue['option_price'],2,".","")." )":"";  
                    $abc.='<option value="'.$optionkey.'">'." ".$optionvalue['option_name'].$vari.'</option>';
                  }
              }
              $abc.='</select></div>';
          } 
        }
		return $abc;
		
 }
  function odude_product_cart_button()
 {
	 global $post;
	 $base_price=0;
	  $base_price = (double)$base_price;  
		$abc='';
        $pinfo = get_post_meta($post->ID,"odudes_list_opts",true);
		@extract($pinfo);
		//check settings for the stock enable or not
        $settings = maybe_unserialize(get_option('_odudes_settings'));
		
		if($pinfo['status']!="ok")
		$cart_enable=" disabled ";
	else
		$cart_enable="";
		
		if(!isset($settings['instant_download']))
		$settings['instant_download']=0;
	
		if($settings['instant_download']==1&&$base_price==0&&$pinfo['digital_activate']==1)
        $abc .= '<a href="'.home_url('/?odudefile='.$post->ID).'" class="button-secondary pure-button"><i class="fa fa-download"></i> '.__('Download','odudeshop').'</a>';
        else if($settings['showcart']==1)
		$abc.='<div class="clearboth"></div><div class="add-to-cart-button"><div class="odude_left"><button '.$cart_enable.' class="pure-button pure-button-primary" type="submit" id="cart_submit" ><i class="fa fa-shopping-cart fa-lg"></i> '.__("Buy Now","odudeshop").'</button></div></div>';
         else if($settings['showcart']==2)
		$abc.='<div class="clearboth"></div><div class="add-to-cart-button"><div class="odude_left"><button '.$cart_enable.' class="pure-button pure-button-primary" type="submit" id="cart_submit"><i class="fa fa-shopping-cart fa-lg"></i> '.__("Add to Enquiry","odudeshop").'</button></div></div>';
		else
		$abc="";	
	
		$hide_price=$settings['hide_price'];
		if($settings['showcart']==1)
		if($hide_price=='0' || (odudeshop_current_user_role()=='odude_buyer') || current_user_can('edit_others_pages'))
		return $abc;
		else
		return '<a class="pure-button pure-button-disabled" href="#">Price & Purchase Disabled</a>';
 }
 function odude_product_prime_image()
 {
	 global $post; 
	@extract(get_post_meta($post->ID,"odudes_list_opts",true));

	$previews='<img itemprop="image" src="'.WP_PLUGIN_URL.'/odudeshop/images/noimg.png" alt="No Image">';
	
	if(isset($images))
	{
	$odude_img=generateThumbnail_postid('medium');
	
	$previews = "<div class='odudes-thumbnails'><a class='thickbox' href='".generateThumbnail_postid('large')."' title='".$post->post_title."' ><img itemprop=\"image\" src='".$odude_img."' alt=\"".$post->post_title."\" /></a></div>";
	}
	
	return $previews;
 }
 function odude_product_status()
 {
	 	 global $post; 
	 $pinfo = get_post_meta($post->ID,"odudes_list_opts",true);
		@extract($pinfo);
	if($pinfo['status'])
	 return plugins_url().'/odudeshop/images/'.$pinfo['status'].'.png';
	else
		return plugins_url().'/odudeshop/images/ok.png';
 }
  function odude_product_sub_image()
 {
	 $c=0;
	 global $post; 
	@extract(get_post_meta($post->ID,"odudes_list_opts",true));
 $uiu = odudes_IMAGE_URL;
	$previews="<div class='odudes-sub'>";
 
	if(isset($images))
	{
		foreach($images as $image)
		{

		$odude_large_sub =trim($uiu)."".trim($image);
		$odude_icon = generateThumbnail_sub($odude_large_sub, 75);
			++$c;
		$previews .= '<a class="thickbox" href="'.$odude_large_sub.'" rel="product-images" title="'.$post->post_title.'" ><img src="'.$odude_icon.'"/></a>';
	
		}
	}
	$previews.="</div>";
	
	return $previews;
 }
 
?>