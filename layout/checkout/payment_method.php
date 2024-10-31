<?php
    global $payment_methods;
    //echo  PrepaidCredits::checkCredits();
?> 
 <div class="header" id="payment_header"><?php echo __("Payment Method","odudeshop");?>    <div class="date">&nbsp;</div> </div>
<form action="" name="payment_form" id="payment_form" method="post"  class="pure-form"> 
<div class="step a-item" id="csp">
    <label for="payment_m"><?php echo __("Select Payment Method:","odudeshop"); ?></label>
<select name="payment_m" id="payment_method" class="form-control" onchange="choice1()">
  <?php
    
    $settings = maybe_unserialize(get_option('_odudes_settings'));
    $payment_methods = apply_filters('payment_method', $payment_methods); 
    
     foreach($payment_methods as $payment_method)
	 {  
        if(class_exists($payment_method))
		{
			if(isset($settings[$payment_method]['enabled']))
		   if($settings[$payment_method]['enabled']){

                echo '<option value="'.$payment_method.'">'.$payment_method.'</option>';

            }
        }
    }
	
    
  ?>
</select>
<?php
foreach($payment_methods as $payment_method)
	 {  
        if(class_exists($payment_method))
		{
			if(isset($settings[$payment_method]['enabled']))
            if($settings[$payment_method]['enabled']){

                echo '<div id="'.$payment_method.'" style="display:none;"><img src="'.WP_PLUGIN_URL.'/odudeshop/libs/payment_methods/'.$payment_method.'/logo.jpg"></div>';

            }
        }
    }
?>
<div id="pay_vender" class="obox">

<?php
foreach($payment_methods as $payment_method)
	 {  
        if(class_exists($payment_method))
		{
            if($settings[$payment_method]['enabled'])
			{

                echo '<img src="'.WP_PLUGIN_URL.'/odudeshop/libs/payment_methods/'.$payment_method.'/logo.jpg">';
			break;
            }
        }
    }
?>

</div>
<input type="hidden" name="payment_method" id="payment__method">
 <br>
<br><button id="pay_back" class="button btn" type="button"><span><span><?php echo __("Back","odudeshop");?></span></span></button>
<button id="pay_btn" class="button btn btn-success" type="submit"><span><span><?php echo __("Continue","odudeshop");?></span></span></button>

</div>
</form>
<script type="text/javascript">
window.onload=pay_method();
jQuery('#odude_loading').slideUp();
jQuery('#payment_method').change(function(){
    pay_method();
});

function pay_method(){
    jQuery('#payment__method').val(jQuery('#payment_method').val());
}
function choice1()
    {
    var x = document.getElementById("payment_method");
   // alert(x.options[x.selectedIndex].value);
  //jQuery('#clear').slideToggle("slow");
	//jQuery('#'+x.options[x.selectedIndex].value).slideToggle("slow");
	var MyDiv1 = document.getElementById(x.options[x.selectedIndex].value);
	document.getElementById("pay_vender").innerHTML=MyDiv1.innerHTML;
    }
</script>