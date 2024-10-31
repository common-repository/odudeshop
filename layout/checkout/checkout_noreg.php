
<style>

.obox {
  border: 1px solid #ddd;
  padding: 10px 12px;
  margin-bottom: 15px;
  background: #fff;
  obox-sizing: border-obox;
  border-radius: 3px;
  overflow: hidden;
  margin: 0px 5px 5px 0px;
}
.obox:hover {
  border: 1px solid #5890FF;
  padding: 10px 12px;
  margin-bottom: 15px;
  background: #fff;
  obox-sizing: border-obox;
  border-radius: 3px;
  overflow: hidden;
  margin: 0px 5px 5px 0px;
}
.obox.blue {
  border: 1px solid #5890FF;
}
.obox .header {
  position: relative;
  color: #9197a3;
  font-size: 12px;
  line-height: 1.38;
  padding-bottom: 8px;
  margin-bottom: 8px;
  border-bottom: 1px solid #ddd;
}
.obox .header a {
  font-weight: bold;
}
.obox .header .date {
  position: absolute;
  right: 0;
  top: 0;
}
.obox .links {
  margin-top: 8px;
  font-size: 12px;
  line-height: 1.38;
}
.obox .links a {
  color: #5890FF;
  text-decoration: none;
}
.obox .links a:hover {
  text-decoration: underline;
}
.obox .footer {
  color: #444;
  font-size: 12px;
  line-height: 1.38;
  border-top: 1px solid #ddd;
  background: #F6F7F8;
  padding: 5px 12px;
  margin: 8px -12px -10px -12px;
}

.obox .row
{
	#background: #F6F7F8;
	margin: 8px 8px 8px 8px;
	width: 100%;
}

</style>

<div class="checkout_div odude-shop">
    <?php
    global $current_user, $sap;
    $settings = maybe_unserialize(get_option('_odudes_settings'));   
	$whatsell=$settings['whatsell'];
    get_currentuserinfo();
    $cart_items = odudes_get_cart_items();
    $currency_sign = get_option('_odudes_curr_sign','$');
    if(count($cart_items)==0)
		echo __("No item in cart.","odudeshop")."<br/><a href='".$settings['continue_shopping_url']."'>".__("Continue shopping","odudeshop")."</a></div>";
    else
	{
    $settings = maybe_unserialize(get_option('_odudes_settings'));
	
	?>
	 <div class="obox">
	  <div class="body">
	  
	<?php
	  // include_once("checkout_method.php");  
	   include_once("noreg.php");
 

	   ?>
	    <div id="shipping"></div>
	    <div id="payment"> </div>
	    <div id="order-review">  </div>
	   

</div>
    
    <div class="footer" style="text-align:center">
	
	<div id="odude_loading" style="display:none"><img src="<?php echo admin_url('/images/loading.gif'); ?>" /></div>
	</div>
  </div>
	   
	   
	   
<div id="odudes-section-shipping">  

  </div>


	   <script type="text/javascript">
	   
     
	   
	   
	   
jQuery(function()
{
		jQuery('#shiptobilling-checkbox').click(function()
		{
			//alert(jQuery('#shiptobilling-checkbox').attr('checked'));
			if(jQuery('#shiptobilling-checkbox').attr('checked')=="checked")
			{
				jQuery('.col-1').slideUp();
					
			}
			else
			{

				jQuery('.col-1').slideDown();
				
			}
		});
   
          
		    
		  
		  
		  
		  
		  jQuery('#user_form').validate({
            submitHandler: function(form) {
                jQuery(form).ajaxSubmit({
               'url': '<?php echo home_url("?checkout_user=save");?>',
               'beforeSubmit':function(){
                  
				   jQuery('#odude_loading').fadeIn();
               },
               'success':function(res){
                   
                    if(res.match(/error/)){
                        alert(res);
                  
                    } else
					{
                        
                        //jQuery('#csb').slideUp();
						jQuery('#nouser_header').slideUp();
						jQuery('#odudes-section-nouser').slideUp();
                        jQuery('#shipping').html(res).slideDown();
                    }
               }
           });
      
            }
      });
 
      

      var skippayment = 0;
      jQuery('#shipping_form').live('submit',function(){
           jQuery(this).ajaxSubmit({
               'url': '<?php echo home_url("?checkout_shipping=save");?>',
               'beforeSubmit':function(){
                  
				   jQuery('#odude_loading').slideDown();
               },
               'success':function(res){
                   
                    if(res.match(/error/))
					{
                        alert(res);
                   //jQuery('#loading_first').slideUp();
                    }
					else
					{        //close the shipping div
							 //jQuery('#cssh').slideUp();
							// jQuery('#ship_header').slideUp();
							 jQuery('#shipping').slideUp();
							  
							 
                         //open the payment div
                        if(!res.match(/id="order_/))
						{
                           
                            
                            jQuery('#payment').html(res).slideDown();
                        }
                        else 
						{
							//open order review
                            skippayment = 1;
                            jQuery('#order-review').html(res);                
							jQuery('#payment').slideUp(); 
                            jQuery('#order-review').slideDown();
                        }
                    }
               }
           });
      return false;
      });
      
      jQuery('#payment_form').live("submit",function(){
           jQuery(this).ajaxSubmit({
               'url': '<?php echo home_url("?checkout_payment=save");?>',
               'beforeSubmit':function(){
                  jQuery('#odude_loading').slideDown();
               },
               'success':function(res){
                   //var obj = jQuery.parseJSON(res); 
                   //alert(obj.success);
                    if(res.match(/error/)){
                        alert(res);
                   
                    }else{
                     
                      jQuery('#payment').slideUp();  
                      jQuery('#order-review').html(res).slideDown();  
					  
                    }
               }
           });
      return false;
      });
      
      jQuery('#order_form').live("submit",function(){
           jQuery(this).ajaxSubmit({
               'url': '<?php echo home_url("?wpmpaction=placeorder&user=nouser");?>',
               'beforeSubmit':function(){
                    jQuery('#odude_loading').slideDown();
                   jQuery('#order_btn').attr('disabled','disabled').html('Please wait...');
               },
               'success':function(res){
                 
                   jQuery('#wpmpplaceorder').html(res);
                   
               }
           });
      return false;
      });





jQuery('#shipping_back').live("click",function()
{ 
     jQuery('#shipping').slideUp();
	jQuery('#nouser_header').slideDown();
	jQuery('#odudes-section-nouser').slideDown();
	jQuery('#odude_loading').slideUp();					
    
});
jQuery('#pay_back').live("click",function(){ 
     jQuery('#payment').slideUp();
     jQuery('#shipping').slideDown();   
	//jQuery('#ship_header').slideDown();	 
});
jQuery('#order_back').live("click",function(){ 
    
	 jQuery('#csor').slideUp();
	  jQuery('#order_header').slideUp();
    if(skippayment==0)
	{
     jQuery('#payment').slideDown();
	}
    else
	{
     jQuery('#shipping').slideDown();
	 //jQuery('#cssh').slideDown();
	 //jQuery('#ship_header').slideDown();
	}
});



});
</script>
	<?php
	}
    ?>
	
	
	