<?php //print_r($settings);?>



<div id="shipping-options" class="section" style="display: block;"><h3><?php echo __("Shipping Options","odudeshop");?></h3>
<table class="form-table">

                    <tbody><tr valign="top" class="">
                    <th class="titledesc" scope="row"><?php echo __("Shipping calculations","odudeshop");?></th>
                    <td class="forminp">
                        <fieldset>
                                    <legend class="screen-reader-text"><span><?php echo __("Shipping calculations","odudeshop");?></span></legend>
                    <label for="calc_shipping">
                        <input type="checkbox" value="1" <?php if(isset($settings['calc_shipping']) && $settings['calc_shipping']==1)echo "checked='checked'";?> id="calc_shipping" name="_odudes_settings[calc_shipping]">
                    <?php echo __("Enable shipping","odudeshop");?></label><br>
                                    </fieldset>
                                        
                    </td>
                    </tr>
                                                            </tbody></table>   
<?php


/*                      <h3><?php echo __("Shipping Methods","odudeshop");?></h3>
                       
                        



                        <table cellspacing="0" class=" widefat">
                            <thead>
                                <tr>
                                    <th><?php echo __("Default","odudeshop");?></th>
                                    <th><?php echo __("Shipping Method","odudeshop");?></th>
                                    <th><?php echo __("Status","odudeshop");?></th>
                                </tr>
                            </thead>
                            <tbody class="ui-sortable" style="">
                                <tr style="">
                                    <td width="1%" class="radio">
                                        <input type="radio" <?php if(isset($settings['default_shipping_method'])) if($settings['default_shipping_method']=="flat_rate")echo "checked='checked'";?> value="flat_rate" name="_odudes_settings[default_shipping_method]">
                                        
                                        </td><td>
                                            <p><strong><?php echo __("Flat Rate / Pickup","odudeshop");?></strong><br>
                                            </p>
                                        </td>
                                        <td>Active</td>
                                    </tr><tr style="">
                                    <td width="1%" class="radio">
                                        <input type="radio" <?php if(isset($settings['default_shipping_method'])) if($settings['default_shipping_method']=="free_shipping")echo "checked='checked'";?> value="free_shipping" name="_odudes_settings[default_shipping_method]">

                                        </td><td>
                                            <p><strong><?php echo __("Free Shipping","odudeshop");?></strong><br>
                                            </p>
                                        </td>
                                        <td>Active</td>
                                    </tr><tr style="">
                                    <td width="1%" class="radio">
                                        <input type="radio" <?php if(isset($settings['default_shipping_method'])) if($settings['default_shipping_method']=="local-delivery")echo "checked='checked'";?> value="local-delivery" name="_odudes_settings[default_shipping_method]">
                                        
                                        </td><td>
                                            <p><strong><?php echo __("Local Delivery","odudeshop");?></strong><br>
                                           </p>
                                        </td>
                                        <td>Active</td>
                                    </tr></tbody>
                        </table> */
						
						?>
                        <div style="clear: both;margin-top:20px ;"></div>
                        <h3><?php echo __("Shipping Methods Configuration","odudeshop");?></h3>
                        <div id="saccordion">
    <h3><a href="#"><?php echo __("Flat Rate / Pickup","odudeshop");?></a></h3>
    <div>   
    <table class="form-table">
        <tbody><tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Enable/Disable","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Enable/Disable","odudeshop");?></span></legend>
<label for="flat_rate_enabled"><input type="checkbox" <?php if(isset($settings['flat_rate_enabled']) && $settings['flat_rate_enabled']==1)echo "checked='checked'";?> class=""  value="1" id="flat_rate_enabled" name="_odudes_settings[flat_rate_enabled]" style=""> <?php echo __("Enable this shipping method","odudeshop");?></label><br>
</fieldset></td>
</tr>
<tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Title","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Title","odudeshop");?></span></legend>
<label for="flat_rate_title"><input type="text" value="<?php if(isset($settings['flat_rate_title'])) echo $settings['flat_rate_title'];?>" style="" id="flat_rate_title" name="_odudes_settings[flat_rate_title]" class="input-text wide-input "><span class="description"><?php echo __("This controls the title which the user sees during checkout.","odudeshop");?></span>
</label></fieldset></td>
</tr>

