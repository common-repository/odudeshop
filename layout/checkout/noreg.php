
<?php
global $sap; 
    wp_enqueue_script('jquery-validate',plugins_url("odudeshop/js/jquery.validate.js"));

?> 
 <div id="nouser_header" class="header"><?php echo __("Give us your Details", "odudeshop"); ?> <div class="date"> &nbsp;</div> </div>
			
<div id="odudes-section-nouser">


<div class="pure-g">
    <form action="" name="user_form" id="user_form" method="post" class="pure-form pure-form-aligned">

       	
                <div class="pure-u-1 pure-u-md-1">         
						<div class="pure-control-group">
                        <label class="" for="billing_first_name"><?php echo __("First Name", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <input type="text" value="<?php if ($billing['first_name']) echo $billing['first_name']; ?>" placeholder="First Name" id="billing_first_name" name="billing_first_name" class="input-text required form-control">
						</div>


                   <div class="pure-control-group">
                        <label class="" for="billing_email"><?php echo __("Email Address", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <input type="text" value="<?php if ($billing['email']) echo $billing['email']; ?>" placeholder="Email Address" id="billing_email" name="billing_email" class="input-text required email  form-control">
                     </div>
					 
					     <div class="pure-control-group">
                        <label class="" for="billing_phone"><?php echo __("Phone", "odudeshop"); ?> <abbr title="required" class="required">*</abbr></label>
                        <input type="text" value="<?php if ($billing['phone']) echo $billing['phone']; ?>" placeholder="Phone" id="billing_phone" name="checkout[billing][phone]" class="input-text required  form-control">
                    </div>
					 
					 
					 
                </div>
				
				
               
              				
				
				<div class="clear"></div>
<br>
			<button id="billing_btn" class="btn btn-success" type="submit"><span><span><?php echo __("Go", "odudeshop"); ?></span></span></button>
          

            
        
			<div id="bloading_message"></div>
        </div>

    </form>
	</div>

<script language="JavaScript">
<!--
    jQuery('#shiptobilling-checkbox').click(function() {
        if (this.checked)
            jQuery('#shipping-address').fadeOut();
        else
            jQuery('#shipping-address').fadeIn();
    })

//-->
</script>