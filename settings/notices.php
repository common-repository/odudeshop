This will display some text as in below box to the fixed location. This will work as a information or guide to the visitors.<br>
<br><br>

						
<b><?php echo __("Product Detail - Position 1","odudeshop");?></b>
<?php

$args = array(
    'textarea_rows' => 5,
	'media_buttons' => false,
	'quicktags'=>true
);

if(isset($settings['msg_product_position1']))
	$content=$settings['msg_product_position1']; 
else 
	$content="";
$editor_id = '_odudes_settings[msg_product_position1]';

wp_editor( $content, $editor_id,$args );
?>
<br>
<b><?php echo __("Product Detail - Position 2","odudeshop");?></b> <br><?php echo __("3rd Party Shortcode to Execute","odudeshop");?> :
<br>
 <textarea type="text" name="_odudes_settings[short_msg_product_position2]"  id="short_msg_product_position2"><?php if(isset($settings['short_msg_product_position2'])) echo stripslashes($settings['short_msg_product_position2']); else echo '';?></textarea><br><br>
 <b><?php echo __("Product Detail - Position 3","odudeshop");?></b> <br><?php echo __("3rd Party Shortcode to Execute","odudeshop");?> :
<br>
 <textarea type="text" name="_odudes_settings[short_msg_product_position3]"  id="short_msg_product_position3"><?php if(isset($settings['short_msg_product_position3'])) echo stripslashes($settings['short_msg_product_position3']); else echo '';?></textarea><br><br>
<hr>

<b><?php echo __("Bottom of My Cart","odudeshop");?></b> 
<?php
if(isset($settings['msg_cart_top']))
	$content=$settings['msg_cart_top']; 
else 
	$content="";
$editor_id = '_odudes_settings[msg_cart_top]';

wp_editor( $content, $editor_id,$args );
?><br>
<br>
<b><?php echo __("Top of My Cart","odudeshop");?></b> <br><?php echo __("3rd Party Shortcode to Execute","odudeshop");?> :
<br>
 <textarea type="text" name="_odudes_settings[short_msg_cart_top]"  id="short_msg_cart_top"><?php if(isset($settings['short_msg_cart_top'])) echo stripslashes($settings['short_msg_cart_top']); else echo '';?></textarea><br><br>
 <hr>

<b><?php echo __("Top of Checkout","odudeshop");?></b> 
<?php
if(isset($settings['msg_checkout_top']))
	$content=$settings['msg_checkout_top']; 
else 
	$content="";
$editor_id = '_odudes_settings[msg_checkout_top]';

wp_editor( $content, $editor_id,$args );
?>
<br>
<b><?php echo __("Top of My Orders","odudeshop");?></b> 
<?php
if(isset($settings['msg_orders_top']))
	$content=$settings['msg_orders_top']; 
else 
	$content="";
$editor_id = '_odudes_settings[msg_orders_top]';

wp_editor( $content, $editor_id,$args );
?>