<input type="hidden" id="flat_rate_tax_status" name="_odudes_settings[flat_rate_tax_status]" value="none">
<tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Default Cost","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Default Cost","odudeshop");?></span></legend>
<label for="flat_rate_cost"><input type="text" value="<?php if(isset($settings['flat_rate_cost'])) echo  $settings['flat_rate_cost'];?>" style="" id="flat_rate_cost" name="_odudes_settings[flat_rate_cost]" class="input-text wide-input "><span class="description"><?php echo __("Cost excluding tax. Enter an amount, e.g. 2.50.","odudeshop");?></span>
</label></fieldset></td>
</tr>
<tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Default Handling Fee","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Default Handling Fee","odudeshop");?></span></legend>
<label for="flat_rate_fee"><input type="text" value="<?php if(isset($settings['flat_rate_fee'])) echo $settings['flat_rate_fee'];?>" style="" id="flat_rate_fee" name="_odudes_settings[flat_rate_fee]" class="input-text wide-input "><span class="description"><?php echo __("Fee excluding tax. Enter an amount, e.g. 2.50.","odudeshop");?></span>
</label></fieldset></td>
</tr>
<tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Instruction Note","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Instruction Note","odudeshop");?></span></legend>
<label for="flat_rate_msg"><textarea name="_odudes_settings[flat_rate_msg]" id="flat_rate_msg"><?php if(isset($settings['flat_rate_msg'])) echo $settings['flat_rate_msg'];?></textarea><span class="description"><?php echo __("Message for client.","odudeshop");?></span>
</label></fieldset></td>
</tr>
                    </tbody></table>
    
    </div>
    <h3><a href="#"><?php echo __("Free Shipping","odudeshop");?></a></h3>
    <div>
    <div id="shipping-free_shipping" class="section" style="display: block;"> <h3>Free Shipping</h3>
        
        <table class="form-table">
        <tbody><tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Enable/Disable","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Enable/Disable","odudeshop");?></span></legend>
<label for="free_shipping_enabled"><input type="checkbox" class="" <?php if(isset($settings['free_shipping_enabled']) && $settings['free_shipping_enabled']==1)echo "checked='checked'";?>  value="1" id="free_shipping_enabled" name="_odudes_settings[free_shipping_enabled]" style=""> <?php echo __("Enable Free Shipping","odudeshop");?></label><br>
</fieldset></td>
</tr>
<tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Title","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Method Title","odudeshop");?></span></legend>
<label for="free_shipping_title"><input type="text" value="<?php if(isset($settings['free_shipping_title'])) echo $settings['free_shipping_title'];?>" style="" id="free_shipping_title" name="_odudes_settings[free_shipping_title]" class="input-text wide-input "><span class="description"><?php echo __("This controls the title which the user sees during checkout.","odudeshop");?></span>
</label></fieldset></td>
</tr>
<tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Minimum Order Amount","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span>Minimum Order Amount</span></legend>
<label for="free_shipping_min_amount"><input type="text" value="<?php if(isset($settings['free_shipping_min_amount'])) echo $settings['free_shipping_min_amount'];?>" style="" id="free_shipping_min_amount" name="_odudes_settings[free_shipping_min_amount]" class="input-text wide-input "><span class="description"><?php echo __("Users will need to spend this amount to get free shipping.","odudeshop");?></span>
</label></fieldset></td>
</tr>
<tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Instruction Note","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Instruction Note","odudeshop");?></span></legend>
<label for="free_shipping_msg"><textarea name="_odudes_settings[free_shipping_msg]" id="free_shipping_msg"><?php if(isset($settings['free_shipping_msg'])) echo $settings['free_shipping_msg'];?></textarea><span class="description"><?php echo __("Message for client.","odudeshop");?></span>
</label></fieldset></td>
</tr>
        </tbody></table>
        </div>
    </div>
    <h3><a href="#"><?php echo __("Local Delivery","odudeshop");?></a></h3>
    <div>
    <div id="shipping-local-delivery" class="section" style="display: block;">        <h3><?php echo __("Local Delivery","odudeshop");?></h3>
        <p><?php echo __("Local delivery is a simple shipping method for delivering orders locally.","odudeshop");?></p>
        <table class="form-table">
            <tbody><tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Enable","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Enable","odudeshop");?></span></legend>
