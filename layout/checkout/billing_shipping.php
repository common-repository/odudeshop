
		<fieldset>
        <legend><?php echo __("Shipping Address", "odudeshop"); ?></legend>
		
		    <div class="shipping_address" style="display: block;" id="shipping_address">


                            <label class="" for="shipping_first_name"><?php echo __("First Name", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                            <input type="text" value="<?php if ($shippingin['first_name']) echo $shippingin['first_name']; ?>" placeholder="First Name" id="shipping_first_name" name="checkout[shippingin][first_name]" class="input-text required form-control">
                             

                       
                            <label class="" for="shipping_last_name"><?php echo __("Last Name", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                            <input type="text" value="<?php if ($shippingin['last_name']) echo $shippingin['last_name']; ?>" placeholder="Last Name" id="shipping_last_name" name="checkout[shippingin][last_name]" class="input-text required  form-control">
                     

                     
                            <label  class="" for="shipping_company"><?php echo __("Company Name", "odudeshop"); ?></label>
                            <input type="text" value="<?php if ($shippingin['company']) echo $shippingin['company']; ?>" placeholder="Company (optional)" id="shipping_company" name="checkout[shippingin][company]" class="input-text  form-control">
                     

                     
                            <label class="" for="shipping_address_1"><?php echo __("Address", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                            <input type="text" value="<?php if ($shippingin['address_1']) echo $shippingin['address_1']; ?>" placeholder="Address" id="shipping_address_1" name="checkout[shippingin][address_1]" class="input-text required  form-control">
                           

                     
                            <label  class="hidden" for="shipping_address_2"><?php echo __("Address 2", "odudeshop"); ?></label>
                            <input type="text" value="<?php if ($shippingin['address_2']) echo $shippingin['address_2']; ?>" placeholder="Address 2 (optional)" id="shipping_address_2" name="checkout[shippingin][address_2]" class="input-text  form-control">
                       

                      
                            <label class="" for="shipping_city"><?php echo __("Town/City", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                            <input type="text" value="<?php if ($shippingin['city']) echo $shippingin['city']; ?>" placeholder="Town/City" id="shipping_city" name="checkout[shippingin][city]" class="input-text required form-control">
                          

                        
                            <label class="" for="shipping_postcode"><?php echo __("Postcode/Zip", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                            <input type="text" value="<?php if ($shippingin['postcode']) echo $shippingin['postcode']; ?>" placeholder="Postcode/Zip" id="shipping_postcode" name="checkout[shippingin][postcode]" class="input-text required  form-control">
                       

                       
                            <label class="" for="shipping_country"><?php echo __("Country", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>

                            <select class=" country_select required  form-control" id="shipping_country" name="checkout[shippingin][country]">
                                <option value="">--Select a country--</option>
                                <?php
                                foreach ($countries as $country) {
                                    if ($settings['allow_country']) {
                                        if ($shippingin['country'] == $country->country_code) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = "";
                                        }
                                        foreach ($settings['allow_country'] as $ac) {
                                            if ($ac == $country->country_code) {
                                                echo '<option value="' . $country->country_code . '" ' . $selected . '>' . $country->country_name . '</option>';
                                                break;
                                            }
                                        }
                                    } else {
                                        echo '<option value="' . $country->country_code . '" ' . $selected . '>' . $country->country_name . '</option>';
                                    }
                                }
                                ?>

                            </select>
                              

                      
                            <label class="" for="shipping_state"><?php echo __("State/County", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                            <input type="text" id="shipping_state" name="checkout[shippingin][state]" placeholder="State/County" value="<?php if ($shippingin['state']) echo $shippingin['state']; ?>" class="input-text required  form-control">
                      
             </div>
		
		</fieldset>
					