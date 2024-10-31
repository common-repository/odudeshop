<?php  
//order view front end
global $wpdb, $sap;
$orderurl = get_permalink(get_the_ID());
$loginurl = home_url("/wp-login.php?redirect_to=".urlencode($orderurl));
$_ohtml ="";
if ( !is_user_logged_in() ) 
{
$_ohtml =<<<SIGNIN
      
<center>
Please <a href="{$loginurl}" class="simplemodal-login"><b>Log In or Register</b></a> to access this page
</center>

SIGNIN;
	
if(isset($_SESSION["oid_for_nouser"]))
{


$_ohtml.="<br>Your Last Order ID :".$_SESSION["oid_for_nouser"];
 $_ohtml.="<br>Message: ".$_SESSION["msg"];
} 
} 
else 
{
	if(!isset($_GET['id']) && !isset($_GET['item']) )
	{
	   include("user_order_list.php"); 
	}
		
	
	$odetails   = __("Order Details","odudeshop");
	$ostatus    = __("Order Status","odudeshop");
	$prdct      = __("Product","odudeshop");
	$qnt        = __("Quantity","odudeshop");
	$unit       = __("Unit Price","odudeshop");
	$coup       = __("Coupon Discount","odudeshop");
	$role_dis   = __("Role Discount","odudeshop");
	$ttl        = __("Total","odudeshop");
	$dnl        = __("Download","odudeshop");
	$csign = get_option('_odudes_curr_sign','$');

	//if($_GET['id']!='' && $_GET['item']=='')
	if(isset($_GET['id']))
	{
	$order = $order->GetOrder($_GET['id']);
	$cart_data = unserialize($order->cart_data);
	$items = Order::GetOrderItems($order->order_id);
	$order->title = $order->title?$order->title:'Order # '.$order->order_id;
	
	$dsct=__("Discount","odudeshop");
	$shping=__("Shipping","odudeshop");
	$cdetails=__("Customer details","odudeshop");
	$eml=__("Email","odudeshop");
	$bling=__("Billing Address","odudeshop");
	$shing_ad=__("Shipping Address","odudeshop");
	$vdlink=__("Payment status is not yet marked as completed.","odudeshop");
	$pnow=__("Pay or Wait","odudeshop");

	$usermeta=unserialize(get_user_meta($order->uid, 'user_billing_shipping',true));
	@extract($usermeta);
	$order->shipping_cost = number_format($order->shipping_cost,2,".","");
	$order->total = number_format($order->total,2,".","");
	$date = date("Y-m-d h:i a",$order->date);
	//echo "<pre> order items = "; print_r($items); echo "</pre>";
		$settings = maybe_unserialize(get_option('_odudes_settings'));
$message=$settings[$order->payment_method]['Message'];
	$odude_order='';
	
	//print_r($order);
	$odude_order.='
		<div class="pure-g">
		<div class="pure-u-1 pure-u-md-1-2">
		Order No.'.$order->order_id.'
	<br>Issued: '.$date.'
	<br>'.$current_user->user_email.'
	<br>Order Notes: '.$order->order_notes.'
	</div>
    <div class="pure-u-1 pure-u-md-1-2"> 
	Payment Status: '.$order->payment_status.'
	<br>Order Status: '.$order->order_status.'
	<br>Payment Method : '.$order->payment_method.'<br><pre>'.$message.'</pre>
	Shipping Method : '.$order->shipping_method.'
	
	</div>
    </div>';

	$odude_order.='
	<br>
	<table class="pure-table pure-table-horizontal">
		<thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Discount</th>
			<th>Total</th>
			<th>Download</th>
        </tr>
    </thead>

    <tbody>';
	

	
	$total=0;

	$user = new WP_User( $order->uid );
	$role = $user->roles[0];
	foreach($cart_data as $pid => $item)
	{
		$meta = get_post_meta($pid,"odudes_list_opts",true);
		if(isset($meta['digital_activate']))
		$digital_activate = $meta['digital_activate'];
	
		if(isset($item['item'])):
		
			foreach ($item['item'] as $id => $var):
				if(!isset($var['coupon_amount']) || $var['coupon_amount'] == "") 
				{
					$var['coupon_amount'] = 0;
				}

				if(!isset($var['discount_amount']) || $var['discount_amount'] == "")
				{
					$var['discount_amount'] = 0;
				}

				//echo $var['coupon_amount'] . ' ' . $var['discount_amount'] . "<br>";
				$vari = isset($var['variations']) && !empty($var['variations']) ? implode(', ', $var['variations']) : '';
				$total = (($item['price'] + $var['prices']) * $var['quantity']) - $var['discount_amount'] - $var['coupon_amount'];
				$pro_link=get_post_permalink( $item['ID']);
				$odude_order.="
						<tr class='item'>
							<td><a href='{$pro_link}' target='_blank'> {$item['post_title']} </a><br>{$vari}</td>
							<td>{$var['quantity']}</td>
							<td>{$csign}{$item['price']}</td>
							<td>{$csign}{$var['coupon_amount']}</td>
							<td class='text-right' align='right'>{$csign}{$total}</td>";
							

				$download_link = home_url("/?odudefile={$pid}&oid={$order->order_id}");       
				if($digital_activate)
				{
					if($order->payment_status=='Completed')
					{
					$odude_order.='<td class="text-right" align="right"><a href="'.$download_link.'">'.$dnl.'</a></td>                        
										</tr>';

					}
					else
					{
					$odude_order.='<td  class="text-right" align="right">&mdash;</td></tr>';

					}
				} 
				else 
				{
					$odude_order.="<td  class='text-right' align='right'>&mdash;</td></tr>";

				}
				
				$order_item = apply_filters("odudes_order_item","",$pid,$order->order_id);
				
				if($order_item!='')
					$odude_order.="<tr><td colspan='7'>".$order_item."</td></tr>";
				
			endforeach;
		else:
			
			if(!isset($item['coupon_amount']) || $item['coupon_amount'] == "") 
			{
				$item['coupon_amount'] = 0;
			}

			if(!isset($item['discount_amount']) || $item['discount_amount'] == "")
				{
				$item['discount_amount'] = 0;
			}

			//echo $item['coupon_amount'] . ' ' . $item['discount_amount'] . "<br>";
			$vari = isset($item['variations']) && !empty($item['variations']) ? implode(', ', $item['variations']) : '';
			$total = (($item['price'] + $item['prices']) * $item['quantity']) - $item['discount_amount'] - $item['coupon_amount'];
			$pro_link=get_post_permalink( $item['ID']);
			$odude_order.= "<tr class='item'>
							<td><a href='{$pro_link}' target='_blank'> {$item['post_title']} </a> <br>{$vari}</td>
							<td>{$item['quantity']}</td>
							<td>{$csign}{$item['price']}</td>
							<td>{$csign}{$item['coupon_amount']}</td>
							<td class='text-right' align='right'>{$csign}{$total}</td>";
							

				$download_link = home_url("/?odudefile={$pid}&oid={$order->order_id}");       
				if(isset($digital_activate))
				{
					if($order->payment_status=='Completed')
					{
					$odude_order.="<td class='text-right' align='right'><a href='$download_link'>$dnl</a></td></tr>";
					}
					else
					{
					$odude_order.="<td  class='text-right' align='right'>&mdash;</td></tr>";

					}				
				} 
				else 
				{
					$odude_order.="<td  class='text-right' align='right'>&mdash;</td></tr>";

				}
				
				$order_item = apply_filters("odudes_order_item","",$pid,$order->order_id);
				
				if($order_item!='')
					$_ohtml.="<tr><td colspan='7'>".$order_item."</td></tr>";
			
		endif;
		
		
		
			
		//$licenseurl = home_url("/?task=getlicensekey&file={$itemid}&oid={$order->order_id}");  
		
	 

	}
	

$odude_order.="<tr class='item'>
                        <td colspan='4' class='text-right' align='right'><b>$shping</b></td>                        
                        <td class='text-right' align='right'><b>{$csign}{$order->shipping_cost}</b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class='item'>
                        <td colspan='4' class='text-right' align='right'><b>$ttl</b></td>                        
                        <td class='text-right' align='right'><b>{$csign}{$order->total}</b> </td>
                        <td>&nbsp;</td>
                    </tr>";
	
	$odude_order.='</tbody></table>';	
	$odude_order.="<a href='".get_edit_user_link()."'>Update your Address</a><br>";
	
		$odude_order.="
	<div class='pure-g'>
    <div class='pure-u-1 pure-u-md-1-2'>
	
	      <header class='title'>
            <h3>$bling</h3>
        </header>
        <address><p>
            $billing[first_name] $billing[last_name]<br>
$billing[company]<br>
$billing[address_1]<br>
$billing[address_2]<br>
$billing[city]<br>
$billing[state]<br>
$billing[postcode]<br>
$billing[country]        </p></address>
	
	</div>
    <div class='pure-u-1 pure-u-md-1-2'> 
 <header class='title'>
            <h3>$shing_ad</h3>
        </header>
        <address><p>
            $shippingin[first_name] $shippingin[last_name]<br>
$shippingin[company]<br>
$shippingin[address_1]<br>
$shippingin[address_2]<br>
$shippingin[city]<br>
$shippingin[state]<br>
$shippingin[postcode]<br>
$shippingin[country]        </p></address>
	
	</div>
    </div>";
	
	$odude_order.='
	<div class="pure-g">
    <div class="pure-u-1 pure-u-md-1-2">
	&nbsp;
	</div>
    <div class="pure-u-1 pure-u-md-1-2">'; 
	
	
	if($order->payment_status!='Completed')
	{
    $purl = home_url('/?pay_now='.$order->order_id);
   
   $odude_order.="$vdlink <div id='proceed_{$order->order_id}' class='pull-right'>    
          <a class='btn' onclick='return proceed2payment_{$order->order_id}(this)' href='#'><b>$pnow</b></a>        
         <script>
         function proceed2payment_{$order->order_id}(ob){
            jQuery('#proceed_{$order->order_id}').html('Processing...');
             
            jQuery.post('{$purl}',{action:'odudes_pp_ajax_call',execute:'PayNow',order_id:'{$order->order_id}'},function(res){
                jQuery('#proceed_{$order->order_id}').html(res);
                });
                
                return false;
         }
         </script>
     
    </div>
	";
	
	}
	$homeurl = home_url('/');
	$odude_order.="</table>
	<script language='JavaScript'>
	<!--
	  function getkey(file, order_id)
	  {
		  jQuery('#lic_'+file+'_'+order_id).html('Please Wait...');
		  jQuery.post('{$homeurl}',{action:'wpdm_pp_ajax_call',execute:'getlicensekey',fileid:file,orderid:order_id},function(res){
			   jQuery('#lic_'+file+'_'+order_id).html(\"<input type=text style='width:150px;border:0px' readonly=readonly onclick='this.select()' value='\"+res+\"' />\");
		  });
	  }
	//-->
	</script>";    
	
	
	$odude_order.='</div></div>';
	$_ohtml.=$odude_order;
	//echo $odude_order;

	}
    
}
?>