If you want the buyer total order amount should be minimum of entered amount.<br>
Note: Tax, shipping cost excluded.
<br>
Eg. Someone purchased only of $5 and you have offered Delivery Free than it will not cost your meet. Hence you can enable it as required.
<br><br>
<b><?php echo __("Cart Minimum Amount","odudeshop");?></b> :<input type="text" name="_odudes_settings[min_amt]" size="80" id="min_amt" value="<?php if(isset($settings['min_amt'])) echo $settings['min_amt']; else echo 0;?>" class="currency_name" />
<br><br>
 <input type="checkbox" value="1" <?php if(isset($settings['purchase']['enable']) && $settings['purchase']['enable']==1)echo "checked='checked'";?> id="purchase_qty" name="_odudes_settings[purchase][enable]">
                    <b><?php echo __("Enable Purchase Minium Quanity","odudeshop");?></b> <br><?php echo __("You can set each product the minimum number of quantity the user should add into the cart.","odudeshop");?>