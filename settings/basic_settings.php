		<input type="hidden" name="_odudes_settings[whatsell]" id="whatsell" value="<?php echo $whatsell; ?>">
	<input type="hidden" value="1" id="setup" name="_odudes_settings[setup]">
<input type="hidden" name="_odudes_settings[generate_product_page_content]" value="1">
<input type="hidden" name="action" value="odudes_save_settings">
 <?php

			if($whatsell=='d')
			{
				//$_odudes_settings['_odudes_settings[stock][enable]'] = 0;
				//$_odudes_settings['_odudes_settings[calc_shipping]'] = 0;
				//update_option('_odudes_settings',$_odudes_settings);
				
			echo '<input type="hidden" value="0" id="calc_shipping" name="_odudes_settings[stock][enable]">';
			echo '<input type="hidden" value="0" id="calc_shipping" name="_odudes_settings[calc_shipping]">';
			}
		?>
		
<div>
<div class="">
 <input type="checkbox" name="_odudes_settings[setup]" id="setup" value="0" > <?php echo __("Restart Setup ?","odudeshop");?>
 <br>
 <b>Note:</b> All the settings will be lost. So use it only if it is very very importat.
</div>
<br>
Shopping URL :<?php echo $shoppingurl; ?> ( don't create any page or post with prodcut as slug name.)

<hr>
<br><br>
<b><?php echo __("Which button to show ?","odudeshop");?></b>
<input type="radio" name="_odudes_settings[showcart]" id="showcart" value="1" <?php if(!empty($showcart)){if($showcart=="1")echo 'checked="checked"';}else echo 'checked="checked"';?>> <?php echo __("Add to cart","odudeshop");?>  
 <input type="radio" name="_odudes_settings[showcart]" id="showcart" value="2"  <?php if($showcart=="2")echo 'checked="checked"';?>  > <?php echo __("Add to Enquiry","odudeshop");?>
 <input type="radio" name="_odudes_settings[showcart]" id="showcart" value="0"  <?php if($showcart=="0")echo 'checked="checked"';?>  > <?php echo __("Nothing","odudeshop");?>
<br><br>

<b><?php echo __("Purchasing Style ?","odudeshop");?></b>
<input type="radio" name="_odudes_settings[user-reg]" id="user-reg" value="1" <?php if(!empty($userreg)){if($userreg=="1")echo 'checked="checked"';}else echo 'checked="checked"';?>> <?php echo __("Force Registration","odudeshop");?>  
 <input type="radio" name="_odudes_settings[user-reg]" id="user-reg" value="0"  <?php if($userreg=="0")echo 'checked="checked"';?>  > <?php echo __("No Registration","odudeshop");?>
 <br><br>

<b><?php echo __("Show Price only to ODudeShop Buyer user Role ?","odudeshop");?></b>
<input type="radio" name="_odudes_settings[hide_price]" id="hide_price" value="1" <?php if(!empty($hide_price)){if($hide_price=="1")echo 'checked="checked"';}else echo 'checked="checked"';?>> <?php echo __("Yes","odudeshop");?>  
 <input type="radio" name="_odudes_settings[hide_price]" id="hide_price" value="0"  <?php if($hide_price=="0")echo 'checked="checked"';?>  > <?php echo __("No, Show to Everyone","odudeshop");?>
<br><br>



<b><?php echo __("Cart Page :","odudeshop");?> </b>
<?php 
if(isset($settings['page_id']))
{
if($settings['page_id'])
$args = array(
    'name'             => '_odudes_settings[page_id]',
    'selected' => $settings['page_id']
    );
else
 $args = array(
    'name'             => '_odudes_settings[page_id]'
    );
wp_dropdown_pages($args); 
}
else
{
	 $args = array(
    'name'             => '_odudes_settings[page_id]'
    );
wp_dropdown_pages($args); 
}
?>
<br><br>
 
<b><?php echo __("Checkout Page :","odudeshop");?> </b>
<?php 
if(isset($settings['check_page_id']))
{
if($settings['check_page_id'])
$args = array(
    'name'             => '_odudes_settings[check_page_id]',
    'selected' => $settings['check_page_id']
    );
else
 $args = array(
    'name'             => '_odudes_settings[check_page_id]'
    );
wp_dropdown_pages($args); 
}
else
{
	$args = array(
    'name'             => '_odudes_settings[check_page_id]'
    );
wp_dropdown_pages($args); 
}
?>
<br><br>


 <b><?php echo __("Orders Page :","odudeshop");?> </b>
<?php
if(isset($settings['orders_page_id']))
{
if($settings['orders_page_id'])
$args = array(
    'name'             => '_odudes_settings[orders_page_id]',
    'selected' => $settings['orders_page_id']
    );
else
 $args = array(
    'name'             => '_odudes_settings[orders_page_id]'
    );
wp_dropdown_pages($args);
}
else
{
	$args = array(
    'name'             => '_odudes_settings[orders_page_id]'
    );
wp_dropdown_pages($args);
}
?>
<br><br>
<b><?php echo __("System URL:","odudeshop");?></b> :<input type="text" name="_odudes_settings[continue_shopping_url]" size="80" id="continue_shopping_url" value="<?php if(isset($settings['continue_shopping_url'])) echo $settings['continue_shopping_url']; else echo $shoppingurl;?>" />
<br><br>
<?php
update_option('_odudes_curr_name',$settings['cur_code']);	
update_option('_odudes_curr_sign',$settings['cur_sign']);	

?>
<b>Currency Sign</b>:<input type="text" name="_odudes_settings[cur_sign]" size="10" id="cur_sign" value="<?php if(isset($settings['cur_sign'])) echo $settings['cur_sign']; else echo '$';?>"  class="currency_symbol" /> -
<b>Currency Code</b>:<input type="text" name="_odudes_settings[cur_code]" size="10" id="cur_code" value="<?php if(isset($settings['cur_code'])) echo $settings['cur_code']; else echo 'USD';?>" class="currency_symbol" /><br><br>
<?php

//Creating user Role

   $result = add_role(
    'odude_buyer',
    __( 'ODudeShop Buyer' ),
    array(
        'read'         => true,  // true allows this capability
			'level_0' => true
    )
);
if ( null !== $result ) 
{
    echo 'Yay! New role ODudeShop Buyer created!';
}
else {
    echo 'ODudeShop Buyer is ready !!';
}



    do_action("basic_settings");
?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#allowed_cn').on('click', function () {
            $(this).closest('ul').find(':checkbox').prop('checked', this.checked);
        });
    });
    
</script>    