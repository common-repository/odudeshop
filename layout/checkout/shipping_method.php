 <div class="header" id="ship_header" ><?php echo __("Shipping Method","odudeshop");?>    <div class="date">&nbsp;</div> </div>
         <div class="step a-item" id="cssh">
		<form action="" name="shipping_form" id="shipping_form" method="post"  class="pure-form"> 
       
        
        <div>
            <label for="shipping_method"><?php echo __("Select Shipping","odudeshop");?>   </label>
          
            
           <?php
           $ship_methods="";
		   $msg_methods="";
		   $first_method="";
           $settings = maybe_unserialize(get_option('_odudes_settings'));
           $currency_sign = get_option('_odudes_curr_sign','$');
           if($settings['calc_shipping']==1)
		   {
              if(isset($settings['flat_rate_enabled']))
			  if($settings['flat_rate_enabled']==1)
			  {
                  $flat_rate=$settings['flat_rate_cost']+$settings['flat_rate_fee'];
                  if($settings['flat_rate_tax_status']=="taxable"){
                      $flat_rate=$flat_rate;//calculate flat rate tax
                  }
                $ship_methods.= '<option rel="'.$flat_rate.'" value="'.$settings['flat_rate_title'].'">'.$settings['flat_rate_title']." {$currency_sign}".$flat_rate.'</option>';
				$first_method='<div class="odude_info"><i class="fa fa-truck"></i>'.$settings['flat_rate_title'].' '.$currency_sign.' '.$flat_rate.'<pre>'.$settings['flat_rate_msg'].'</pre></div>';
				$msg_methods.='<div id="'.$settings['flat_rate_title'].'" style="display:none;">'.$first_method.'</div>';
			 }
              
			  if(isset($settings['free_shipping_enabled']))
			  if($settings['free_shipping_enabled']==1)
			  {
                  if(wpmpz_get_cart_total() >= $settings['free_shipping_min_amount'])
				  {
                      $ship_methods.= '<option rel="0" value="'.$settings['free_shipping_title'].'">'.$settings['free_shipping_title'].'</option>';
					$first_method='<div class="odude_info"><i class="fa fa-truck"></i>'.$settings['free_shipping_title'].'<pre>'.$settings['free_shipping_msg'].'</pre></div>';
					$msg_methods.='<div id="'.$settings['free_shipping_title'].'" style="display:none;">'.$first_method.'</div>';
				 }
              }
			  
              if(isset($settings['local-delivery_enabled']))
			  if($settings['local-delivery_enabled']==1)
			  {
                  if($settings['local-delivery_type']!="free")
				  {
                      if($settings['local-delivery_type']=="fixed")
                        $delivery_fee=$settings['local-delivery_fee'];
                      else  
                        $delivery_fee=(odudes_get_cart_subtotal()*($settings['local-delivery_fee']/100));
                      
                  }
				  else $delivery_fee=0;
                 $ship_methods.= '<option rel="'.$delivery_fee.'" value="'.$settings['local-delivery_title'].'"  selected>'.$settings['local-delivery_title']." {$currency_sign}".$delivery_fee.'</option>'; 
				$first_method='<div class="odude_info"><i class="fa fa-truck"></i>'.$settings['local-delivery_title']." {$currency_sign}".$delivery_fee.' <pre>'.$settings['local-delivery_msg'].'</pre></div>';
				$msg_methods.='<div id="'.$settings['local-delivery_title'].'" style="display:none;">'.$first_method.'</div>';
			 }
              
           }
		   else
           $ship_methods.= '<option value="0">No shipping</option>';
	   
           $ship_methods=apply_filters("odudes_apply_shipping_method",$ship_methods);
           
?>          
 <select id="shipping_method" name="shipping_method" class="form-control" onchange="choice1()">
<?php echo $ship_methods; ?>
 </select> 
<?php echo $msg_methods; ?> <br>
<input type="hidden" name="shipping_rate" value="0" id="shipping_rate" />
        </div>
        
<br>
<button id="shipping_back" class="button btn" type="button"><span><span><?php echo __("Back","odudeshop");?></span></span></button>
<button id="shipping_btn" class="button btn btn-success" type="submit"><span><span><?php echo __("Continue","odudeshop");?></span></span></button>
 </form>
 <div id="vender" class="obox">
<?php echo $first_method; ?> 

 </div>
        </div>
       
        <script type="text/javascript">
		jQuery('#odude_loading').slideUp();
        window.onload=shipping();
        jQuery('#shipping_method').change(function(){
            shipping();
        });
        
        function shipping(){
            jQuery('#shipping_rate').val(jQuery('#shipping_method option:selected').attr("rel"));
        }
		function choice1()
    {
    var x = document.getElementById("shipping_method");
   
	var MyDiv1 = document.getElementById(x.options[x.selectedIndex].value);
	document.getElementById("vender").innerHTML=MyDiv1.innerHTML;
    }
        </script>