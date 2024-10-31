<?php
 $settings = maybe_unserialize(get_option('_odudes_settings'));
	  if(isset($settings['msg_orders_top']))
		  $msg_orders_top=$settings['msg_orders_top'] ;
	  else
		  $msg_orders_top="" ;
	  
//Frontend Order List
    $orderid=__("Order Id","odudeshop");
    $date=__("Date","odudeshop");
    $payment_status=__("Payment Status","odudeshop");
	$_ohtml =$msg_orders_top.'<br><a href="'.get_edit_user_link().'">Update your Address</a><hr>';
$_ohtml .= <<<ROW
<table width="100%" cellspacing="0" class="pure-table pure-table-horizontal">
  <thead>
<tr>
    <th>$orderid</th>
    <th>$date</th>
    <th style="width: 180px;">$payment_status</th>
    
</tr>
</thead>
ROW;


foreach($myorders as $order)
{ 
    $date = date("Y-m-d h:i a",$order->date);
    $items = unserialize($order->items);    
    //if($dashboard){
      //  $zurl = $orderurl . $sap."section=my-orders-sc&";
    //}
   // else {
        $zurl = $orderurl . $sap;
    //}
    $nonce = wp_create_nonce("delete_order");
    //$link = admin_url('admin-ajax.php?action=odudes_delete_frontend_order&id='.$order->order_id.'&nonce='.$nonce);
    /*
	$_ohtml .= <<<ROW
                    <tr class="order">
                        <td><a href='{$zurl}id={$order->order_id}'>{$order->order_id}</a><div class="row-actions">
<span class="trash"><a href="#" class="delete_order" order_id="{$order->order_id}" nonce="$nonce">Delete</a></span></div></td>
                        <td>{$date}</td>
                        <td>{$order->order_status}</td>
                        
                    </tr>                    
ROW;
*/
	$_ohtml .= <<<ROW
                    <tr>
                        <td><a href='{$zurl}id={$order->order_id}'>{$order->order_id}</a></td>
                        <td>{$date}</td>
                        <td>{$order->order_status}</td>
                        
                    </tr>                    
ROW;
}
$homeurl = home_url('/');
$_ohtml .=<<<END
</table>


END;

$link = admin_url('admin-ajax.php');
$_ohtml = "<div class='odude-shop'>{$_ohtml}</div>"; 

//echo $_ohtml;

?>