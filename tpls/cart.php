
<?php
$settings = get_option('_odudes_settings');

// Store the short code in a variable.
		if(isset($settings['short_msg_cart_top']))
		{
		   $short_exec=$settings['short_msg_cart_top'];
				if($short_exec!='')
				echo do_shortcode( stripslashes($short_exec) )."<br>";  
		}
		else
		{
			echo "sadfsdafsd";
		}
		




$currency_sign = get_option('_odudes_curr_sign','$');
$variations="";
 if($settings['showcart']==1)
 {
	 
	 $xcart=""
		."<form method='post' class='pure-form pure-form-aligned' action='' name='cart_form' id='cart_form'>"
		."<div class='pure-g'>"
		."<input type='hidden' name='odudes_update_cart' value='1' />"
		."<div class='pure-u-1 pure-u-md-1'>";
	 
	 

	 /*
		$cart = "<div class='odude-shop'>"
				. "<form method='post' class='pure-form' action='' name='cart_form' id='cart_form'>"
				. "<input type='hidden' name='odudes_update_cart' value='1' />"
				. "<table class='pure-table pure-table-horizontal' width='100%' >"
				. "<thead><tr >"
				. "<th style='width:10px !important'></th>"
				. "<th style='text-align:left'>".__("Title","odudeshop")."</th>"
				. "<th style='text-align:left'>".__("Unit Price","odudeshop")."</th>"
				//. "<th> ".__("Role Discount","odudeshop")."</th>"
				. "<th style='text-align:left'> ".__("Coupon","odudeshop")."</th>"
				. "<th style='text-align:left'>".__("Quantity","odudeshop")."</th>"
				. "<th class='amt' style='text-align:left'>".__("Total","odudeshop")."</th>"
				. "</tr> </thead>";
		*/
		if(is_array($cart_data))
		{
			//print_r($cart_data);
			foreach($cart_data as $item)
			{
				
				
				
			//echo "<pre>" ;  print_r($item); echo "</pre>";
			//filter for adding various message after cart item
			$cart_item_info="";
			$cart_item_info = apply_filters("odudes_cart_item_info", $cart_item_info, $item['ID']);
			if(isset($item['item']) && !empty($item['item'])):
				
				foreach ($item['item'] as $key => $var):
				//echo "<pre>" ;  print_r($item['item']); echo "</pre>";
					if(isset($var['coupon_amount']) && $var['coupon_amount'] != ""){
						$discount_amount=$var['coupon_amount'];
						$discount_title='Discounted $'.$discount_amount." for coupon code '{$item['coupon']}'";
						$discount_style="<span title='$discount_title'><i class=\"fa fa-gift\"></i></span>";
					} else{ 
						$discount_amount="";
						$discount_style="";
						$discount_title="";
						
					}
					
					if($var['error'] != ""){
						
						
						
						$coupon_style="";
						$title=$var['error'];
						
						
					} else {
						$coupon_style="style='border:1px solid;'";
						$title="";
						
						
					}    
				
					if($var['variations'])
						$variation = "<small><i>".implode(", <br>",$var['variations'])."</i></small><br>";
					//echo "<pre>";
					//print_r($item);
					//echo "</pre>";
					
					$quty=$item['item'][$key]['quantity'];
					$quty_name="cart_items[$item[ID]][item][$key][quantity]";
					//echo $quty_name;
					// form name='cart_items[$item[ID]][item][$key][quantity]' value='{$item['item'][$key]['quantity']}'
					
					echo "$cou";
					
					//$item['item'][0]['quantity']; 
						$xcart.="	<div id='cart_item_$item[ID]_$key'>
					   <div class=\"obox\" id='cart_item_{$item['ID']}_{$key}'>
					<div class=\"header\">{$item['post_title']} <br>".$currency_sign.number_format($item[price],2,".","")."
					
					 <a class='odudes_cart_delete_item' href='#' onclick='return odudes_pp_remove_cart_item2($item[ID],$key)' Title='Trash'>
					  <i class='fa fa-trash'></i>
					  </a>
					  
					  <div class=\"date\">
					  
					  <span class='ttip' title='$discount_title'>$variation".$cart_item_info ."</span>
					   
		
					  
					  </div>
					</div>
					<div class=\"body\"  style=\"text-align:center\">
					
						<div class='pure-g'>
							 <div class='pure-u-1 pure-u-md-1-4'> 
							
							 <img src='".odude_product_image($item['ID'],'icon')."'>
							 </div>
							  <div class='pure-u-1 pure-u-md-3-4' > 
								
								<div class='pure-g'>
								<div class='pure-u-1-2 pure-u-md-1-2' >Coupon </div>
								<div class='pure-u-1-2 pure-u-md-1-2' >Quantity </div>
								<div class='pure-u-1-2 pure-u-md-1-2' ><input $coupon_style title='$title' type='text' name='cart_items[$item[ID]][coupon]' value='$item[coupon]' id='$item[ID]' class='ttip' size='5' /></div>
								<div class='pure-u-1-2 pure-u-md-1-2' ><input type='text' name='$quty_name' value='$quty' id='c-$item[ID]' size='5' /></div>
								</div>
											
							</div>	
						
						</div>	
						
					</div>
				   
					<div class=\"footer\" style=\"text-align:center\">".$discount_style." 
					".$currency_sign.number_format((($item['price']+$var['prices'])*$var['quantity'])-$var['coupon_amount'] - $var['discount_amount'],2,".","")." 
					</div>
				  </div>
					 </div>
					 ";
					 
				
									
				/* 	$cart .= "<tbody><tr id='cart_item_{$item['ID']}_{$key}'>"
						. "<td>"
							. "<a class='odudes_cart_delete_item' href='#' onclick='return odudes_pp_remove_cart_item2({$item['ID']},{$key})'>"
								. "<i class='fa fa-trash'></i>"
							. "</a>"
						. "</td>"
						. "<td class='cart_item_title'>{$item['post_title']}<br>$variation".$cart_item_info ."</td>"
						. "<td class='cart_item_unit_price' $discount_style ><span class='ttip' title='$discount_title'>".$currency_sign.number_format($item[price],2,".","")."</span></td>"
						//. "<td class='' >"  .$currency_sign.number_format($var['discount_amount'],2,'.','') . "</td>"
						. "<td><input $coupon_style title='$title' type='text' name='cart_items[$item[ID]][coupon]' value='{$item['coupon']}' id='$item[ID]' class='ttip' size=5 /></td>"
						. "<td class='cart_item_quantity'><input type='text' name='cart_items[$item[ID]][item][$key][quantity]' value='{$item['item'][$key]['quantity']}' size=5 /></td>"
						. "<td class='cart_item_subtotal amt'>".$currency_sign.number_format((($item['price']+$var['prices'])*$var['quantity'])-$var['discount_amount'] - $var['coupon_amount'],2,".","")."</td>"
						. "</tr> </tbody>"; */
				endforeach;
				
				
			else:
			  //  echo "<pre>";        print_r($item); echo "</pre>";
				
				
			if($item['variations'])
			$variations .= "<small><i>".implode(",<br> ",$item['variations'])."</i></small>";     
			
			if(isset($item['coupon_amount']))
			{
				$discount_amount=$item['coupon_amount'];
				//$discount_style="style='color:#008000; text-decoration:underline;'";
				$discount_title='Discounted '.$currency_sign.' '.$discount_amount." for coupon code '{$item['coupon']}'";
				$discount_style="<span title='$discount_title'><i class=\"fa fa-gift\"></i></span>";
				
			}
			else
			{ 
				$discount_amount="";
				$discount_style="";
				$discount_title="";
				
			}
			
			if(isset($item['error']))
			{
				$coupon_style="style='border:1px solid;'";
				$title=$item['error'];
				
			} 
			else 
			{
				$coupon_style="";
				$title="";
				
			}
/* 				
			$cart .= "<tr id='cart_item_{$item[ID]}'>"
			. "<td>"
				. "<a class='odudes_cart_delete_item' href='#' onclick='return odudes_pp_remove_cart_item($item[ID])'>"
					. "<i class='fa fa-trash'></i>"
				. "</a>"
			. "</td>"
			. "<td class='cart_item_title'>$item[post_title]<br>$variations".$cart_item_info."</td>"
			. "<td class='cart_item_unit_price' $discount_style ><span class='ttip' title='$discount_title'>".$currency_sign.number_format($item[price],2,".","")."</span></td>"
		   // . "<td class=''>"  .$currency_sign.number_format($var['discount_amount'],2,'.','') . "</td>"
			. "<td><input $coupon_style title='$title' type='text' name='cart_items[$item[ID]][coupon]' value='$item[coupon]' id='$item[ID]' class='ttip' size='5' /></td>"
			. "<td class='cart_item_quantity'><input type='text' name='cart_items[$item[ID]][quantity]' value='$item[quantity]' size='5' /></td>"
			. "<td class='cart_item_subtotal amt'>".$currency_sign.number_format((($item['price']+$item['prices'])*$item['quantity'])-$item['coupon_amount'] - $item['discount_amount'],2,".","")."</td>"
			. "</tr>"; */
			
			if(!isset($item['coupon_amount']))
				$item['coupon_amount']=0;
			
			if(!isset($item['coupon']))
				$item['coupon']="";
			
			$xcart.="	<div id='cart_item_$item[ID]'>
					   <div class=\"obox\" id='cart_item_{$item['ID']}'>
					<div class=\"header\"> 
					
					{$item['post_title']} <br>".$currency_sign.number_format($item['price'],2,".","")."
							 <a class='odudes_cart_delete_item' href='#' onclick='return odudes_pp_remove_cart_item($item[ID])' Title='Trash'>
					  <i class='fa fa-trash'></i>
					  </a>
					<div class=\"date\">
					 
					  <span class='ttip' title='$discount_title'>$variations".$cart_item_info."</span>
					 
					
					  
					  </div>
					</div>
					<div class=\"body\"  style=\"text-align:center\">
					
						<div class='pure-g'>
							 <div class='pure-u-1 pure-u-md-1-4'> 
							 
							 <img src='".odude_product_image($item['ID'],'icon')."'>
							 </div>
							  <div class='pure-u-1 pure-u-md-3-4' > 
								
								<div class='pure-g'>
								<div class='pure-u-1-2 pure-u-md-1-2' >Coupon </div>
								<div class='pure-u-1-2 pure-u-md-1-2' >Quantity </div>
								<div class='pure-u-1-2 pure-u-md-1-2' ><input $coupon_style title='$title' type='text' name='cart_items[$item[ID]][coupon]' value='$item[coupon]' id='$item[ID]' class='ttip' size='5' /></div>
								<div class='pure-u-1-2 pure-u-md-1-2' ><input type='text' name='cart_items[$item[ID]][quantity]' value='$item[quantity]' id='c-$item[ID]' size='5' /> ".odude_min_qty($item['quantity'],$item['ID'])."</div>
								</div>
														
							</div>	
						
						</div>	
						
					</div>
				   
					<div class=\"footer\" style=\"text-align:center\">".$discount_style." 
					".$currency_sign.number_format((($item['price']+$item['prices'])*$item['quantity'])-$item['coupon_amount'] - $item['discount_amount'],2,".","")."
					</div>
				  </div>
					 </div>
					 ";
			
			 $variations='';
			endif;
			
			}
		}
		
			 
	
		
		
		wpmpz_get_cart_total();
		odudes_check_min_purchase();
		$extra_row = '';
		$xcart .= apply_filters('odudes_cart_extra_row',$extra_row);
		
				$xcart .= "
		<div class='pure-g'>
		<div class='pure-u-1 pure-u-md-1-3'> <button class='pure-button' type='button' onclick='document.getElementById(\"cart_form\").submit();'><i class='fa fa-pencil-square'></i> ".__("Update Cart","odudeshop")."</button> </div>	
		<div class='pure-u-1 pure-u-md-1-3'> </div>
		<div class='pure-u-1 pure-u-md-1-3' id='odudes_cart_total' style=\"text-align:right\" > ".__("Total:","odudeshop")." ".     $currency_sign.number_format((double)str_replace(',','',wpmpz_get_cart_total()),2)."</div>
		
		</div>	
		<hr>
		<div class='pure-g'>
		<div class='pure-u-1 pure-u-md-1-3'> <button type='button' class='pure-button' onclick='location.href=\"".$settings['continue_shopping_url']."\"'><i class='fa fa-repeat'></i> ".__("Continue Shopping","odudeshop")."</button>&nbsp;</div>
		<div class='pure-u-1 pure-u-md-1-3'> </div>
		<div class='pure-u-1 pure-u-md-1-3' style=\"text-align:right\"> ".odudes_checkout_button()."</div>
		</div>


		<script language='JavaScript'>
		<!--
			function  odudes_pp_remove_cart_item(id)
			{
			
				   if(!confirm('Are you sure?')) return false;
				   jQuery('#cart_item_'+id+' *').css('color','#ccc');
				   jQuery.post('".home_url('?odudes_remove_cart_item=')."'+id
				   ,function(res){ 
				   var obj = jQuery.parseJSON(res);
				   
				   jQuery('#cart_item_'+id).fadeOut().remove(); 
				   jQuery('#odudes_cart_total').html(obj.cart_total); 
				   jQuery('#odudes_cart_discount').html(obj.cart_discount); 
				   jQuery('#odudes_cart_subtotal').html(obj.cart_subtotal); });
				   return false;
			}
			function  odudes_pp_remove_cart_item2(id,item)
			{
				   if(!confirm('Are you sure?')) return false;
				   jQuery('#cart_item_'+id+'_'+item+' *').css('color','#ccc');
				   jQuery.post('".home_url('?odudes_remove_cart_item=')."'+id + '&item_id='+item  
				   ,function(res){ 
				   var obj = jQuery.parseJSON(res);
				   
				   jQuery('#cart_item_'+id+'_'+item).fadeOut().remove(); 
				   jQuery('#odudes_cart_total').html(obj.cart_total); 
				   jQuery('#odudes_cart_discount').html(obj.cart_discount); 
				   jQuery('#odudes_cart_subtotal').html(obj.cart_subtotal); });
				   return false;
			}
			
		
			  
		//-->
		</script>

		";
		
		

	/* 	$cart .= "

		<tr><td colspan=5 align=right class='text-right'>".__("Total:","odudeshop")."</td>
		<td class='amt' id='odudes_cart_total'>".     $currency_sign.number_format((double)str_replace(',','',wpmpz_get_cart_total()),2)."</td></tr>
		<tr><td colspan=2>
		<button type='button' class='pure-button' onclick='location.href=\"".$settings['continue_shopping_url']."\"'><i class='fa fa-repeat'></i> ".__("Continue Shopping","odudeshop")."</button></td>
		<td colspan=4 align=right class='text-right'>
		<button class='pure-button' type='button' onclick='document.getElementById(\"cart_form\").submit();'><i class='fa fa-pencil-square'></i> ".__("Update Cart","odudeshop")."</button>
		".odudes_checkout_button()."</td></tr>
		</table>

		</form></div>

		<script language='JavaScript'>
		<!--
			function  odudes_pp_remove_cart_item(id)
			{
			
				   if(!confirm('Are you sure?')) return false;
				   jQuery('#cart_item_'+id+' *').css('color','#ccc');
				   jQuery.post('".home_url('?odudes_remove_cart_item=')."'+id
				   ,function(res){ 
				   var obj = jQuery.parseJSON(res);
				   
				   jQuery('#cart_item_'+id).fadeOut().remove(); 
				   jQuery('#odudes_cart_total').html(obj.cart_total); 
				   jQuery('#odudes_cart_discount').html(obj.cart_discount); 
				   jQuery('#odudes_cart_subtotal').html(obj.cart_subtotal); });
				   return false;
			}
			function  odudes_pp_remove_cart_item2(id,item)
			{
				   if(!confirm('Are you sure?')) return false;
				   jQuery('#cart_item_'+id+'_'+item+' *').css('color','#ccc');
				   jQuery.post('".home_url('?odudes_remove_cart_item=')."'+id + '&item_id='+item  
				   ,function(res){ 
				   var obj = jQuery.parseJSON(res);
				   
				   jQuery('#cart_item_'+id+'_'+item).fadeOut().remove(); 
				   jQuery('#odudes_cart_total').html(obj.cart_total); 
				   jQuery('#odudes_cart_discount').html(obj.cart_discount); 
				   jQuery('#odudes_cart_subtotal').html(obj.cart_subtotal); });
				   return false;
			}
			
		
			  
		//-->
		</script>

		"; */
		$xcart.='</div>';
	 $xcart.='</div></form>';
		
		if(count($cart_data)==0) $xcart = __("No item in cart.","odudeshop")."<br/><a href='".$settings['continue_shopping_url']."'>".__("Continue","odudeshop")."</a>";
 }
 else
 {
	
	 require_once("cart_enquiry.php"); 
 }