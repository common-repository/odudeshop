<?php
    global $wpdb;
    $countries=$wpdb->get_results("select * from {$wpdb->prefix}os_country order by country_name");
?>
Base Country <br>
<select name="_odudes_settings[base_country]">
<option>---Select Country---</option>
<?php
 foreach($countries as $country){   
?>
<option <?php if($settings['base_country']==$country->country_code) echo 'selected=selected'?> value="<?php echo $country->country_code;?>"><?php echo $country->country_name;?></option>
<?php
 }
?>
</select><br /><br />
<?php echo __("Allowed Countries","odudeshop");?> 


<ul id="listbox">
    <li><label for="allowed_cn"><input type="checkbox" name="allowed_cn_all" id="allowed_cn" /> Select [All]&nbsp;&nbsp;&nbsp;[None]</label></li>
	<li><label for="allowed_cn">----------------------------</label></li>
<?php
 foreach($countries as $country)
 {   
?>
    <li>
	<label>
	<input  <?php $select=''; if(isset($settings['allow_country']))if($settings['allow_country'])foreach($settings['allow_country'] as $ac){if($ac==$country->country_code){$select= 'checked="checked"';break;}else $select='';} echo $select;?> type="checkbox" name="_odudes_settings[allow_country][]" value="<?php echo $country->country_code;?>"><?php echo " " . $country->country_name;?>
	</label>
	</li>
    
    <?php
 }
?>
</ul>

