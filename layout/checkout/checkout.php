<?php
echo $msg_checkout_top;
 if($settings['user-reg']==1 ||  is_user_logged_in())
 {
	 ?>


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
	   include_once("checkout_method.php");  
	   include_once("billing.php");


	   ?>
	    <div id="shipping"> </div>
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
   
           
     jQuery('#registerform').validate({
        submitHandler: function(form) {   
           jQuery(form).ajaxSubmit({
               'url': '<?php echo home_url("/?checkout_register=register&wpmpnrd=1");?>',
               'beforeSubmit':function(){
                   //return false;
                   jQuery('#register_btn').attr('disabled','disabled').html('Please wait...');
               },
               'success':function(res){
                   
                    if(res.match(/success/)){
                       // reload after succuessfull registration
                       window.location.reload();
                    } else {                    
                       jQuery('#rmsg').html("<br/><div class='alert alert-danger'>"+res+"</div>");
                       jQuery('#register_btn').removeAttr('disabled').html('Continue');
                    }
                    return false;
               }
           });
        }
      //return false;
      });
      
       
           jQuery('#loginform').validate({
            submitHandler: function(form) {
                jQuery(form).ajaxSubmit({
                   
                   'url': '<?php the_permalink(); echo $sap; ?>checkout_login=login',
                   'beforeSubmit':function(){ 
                       jQuery('#loginbtn').attr('disabled','disabled').html('Please wait...');
                   },
                   'success':function(res){
                       
                       if(res.match(/success/)){
                           // reload after succuessfull login
                           window.location.reload();
                        }else if(res.match(/failed/)){
                            jQuery('#lmsg').html("<br/><div class='alert alert-danger'>Username or Password is not correct!</div>");
                            jQuery('#loginbtn').removeAttr('disabled').html('Login');
                        }
                   }
               });
            }
        });
               
      
      
      jQuery('#billing_form').validate({
            submitHandler: function(form) {
                jQuery(form).ajaxSubmit({
               'url': '<?php echo home_url("?checkout_billing=save");?>',
               'beforeSubmit':function(){
                  
				   jQuery('#odude_loading').fadeIn();
               },
               'success':function(res){
                   
                    if(res.match(/error/)){
                        alert(res);
                  
                    } else{
                        
                        jQuery('#csb').slideUp();
						jQuery('#bill_header').slideUp();
						jQuery('#odudes-section-billing').slideUp();
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
               'url': '<?php echo home_url("?wpmpaction=placeorder&user=reg");?>',
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



jQuery('#billing_back').live("click",function(){ 
     jQuery('#csb').slideUp();
     jQuery('#csl').slideDown();     
});

jQuery('#shipping_back').live("click",function(){ 
     jQuery('#shipping').slideUp();
	
     jQuery('#csb').slideDown();    
	jQuery('#odudes-section-billing').slideDown();
	jQuery('#odude_loading').slideUp();
    jQuery('#bill_header').slideDown();
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
	 }
 else
 {
	 include_once("checkout_noreg.php"); 
 }
    ?>
	
	
	