<label for="local-delivery_enabled"><input type="checkbox" class="" <?php if(isset($settings['local-delivery_enabled']) && $settings['local-delivery_enabled']==1)echo "checked='checked'";?>  value="1" id="local-delivery_enabled" name="_odudes_settings[local-delivery_enabled]" style=""><?php echo __(" Enable local delivery","odudeshop");?></label><br>
</fieldset></td>
</tr>
<tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Title","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Title","odudeshop");?></span></legend>
<label for="local-delivery_title"><input type="text" value="<?php if(isset($settings['local-delivery_title'])) echo $settings['local-delivery_title'];?>" style="" id="local-delivery_title" name="_odudes_settings[local-delivery_title]" class="input-text wide-input "><span class="description"><?php echo __("This controls the title which the user sees during checkout.","odudeshop");?></span>
</label></fieldset></td>
</tr>
<tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Fee Type","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Fee Type","odudeshop");?></span></legend>
<label for="local-delivery_type">
<select class="select " style="" id="local-delivery_type" name="_odudes_settings[local-delivery_type]">
<option value="free" <?php if(isset($settings['local-delivery_type'])) if($settings['local-delivery_type']=="free")echo "selected='selected'";?>>Free Delivery</option>
<option  value="fixed" <?php if(isset($settings['local-delivery_type'])) if($settings['local-delivery_type']=="fixed")echo "selected='selected'";?>>Fixed Amount</option>
<option value="percent" <?php if(isset($settings['local-delivery_type'])) if($settings['local-delivery_type']=="percent")echo "selected='selected'";?>>Percentage of Cart Total</option></select><span class="description"><?php echo __("How to calculate delivery charges","odudeshop");?></span>
</label></fieldset></td>
</tr>
<tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Fee","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Fee","odudeshop");?></span></legend>
<label for="local-delivery_fee"><input type="text" value="<?php  if(isset($settings['local-delivery_fee'])) echo $settings['local-delivery_fee'];?>" style="" id="local-delivery_fee" name="_odudes_settings[local-delivery_fee]" class="input-text wide-input "><span class="description"><?php echo __("What fee do you want to charge for local delivery, disregarded if you choose free.","odudeshop");?></span>
</label></fieldset></td>
</tr>
<tr valign="top">
<th class="titledesc" scope="row"><?php echo __("Instruction Note","odudeshop");?></th>
<td class="forminp">
<fieldset><legend class="screen-reader-text"><span><?php echo __("Instruction Note","odudeshop");?></span></legend>
<label for="local-delivery_msg"><textarea name="_odudes_settings[local-delivery_msg]" id="local-delivery_msg"><?php if(isset($settings['local-delivery_msg'])) echo $settings['local-delivery_msg'];?></textarea><span class="description"><?php echo __("Message for client.","odudeshop");?></span>
</label></fieldset></td>
</tr>
        </tbody></table> </div>
    </div>
    <?php
    do_action("odudes_new_shipping_method");
?>
</div>

                        </div>
                        
                        <script>
    jQuery(function() {
        jQuery( "#saccordion" ).accordion({
            autoHeight: false,
            navigation: true});
    });
    
    </script>
    <style type="text/css">
    .ui-accordion-content-active{
        height: auto !important;
    }
    </style>
    
    