<?php

add_action('show_user_profile', 'odudes_add_custom_user_profile_fields');
add_action('edit_user_profile', 'odudes_add_custom_user_profile_fields');

add_action('personal_options_update', 'odudes_save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'odudes_save_custom_user_profile_fields');


function odudes_add_custom_user_profile_fields($user){
    $billing_shipping=unserialize(get_user_meta($user->ID, 'user_billing_shipping',true));
    if(is_array($billing_shipping))
        extract($billing_shipping);
?>    
    <h3><?php _e('Customer Billing Address'); ?></h3>
        
    <table class="form-table">
        <tr>
            <th>
                <label for="billing_first_name"><?php echo __("Billing First Name", "odudeshop"); ?></label>
            </th>
            <td>
                <input type="text" name="checkout[billing][first_name]" id="billing_first_name" value="<?php if ($billing['first_name']) echo $billing['first_name']; ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Enter your billing first name.', 'odudeshop'); ?></span>
            </td>
        </tr>
        
        <tr>
            <th>
                <label for="billing_last_name"><?php echo __("Last Name", "odudeshop"); ?></label>
            </th>
            <td>
                <input type="text" value="<?php if ($billing['last_name']) echo $billing['last_name']; ?>" placeholder="Last Name" id="billing_last_name" name="checkout[billing][last_name]" class="regular-text"><br />
                <span class="description"><?php _e('Enter your billing last name.', 'odudeshop'); ?></span>
            </td>
        </tr>
        
        <tr>
            <th>
                <label for="billing_company"><?php echo __("Company Name", "odudeshop"); ?></label>
            </th>
            <td>
                <input type="text" value="<?php if ($billing['company']) echo $billing['company']; ?>" placeholder="Company (optional)" id="billing_company" name="checkout[billing][company]" class="regular-text"><br />
                <span class="description"><?php _e('Enter your company name.', 'odudeshop'); ?></span>
            </td>
        </tr>    
    
        <tr>
            <th>
                <label class="" for="billing_address_1"><?php echo __("Address Line 1", "odudeshop"); ?> </label>
            </th>
            <td>
                <input type="text" value="<?php if ($billing['address_1']) echo $billing['address_1']; ?>" placeholder="Address" id="billing_address_1" name="checkout[billing][address_1]" class="regular-text"><br />
                <span class="description"><?php _e('Enter your billing address line 1.', 'odudeshop'); ?></span>
            </td>
        </tr>    
    
        <tr>
            <th>
                <label  class="" for="billing_address_2"><?php echo __("Address Line 2", "odudeshop"); ?></label>
            </th>
            <td>
                <input type="text" value="<?php if ($billing['address_2']) echo $billing['address_2']; ?>" placeholder="Address 2 (optional)" id="billing_address_2" name="checkout[billing][address_2]" class="regular-text"><br />
                <span class="description"><?php _e('Enter your billing address line 2.', 'odudeshop'); ?></span>
            </td>
        </tr>   
    
        <tr>
            <th>
                <label class="" for="billing_city"><?php echo __("Town/City", "odudeshop"); ?> </label>
            </th>
            <td>
                <input type="text" value="<?php if ($billing['city']) echo $billing['city']; ?>" placeholder="Town/City" id="billing_city" name="checkout[billing][city]" class="regular-text"><br />
                <span class="description"><?php _e('Enter your billing city name.', 'odudeshop'); ?></span>
            </td>
        </tr>    
    
        <tr>
            <th>
                <label class="" for="billing_postcode"><?php echo __("Postcode/Zip", "odudeshop"); ?> </label>
            </th>
            <td>
                <input type="text" value="<?php if ($billing['postcode']) echo $billing['postcode']; ?>" placeholder="Postcode/Zip" id="billing_postcode" name="checkout[billing][postcode]" class="regular-text"><br />
                <span class="description"><?php _e('Enter your billing post code.', 'odudeshop'); ?></span>
            </td>
        </tr>   
    
    
        <tr>
            <th>
                <label class="" for="billing_country"><?php echo __("Country", "odudeshop"); ?> </label>
            </th>
            <td>
                <?php
                global $wpdb;
                $countries = $wpdb->get_results("select * from {$wpdb->prefix}os_country order by country_name");

                ?>
                <select class="select" id="billing_country" name="checkout[billing][country]">
                    <option value="">--Select a country--</option>
                    <?php
					$settings = get_option('_odudes_settings');
                    foreach ($countries as $country) {
                        if($billing['country']==$country->country_code) {$selected=' selected="selected"';}
                                    else {$selected="";}
						
                        if ($settings['allow_country']) {
                            foreach ($settings['allow_country'] as $ac) {
                                if ($ac == $country->country_code) {

                                    echo '<option value="' . $country->country_code . '"'.$selected.'>' . $country->country_name . '</option>';
                                    break;
                                }
                            }
                        } else {
                            echo '<option value="' . $country->country_code . '" '.$selected.'>' . $country->country_name . '</option>';
                        }
                    }
                    ?>
                </select> <br />
                <span class="description"><?php _e('Enter your billing country name.', 'odudeshop'); ?></span>
            </td>
        </tr>    
    
    
        <tr>
            <th>
                <label class="" for="billing_state"><?php echo __("State/County", "odudeshop"); ?> </label>
            </th>
            <td>
                <input type="text" id="billing_state" name="checkout[billing][state]" placeholder="State/County" value="<?php if ($billing['state']) echo $billing['state']; ?>" class="regular-text"><br />
                <span class="description"><?php _e('Enter your billing state.', 'odudeshop'); ?></span>
            </td>
        </tr>    

        <tr>
            <th>
                <label class="" for="billing_email"><?php echo __("Email Address", "odudeshop"); ?> </label>
            </th>
            <td>
                <input type="text" value="<?php if ($billing['email']) echo $billing['email']; ?>" placeholder="Email Address" id="billing_email" name="checkout[billing][email]" class="regular-text email"><br />
                <span class="description"><?php _e('Enter your billing email address.', 'odudeshop'); ?></span>
            </td>
        </tr>    

        <tr>
            <th>
                <label class="" for="billing_phone"><?php echo __("Phone", "odudeshop"); ?> </label>
            </th>
            <td>
                <input type="text" value="<?php if ($billing['phone']) echo $billing['phone']; ?>" placeholder="Phone" id="billing_phone" name="checkout[billing][phone]" class="regular-text"><br />
                <span class="description"><?php _e('Enter your billing phone number.', 'odudeshop'); ?></span>
            </td>
        </tr>
    </table>
    
    <h3><?php _e('Customer Shipping Address'); ?></h3>
    
    <table class="form-table">
        <tr>
            <th>
                <label class="" for="shipping_first_name"><?php echo __("First Name", "odudeshop"); ?> </label>
            </th>
            <td>
                <input type="text" value="<?php if ($shippingin['first_name']) echo $shippingin['first_name']; ?>" placeholder="First Name" id="shipping_first_name" name="checkout[shippingin][first_name]" class="regular-text"><br/>
                <span class="description"><?php _e('Enter your shipping first name.', 'odudeshop'); ?></span>
            </td>
        </tr>        
                
        <tr>
            <th>
                <label class="" for="shipping_last_name"><?php echo __("Last Name", "odudeshop"); ?> </label>
            </th>
            <td>
                <input type="text" value="<?php if ($shippingin['last_name']) echo $shippingin['last_name']; ?>" placeholder="Last Name" id="shipping_last_name" name="checkout[shippingin][last_name]" class="regular-text"><br/>
                <span class="description"><?php _e('Enter your shipping last name.', 'odudeshop'); ?></span>
            </td>
        </tr>      
                
        <tr>
            <th>
                <label  class="" for="shipping_company"><?php echo __("Company Name", "odudeshop"); ?></label>
            </th>
            <td>
                <input type="text" value="<?php if ($shippingin['company']) echo $shippingin['company']; ?>" placeholder="Company (optional)" id="shipping_company" name="checkout[shippingin][company]" class="regular-text"><br/>
                <span class="description"><?php _e('Enter your shipping company name.', 'odudeshop'); ?></span>
            </td>
        </tr>        
                
        <tr>
            <th>
                <label class="" for="shipping_address_1"><?php echo __("Address Line 1", "odudeshop"); ?> </label>
            </th>
            <td>
                <input type="text" value="<?php if ($shippingin['address_1']) echo $shippingin['address_1']; ?>" placeholder="Address" id="shipping_address_1" name="checkout[shippingin][address_1]" class="regular-text"><br/>
                <span class="description"><?php _e('Enter your shipping address line 1.', 'odudeshop'); ?></span>
            </td>
        </tr>        
                
        <tr>
            <th>
                <label  class="" for="shipping_address_2"><?php echo __("Address Line 2", "odudeshop"); ?></label>
            </th>
            <td>
                <input type="text" value="<?php if ($shippingin['address_2']) echo $shippingin['address_2']; ?>" placeholder="Address 2 (optional)" id="shipping_address_2" name="checkout[shippingin][address_2]" class="regular-text"><br/>
                <span class="description"><?php _e('Enter your shipping address line 2.', 'odudeshop'); ?></span>
            </td>
        </tr>        
                
        <tr>
            <th>
                <label class="" for="shipping_city"><?php echo __("Town/City", "odudeshop"); ?> </label>
            </th>
            <td>
                <input type="text" value="<?php if ($shippingin['city']) echo $shippingin['city']; ?>" placeholder="Town/City" id="shipping_city" name="checkout[shippingin][city]" class="regular-text"><br/>
                <span class="description"><?php _e('Enter your shipping city name.', 'odudeshop'); ?></span>
            </td>
        </tr>        
                
        <tr>
            <th>
                <label class="" for="shipping_postcode"><?php echo __("Postcode/Zip", "odudeshop"); ?> </label>
            </th>
            <td>
                <input type="text" value="<?php if ($shippingin['postcode']) echo $shippingin['postcode']; ?>" placeholder="Postcode/Zip" id="shipping_postcode" name="checkout[shippingin][postcode]" class="regular-text"><br/>
                <span class="description"><?php _e('Enter your shipping postcode.', 'odudeshop'); ?></span>
            </td>
        </tr>
        
        <tr>
            <th>
                <label class="" for="shipping_country"><?php echo __("Country", "odudeshop"); ?> </label>
            </th>
            <td>
                <select class="required span6" id="shipping_country" name="checkout[shippingin][country]">
                    <option value="">--Select a country--</option>
                    <?php
                    foreach ($countries as $country) {
                        if ($shippingin['country'] == $country->country_code) {
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

                </select><br/>
                <span class="description"><?php _e('Enter your shipping country.', 'odudeshop'); ?></span>
            </td>
        </tr>        
                
            <tr>
                <th>
                    <label class="" for="shipping_state"><?php echo __("State/County", "odudeshop"); ?></label>
                </th>
                <td>
                    <input type="text" id="shipping_state" name="checkout[shippingin][state]" placeholder="State/County" value="<?php if ($shippingin['state']) echo $shippingin['state']; ?>" class="regular-text"><br/>
                    <span class="description"><?php _e('Enter your shipping state name.', 'odudeshop'); ?></span>
                </td>
            </tr>
        
    </table>
        
    
<?php    
}

function odudes_save_custom_user_profile_fields($user_id){
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    update_user_meta($user_id, 'user_billing_shipping', serialize($_POST['checkout']));
}


?>
