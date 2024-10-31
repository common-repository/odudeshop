  <div id="bill_header" class="header" style="<?php if ($current_user->ID) echo ""; else echo "display:none"; ?>"><?php if($whatsell=='p') echo __("Billing and Shipping Info", "odudeshop"); else echo __("Billing Info", "odudeshop"); ?> <div class="date"> &nbsp;</div> </div>
	

				
<div id="odudes-section-billing">

    <?php
    $billing_shipping = unserialize(get_user_meta($current_user->ID, 'user_billing_shipping', true));
    if (is_array($billing_shipping))
        extract($billing_shipping);
    //print_r($billing);
    ?>

<div class="pure-g">
    <form action="" name="billing_form" id="billing_form" method="post" class="pure-form pure-form-stacked">

        <div style="width:130%;<?php if ($current_user->ID) echo ""; else echo "display:none"; ?>" id="csb">
	
            <div id="customer_details" class="row row-fluid" >
			
                <div class="pure-u-1 pure-u-md-1-2">         
                  <?php  include_once("billing_customer.php");  ?>	
                </div>
				
				
                
				<div class="pure-u-1 pure-u-md-1-2" id="shipping-address">
					
                    <?php  
			$whatsell=$settings['whatsell'];
				if($whatsell=='p')
				{
					include_once("billing_shipping.php"); 
				}			
				?>
				
				
				</div>
                </div>
			
				
				
				<div class="clear"></div>

			<button id="billing_btn" class="btn btn-success" type="submit"><span><span><?php echo __("Continue", "odudeshop"); ?></span></span></button>
            </div>

            
        
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