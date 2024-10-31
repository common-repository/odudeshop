<?php
//Add to enquiry page
$settings = get_option('_odudes_settings');
$currency_sign = get_option('_odudes_curr_sign','$');


	 
		$xcart = "<div class='odude-shop'>"
				. "<form method='post' class='pure-form' action='' name='cart_form' id='cart_form'>"
				. "<input type='hidden' name='odudes_update_cart' value='1' />"
				. "<table class='pure-table pure-table-horizontal' width='100%' border='0'>"
				. "<thead><tr >"
				. "<th style='width:10px !important'></th>"
				. "<th style='text-align:left'>".__("Title","odudeshop")."</th>"
				//. "<th style='text-align:left'>".__("Unit Price","odudeshop")."</th>"
				//. "<th> ".__("Role Discount","odudeshop")."</th>"
				//. "<th style='text-align:left'> ".__("Coupon","odudeshop")."</th>"
				. "<th style='text-align:left'>".__("Quantity","odudeshop")."</th>"
				//. "<th class='amt' style='text-align:left'>".__("Total","odudeshop")."</th>"
				. "</tr> </thead>";

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
					
					
					if($var['error'] != ""){
						$coupon_style="style='border:1px solid #ff0000;'";
						$title=$var['error'];
						
					} else {
						$coupon_style="";
						$title="";
						
					}    
				
					if($var['variations'])
						$variation = "<small><i>".implode(", ",$var['variations'])."</i></small>";
					
					$xcart .= "<tbody><tr id='cart_item_{$item['ID']}_{$key}'>"
						. "<td>"
							. "<a class='odudes_cart_delete_item' href='#' onclick='return odudes_pp_remove_cart_item2({$item['ID']},{$key})'>"
								. "<i class='fa fa-trash'></i>"
							. "</a>"
						. "</td>"
						. "<td class='cart_item_title'>{$item['post_title']}<br>$variation".$cart_item_info ."</td>"
						. "<td class='cart_item_unit_price' $discount_style ><span class='ttip' title='$discount_title'>".$currency_sign.number_format($item[price],2,".","")."</span></td>"
						. "<td class='' >"  .$currency_sign.number_format($var['discount_amount'],2,'.','') . "</td>"
						. "<td><input style='$coupon_style' title='$title' type='text' name='cart_items[$item[ID]][coupon]' value='{$item['coupon']}' id='$item[ID]' class='ttip' size=3 /></td>"
						. "<td class='cart_item_quantity'><input type='text' name='cart_items[$item[ID]][item][$key][quantity]' value='{$item['item'][$key]['quantity']}' size=3 /></td>"
						. "<td class='cart_item_subtotal amt'>".$currency_sign.number_format((($item['price']+$var['prices'])*$var['quantity'])-$var['discount_amount'] - $var['coupon_amount'],2,".","")."</td>"
						. "</tr> </tbody>";
				endforeach;
				
				
			else:
			  //  echo "<pre>";        print_r($item); echo "</pre>";
				
				
			if($item['variations'])
			$variations .= "<small><i>".implode(", ",$item['variations'])."</i></small>";     
			
			
			
			if($item['error'])
			{
				$coupon_style="style='border:1px solid #ff0000;'";
				$title=$item['error'];
				
			} 
			else 
			{
				$coupon_style="";
				$title="";
				
			}
				
			$xcart .= "<tr id='cart_item_{$item[ID]}'>"
			. "<td>"
				. "<a class='odudes_cart_delete_item' href='#' onclick='return odudes_pp_remove_cart_item($item[ID])'>"
					. "<i class='fa fa-trash'></i>"
				. "</a>"
			. "</td>"
			. "<td class='cart_item_title'>$item[post_title]<br>$variations".$cart_item_info."</td>"
			//. "<td class='cart_item_unit_price' $discount_style ><span class='ttip' title='$discount_title'>".$currency_sign.number_format($item[price],2,".","")."</span></td>"
		   // . "<td class=''>"  .$currency_sign.number_format($var['discount_amount'],2,'.','') . "</td>"
			//. "<td><input style='$coupon_style' title='$title' type='text' name='cart_items[$item[ID]][coupon]' value='$item[coupon]' id='$item[ID]' class='ttip' size='5' /></td>"
			. "<td class='cart_item_quantity'><input type='text' name='cart_items[$item[ID]][quantity]' value='$item[quantity]' size='5' /></td>"
			//. "<td class='cart_item_subtotal amt'>".$currency_sign.number_format((($item['price']+$item['prices'])*$item['quantity'])-$item['coupon_amount'] - $item['discount_amount'],2,".","")."</td>"
			. "</tr>";
			 $variations='';
			endif;
			
			}
		}
		wpmpz_get_cart_total();
		$extra_row = '';
		$xcart .= apply_filters('odudes_cart_extra_row',$extra_row);

		$xcart .= "

		
		<tr><td colspan=2><button type='button' class='pure-button' onclick='location.href=\"".$settings['continue_shopping_url']."\"'><i class='fa fa-repeat'></i> ".__("Continue Enquiry","odudeshop")."</button></td>
		<td align=right class='text-right'>
		<button class='pure-button' type='button' onclick='document.getElementById(\"cart_form\").submit();'><i class='fa fa-pencil-square'></i> ".__("Update Quantity","odudeshop")."</button>
		<button class='pure-button pure-button-primary' type='button' onclick='location.href=\"".get_permalink($settings['check_page_id'])."\"'><i class='fa fa-shopping-cart fa-lg'></i> ".__("Checkout","odudeshop")."</button>
		</td></tr>
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
			
		jQuery(function(){
			jQuery('.ttip').tooltip();
		});
			  
		//-->
		</script>

		";

		if(count($cart_data)==0) $xcart = __("No item in cart.","odudeshop")."<br/><a href='".$settings['continue_shopping_url']."'>".__("Continue Enquiry","odudeshop")."</a>";
