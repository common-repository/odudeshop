

 <?php
 $indexfile=odudes_UPLOAD_DIR.'index.htm';	
			if(!file_exists($indexfile))
			{			
			$current = "ODude Shop Wordpress Plugin.";
			file_put_contents($indexfile, $current);
			}
			$indexpicfile=odudes_IMAGE_DIR.'index.htm';
			if(!file_exists($indexpicfile))
			{			
			$current = "ODude Shop Wordpress Plugin.";
			file_put_contents($indexpicfile, $current);
			}
			
 $settings = get_option('_odudes_settings');
 
 $whatsell='';
if(isset($settings['whatsell']))  
 $whatsell=$settings['whatsell'];

$showcart='';
if(isset($settings['showcart']))  
$showcart=$settings['showcart'];

$userreg='';
if(isset($settings['user-reg']))  
$userreg=$settings['user-reg'];

$hide_price='';
if(isset($settings['hide_price']))  
$hide_price=$settings['hide_price'];

if(isset($settings['currency']))
	$settings['currency']='USD';

$shoppingurl=get_site_url()."/product";

 ?>
 <style>
.wrap{
    margin: 0px;
    
}
#footer,
#wpcontent{
    margin-left: 160px;
}
.wrap *{
    font-family: Tahoma;
    letter-spacing: 1px;
}

input[type=text],textarea{
    width:500px;
    padding:5px;
}

input{
   padding: 7px; 
}
.cats li{   
    width:20%;
    float: left;
}

#icon-options-general{
    margin-left: 15px;
}

#odudes_settings_form{
    padding-left: 20px;
}
 
#message,.updated{
 
-webkit-border-radius: 0px;
-moz-border-radius: 0px;
border-radius: 0px;
border:0px;
} 
</style>
<script type="text/javascript">
function select_my_list(selectid,val){
    var ln=document.getElementById(selectid).options.length;
    for(var i=0;i<ln; i++){
        if(document.getElementById(selectid).options[i].value==val)
            document.getElementById(selectid).options[i].selected = true;                                               }
}

jQuery(function(){
    jQuery('#message').live('click',function(){
        jQuery('#message').slideUp();
    });
});
</script>
 <?php
    $settings = maybe_unserialize(get_option('_odudes_settings'));
    //echo "<pre>" ; print_r($settings); echo "</pre>";
?>
<!--[if IE]>
<style>
ul#navigation { 
border-bottom: 1px solid #999999;
}
</style>
<![endif]-->

    
<script>
jQuery(document).ready(function($){
       $("#tabs").tabs();
});
  </script>
<div class="wrap">


 <br>
 <div class="updated" style="padding: 5px;display: none;" id="message"></div>
 <br>
 <form method="post" id="odudes_settings_form">
 
 <?php
if(isset($settings['setup']) && $settings['setup']=='1') 
{	
?>
 
 
<div id="tabs">
    <ul>
        <li><a href="#tab-1"><?php echo __("Basic Settings","odudeshop");?></a></li>
        <li><a href="#tab-2"><?php echo __("Payment Method","odudeshop");?></a></li>         
       <?php if($whatsell=='p') { ?> <li><a href="#tab-3"><?php  echo __("Shipping Method","odudeshop");?></a></li>  <?php } ?>        
       <?php if($whatsell=='p') { ?> <li><a href="#tab-4"><?php echo __("Stock Management","odudeshop");?></a></li> <?php } ?> 
		<?php if($whatsell=='d') { ?><li><a href="#tab-5"><?php echo __("Download","odudeshop");?></a></li> <?php } ?> 
		  <li><a href="#tab-6"><?php echo __("Country Options","odudeshop");?></a></li>   
		<?php if($whatsell=='p') { ?> <li><a href="#tab-7"><?php echo __("Purchase Options","odudeshop");?></a></li> <?php } ?> 	
		<li><a href="#tab-8"><?php echo __("Messages & Notice","odudeshop");?></a></li>   		
    </ul>
	
    <div id="tab-1">
     <?php include_once("basic_settings.php");?>
    </div>
    <div id="tab-2">
       <?php include_once("payment_options.php");?>
    </div>
    <div id="tab-3">
       <?php 
		if($whatsell=='p')
		include_once("shipping_options.php");
		//else
		//echo __("Aviable only for Physical Products","odudeshop");	
		?>
    </div>
	 <div id="tab-4">
       <?php 

		if($whatsell=='p')
		include_once("stock_options.php");
		//else
		//echo __("Aviable only for Physical Products","odudeshop");
		?>
    </div>
	 <div id="tab-5">
       <?php 
		if($whatsell=='d')
		include_once("download_options.php");
		//else
		//echo __("Aviable only for Digital Products","odudeshop");
		?>
    </div>
		 <div id="tab-6">
       <?php 
		
		include_once("country_options.php");
		
		?>
    </div>
			 <div id="tab-7">
       <?php 
		if($whatsell=='p')
		include_once("purchase_options.php");
		
		?>
    </div>
	 <div id="tab-8">
       <?php 
		
		include_once("notices.php");
		
		?>
    </div>
	<br><br>

<input type="reset" value="Reset" class="button button-secondary button-large" >
<input type="submit" value="Save Settings" class="button button-primary button-large" >   
<img style="display: none;" id="wdms_saving" src="images/loading.gif" />
	
</div>
<?php
}
else
{
	?>
	<input type="hidden" name="action" value="odudes_save_settings">
	<input type="hidden" value="1" id="setup" name="_odudes_settings[setup]">
<br><br>

<h2><?php echo __("What you want to sell ?","odudeshop");?></h2><br>
<h4>
<input type="radio" name="_odudes_settings[whatsell]" id="whatsell" value="p" <?php if(!empty($whatsell)){if($whatsell=="p")echo 'checked="checked"';}else echo 'checked="checked"';?>> <?php echo __("Physical Goods","odudeshop");?> 
<input type="radio" name="_odudes_settings[whatsell]" id="whatsell" value="d"  <?php if($whatsell=="d")echo 'checked="checked"';?>  > <?php echo __("Digital Goods","odudeshop");?>
</h4>

<b>Note</b>: This question will be asked only for one time. So please think carefully before you save settings.
<br><br>
	<input type="reset" value="Reset" class="button button-secondary button-large" >
<input type="submit" value="Save Settings" class="button button-primary button-large" >   
<img style="display: none;" id="wdms_saving" src="images/loading.gif" />
	
	<?php
}
?>
</form>

 
</div>

<script type="text/javascript">

jQuery(document).ready(function(){
    
    jQuery('#odudes_settings_form').submit(function(){
       
       jQuery(this).ajaxSubmit({
        url:ajaxurl,
        beforeSubmit: function(formData, jqForm, options){
          jQuery('#wdms_saving').fadeIn();  
        },   
        success: function(responseText, statusText, xhr, $form){
          jQuery('#message').html("<p>"+responseText+"</p>").slideDown();
          //setTimeout("jQuery('#message').slideUp()",4000);
          jQuery('#wdms_saving').fadeOut();  
          jQuery('#wdms_loading').fadeOut();  
          window.setTimeout('location.reload()', 1000);
        }   
       });
        
       return false; 
    });
    
   
});
 
</script>
