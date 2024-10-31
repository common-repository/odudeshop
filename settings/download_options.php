<fieldset><legend><strong><?php echo __("Download Page","odudeshop");?></strong></legend>
<input type="checkbox" name="_odudes_settings[instant_download]" <?php if(isset($settings['instant_download'])) if($settings['instant_download']==1) echo 'checked=checked' ?> value="1"> <?php echo __("Show Download Button for Free Digital Product","odudeshop");?>
</fieldset>