<fieldset>
        <legend><?php echo __("Billing Address", "odudeshop"); ?></legend>
		<?php
					$settings = maybe_unserialize(get_option('_odudes_settings'));   
				$whatsell=$settings['whatsell'];
				if($whatsell=='p')
				{
					?>
					
					
					
                    <div class="checkbox">
                        <label  class="checkbox" for="shiptobilling-checkbox"><?php echo __("Ship to same address?", "odudeshop"); ?>
                            <input type="checkbox" value="1" name="shiptobilling"  class="input-checkbox" id="shiptobilling-checkbox">
                        </label>
                    </div>
                  <?php
				}
				?>				<hr>
		
                        <label class="" for="billing_first_name"><?php echo __("First Name", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <input type="text" value="<?php if ($billing['first_name']) echo $billing['first_name']; ?>" placeholder="First Name" id="billing_first_name " name="checkout[billing][first_name]" class="input-text required form-control">
                 


                    
                        <label class="" for="billing_last_name"><?php echo __("Last Name", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <input type="text" value="<?php if ($billing['last_name']) echo $billing['last_name']; ?>" placeholder="Last Name" id="billing_last_name" name="checkout[billing][last_name]" class="input-text required form-control">
                    


                   
                        <label  class="" for="billing_company"><?php echo __("Company Name", "odudeshop"); ?></label>
                        <input type="text" value="<?php if ($billing['company']) echo $billing['company']; ?>" placeholder="Company (optional)" id="billing_company" name="checkout[billing][company]" class="input-text  form-control">
                 


                   
                        <label class="" for="billing_address_1"><?php echo __("Address", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <input type="text" value="<?php if ($billing['address_1']) echo $billing['address_1']; ?>" placeholder="Address" id="billing_address_1" name="checkout[billing][address_1]" class="input-text required  form-control">
                  


                   
                        <label  class="hidden" for="billing_address_2"><?php echo __("Address 2", "odudeshop"); ?></label>
                        <input type="text" value="<?php if ($billing['address_2']) echo $billing['address_2']; ?>" placeholder="Address 2 (optional)" id="billing_address_2" name="checkout[billing][address_2]" class="input-text  form-control">
                      


                   
                        <label class="" for="billing_city"><?php echo __("Town/City", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <input type="text" value="<?php if ($billing['city']) echo $billing['city']; ?>" placeholder="Town/City" id="billing_city" name="checkout[billing][city]" class="input-text required  form-control">
                   


                  
                        <label class="" for="billing_postcode"><?php echo __("Postcode/Zip", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <input type="text" value="<?php if ($billing['postcode']) echo $billing['postcode']; ?>" placeholder="Postcode/Zip" id="billing_postcode" name="checkout[billing][postcode]" class="input-text required  form-control">
                      


                   
                        <label class="" for="billing_country"><?php echo __("Country", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <?php
                        global $wpdb;
                        $countries = $wpdb->get_results("select * from {$wpdb->prefix}os_country order by country_name");
                        ?>
                        <select class="required  form-control" id="billing_country" name="checkout[billing][country]">
                            <option value="">--Select a country--</option>
                            <?php
                            foreach ($countries as $country) {
                                if ($billing['country'] == $country->country_code) {
                                    $selected = ' selected="selected"';
                                } else {
                                    $selected = "";
                                }
                                if ($settings['allow_country']) {
                                    foreach ($settings['allow_country'] as $ac) {
                                        if ($ac == $country->country_code) {

                                            echo '<option value="' . $country->country_code . '"' . $selected . '>' . $country->country_name . '</option>';
                                            break;
                                        }
                                    }
                                } else {
                                    echo '<option value="' . $country->country_code . '" ' . $selected . '>' . $country->country_name . '</option>';
                                }
                            }
                            ?>
                        </select>   


               
                        <label class="" for="billing_state"><?php echo __("State/County", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <input type="text" id="billing_state" name="checkout[billing][state]" placeholder="State/County" value="<?php if ($billing['state']) echo $billing['state']; ?>" class="input-text required  form-control">
                     


                 
                        <label class="" for="billing_email"><?php echo __("Email Address", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <input type="text" value="<?php if ($billing['email']) echo $billing['email']; ?>" placeholder="Email Address" id="billing_email" name="checkout[billing][email]" class="input-text required email  form-control">
                     


                   
                        <label class="" for="billing_phone"><?php echo __("Phone", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <input type="text" value="<?php if ($billing['phone']) echo $billing['phone']; ?>" placeholder="Phone" id="billing_phone" name="checkout[billing][phone]" class="input-text required  form-control">
                   
                    
              
 </fieldset>