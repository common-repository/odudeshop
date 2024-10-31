<?php //print_r($settings);?>
<div id="stock-options" class="section" style="display: block;"><h3><?php echo __("Stock Options","odudeshop");?></h3>
<table class="form-table">

                    <tbody>
                    <tr valign="top" class="">
                    <th class="titledesc" scope="row"><?php echo __("Manage stock","odudeshop");?></th>
                    <td class="forminp">
                    <label for="calc_shipping">
                    <input type="checkbox" value="1" <?php if(isset($settings['stock']['enable']) && $settings['stock']['enable']==1)echo "checked='checked'";?> id="calc_shipping" name="_odudes_settings[stock][enable]">
                    <?php echo __("Enable stock management","odudeshop");?></label><br>
                                    
                                        
                    </td>
                    </tr>
                    <tr valign="top" class="">
                    <th class="titledesc" scope="row"><?php echo __("Enable Global Low stock (For All Product)","odudeshop");?></th>
                    <td class="forminp">                   
                    <input type="checkbox" class="global_low_stock" <?php if(isset($settings['stock']['enable_low_stock']) && $settings['stock']['enable_low_stock']==1)echo 'checked="checked"';?> value="1"  name="_odudes_settings[stock][enable_low_stock]">                   
                    </td>
                    </tr> 
					
					<tr valign="top" id="low_stock_row">
                    <th class="titledesc" scope="row"><?php echo __("Low stock threshold for all product ","odudeshop");?></th>
                    <td class="forminp"> 
<?php
$low='0';
if(isset($settings['stock']['low_stock']))
if($settings['stock']['low_stock']) 
	$low= $settings['stock']['low_stock'];
else
	$low= '0';
?>					
                    <input type="text" class="currency_symbol" value="<?php echo $low; ?>"  name="_odudes_settings[stock][low_stock]">                   
                    </td>
                    </tr>
                    
                    <tr valign="top" id="low_stock_row">
                    <th class="titledesc" scope="row"><?php echo __("Admin notification on low stock threshold","odudeshop");?> </th>
                    <td class="forminp">                   
                    <input type="checkbox"  value="1" <?php if(isset($settings['stock']['low_stock_notification']) && $settings['stock']['low_stock_notification']==1)echo 'checked="checked"';?>  name="_odudes_settings[stock][low_stock_notification]">                   
                    </td>
                    </tr> 
					
                    <tr valign="top" class="">
                    <th class="titledesc" scope="row"><?php echo __("Stock Reduce","odudeshop");?></th>
                    <td class="forminp">
                    
                    <input type="checkbox"  value="1" <?php if(isset($settings['stock']['reduce_auto']) && $settings['stock']['reduce_auto']==1) echo "checked=checked";?>  name="_odudes_settings[stock][reduce_auto]"> <?php echo __("Enable Stock Reduce Automatically","odudeshop");?>
                   
                    </td>
                    </tr>
                     </tbody></table>                        
                       
                        



                        </div>
                        
                        
    
    