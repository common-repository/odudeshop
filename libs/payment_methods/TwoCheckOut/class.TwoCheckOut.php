<?php
if(!class_exists('TwoCheckOut')){
class TwoCheckOut extends CommonVers{
    var $TestMode;
    //This should be keep in Global setting of 2co.com http://odude.com/wp/?action=odudes-payment-notification&class=TwoCheckOut
    var $GatewayUrl = "https://www.2checkout.com/checkout/purchase";
    var $GatewayUrl_TestMode = "https://sandbox.2checkout.com/checkout/purchase";
    var $Business;
    var $ReturnUrl;
    var $NotifyUrl;
    var $CancelUrl;    
    var $Custom;
    var $Enabled;
    var $Currency;
    var $Ship_method;
    var $Ship_amount;
    var $Ship_currency;
    var $order_id;
    
    
    function TwoCheckOut($TestMode = 0)
	{
        $this->TestMode = $TestMode;                
        if($TestMode==1)
        $this->GatewayUrl = $this->GatewayUrl_TestMode;
        
        $settings = maybe_unserialize(get_option('_odudes_settings'));
		
		if(isset($settings['TwoCheckOut']['enabled']))
		{
		
        $this->Enabled= isset($settings['TwoCheckOut']['enabled'])?$settings['TwoCheckOut']['enabled']:"";
       // $this->ReturnUrl = $settings['TwoCheckOut']['return_url'];
        //$this->NotifyUrl = home_url('/TwoCheckOut/notify/');
        $this->NotifyUrl = home_url('?action=odudes-payment-notification&class=TwoCheckOut');
       // $this->CancelUrl = $settings['TwoCheckOut']['cancel_url'];
        $this->Business =  $settings['TwoCheckOut']['TwoCheckOut_sid'];
		$this->Pwd =  $settings['TwoCheckOut']['TwoCheckOut_pwd'];
        $this->TestMode =  $settings['TwoCheckOut']['TwoCheckOut_mode'];
        //$this->Currency =  $settings['TwoCheckOut']['currency'];
        $this->Currency =  get_option('_odudes_curr_name','USD');
        
        if($settings['TwoCheckOut']['TwoCheckOut_mode']=='sandbox')            
        $this->GatewayUrl = $this->GatewayUrl_TestMode;
		}
    }
    
    
    function ConfigOptions()
	{    
        
        
        
        if($this->Enabled)$enabled='checked="checked"';
        else $enabled = "";
     

//<tr><td>'.__("Cancel Url:","odudeshop").'</td><td><input type="text" name="_odudes_settings[TwoCheckOut][cancel_url]" value="'.$this->CancelUrl.'" /></td></tr>
//<tr><td>'.__("Return Url:","odudeshop").'</td><td><input type="text" name="_odudes_settings[TwoCheckOut][return_url]" value="'.$this->ReturnUrl.'" /></td></tr>
	 
        $data='<table>
<tr><td>'.__("Enable/Disable:","odudeshop").'</td><td><input type="checkbox" value="1" '.$enabled.' name="_odudes_settings[TwoCheckOut][enabled]" style=""> '.__("Enable TwoCheckOut","odudeshop").'</td></tr>
<tr><td>'.__("2CheckOut Mode:","odudeshop").'</td><td><select id="TwoCheckOut_mode" name="_odudes_settings[TwoCheckOut][TwoCheckOut_mode]"><option value="live">Live</option><option value="sandbox" >SandBox</option></select></td></tr>
<tr><td>'.__("2CheckOut sid:","odudeshop").'</td><td><input type="text" name="_odudes_settings[TwoCheckOut][TwoCheckOut_sid]" value="'.$this->Business.'" /></td></tr>
<tr><td>'.__("2CheckOut Secret Word:","odudeshop").'</td><td><input type="text" name="_odudes_settings[TwoCheckOut][TwoCheckOut_pwd]" value="'.$this->Pwd.'" /></td></tr>

<tr><td>
Image URL:
</td><td><img src="'.WP_PLUGIN_URL.'/odudeshop/libs/payment_methods/TwoCheckOut/logo.jpg"><br>
'.WP_PLUGIN_URL.'/odudeshop/libs/payment_methods/TwoCheckOut/logo.jpg
</td></tr>
<tr><td>
<b>2checkout.com\'s <br>Instant Notification Settings</b>:
</td><td>'.get_site_url().'/?action=odudes-payment-notification&class=TwoCheckOut<br>
Paste URL at Order Created : Enabled
</td></tr>
</table>
<script>
select_my_list("TwoCheckOut_mode","'.$this->TestMode.'");
</script>
';
        return $data;
    }
    
    function ShowPaymentForm($AutoSubmit = 0)
	{
		/* <input type='hidden' name='card_holder_name' value='Checkout Shopper' />
					<input type='hidden' name='street_address' value='123 Test Address' />
					<input type='hidden' name='street_address2' value='Suite 200' />
					<input type='hidden' name='city' value='Columbus' />
					<input type='hidden' name='state' value='OH' />
					<input type='hidden' name='zip' value='43228' />
					<input type='hidden' name='country' value='USA' />
					<input type='hidden' name='phone' value='614-921-2450' />
         */
        if($AutoSubmit==1) $hide = "display:none;'";
        $TwoCheckOut = plugins_url().'/odudeshop/images/TwoCheckOut.png';
        $Form = " 
                    <form method='post' style='margin:0px;' name='_wpdm_bnf_{$this->InvoiceNo}' id='_wpdm_bnf_{$this->InvoiceNo}' action='{$this->GatewayUrl}'>

                    <input type='hidden' name='sid' value='{$this->Business}' />
					
					<input type='hidden' name='mode' value='2CO' />
					 <!-- Product Information -->
                    <input type='hidden' name='li_0_type' value='product' />
					<input type='hidden' name='li_0_product_id' value='{$this->InvoiceNo}' />
					<input type='hidden' name='li_0_name' value='{$this->OrderTitle}' />
					<input type='hidden' name='li_0_price' value='{$this->Amount}' />
					<input type='hidden' name='currency_code' value='{$this->Currency}' />
					
					<input type='hidden' name='email' value='{$this->ClientEmail}' />
					
					
				

                    <noscript><p>Your browser doesn't support Javscript, click the button below to process the transaction.</p>
                    <a style=\"{$hide}\" href=\"#\" onclick=\"jQuery('#_wpdm_bnf').submit();return false;\">Buy Now&nbsp;<img align=right alt=\"TwoCheckOut\" src=\"$TwoCheckOut\" /></a>                    </noscript>
                    </form>
         
        
        ";
        
        if($AutoSubmit==1)
        $Form .= "<center>Proceeding to TwoCheckOut....</center><script language=javascript>setTimeout('document._wpdm_bnf_{$this->InvoiceNo}.submit()',2000);</script>";
        
        return $Form;
        
        
    }
    
    
    function VerifyPayment() 
	 {
		 //UPPERCASE(MD5_ENCRYPTED(Secret Word + Seller ID + order_number + Sale Total))
		 // the name of the file you're writing to
			$myFile = "2checkout-log.txt";	
			$fh = fopen($myFile, 'a') or die("can't open file");
			
		 if ($_POST['message_type'] == 'ORDER_CREATED') 
		 {
			 
			

				$insMessage = array();
				foreach ($_POST as $k => $v) 
				{
				$insMessage[$k] = $v;
				}
			fwrite($fh, "Order Created \n");
			# Validate the Hash
			$hashSecretWord = $this->Pwd; # Input your secret word
			$hashSid = $this->Business; #Input your seller ID (2Checkout account number)
			$hashOrder = $insMessage['sale_id'];
			$hashInvoice = $insMessage['invoice_id'];
			$StringToHash = strtoupper(md5($hashOrder . $hashSid . $hashInvoice . $hashSecretWord));
			fwrite($fh, "Sales ID: ".$hashOrder." \n");
			
			if ($StringToHash != $insMessage['md5_hash']) 
			{
				fwrite($fh, "Hash Incorrect \n");
				$this->last_error = "Hash Incorrect.";
				$this->log_ipn_results(false);       
				return false;
				die('Hash Incorrect');
				
			}
			else
			{
				if($insMessage['fraud_status']=='pass')
				{
				fwrite($fh, "Frud Pass \n");
				return true;
				}
				else
				{
					fwrite($fh, "sales failed \n");
				$this->VerificationError = 'Sales Failed or waiting';        
				return false;
				}
			}

		
		 }
		 else
		 {
			 $stringData = "Order not created \n";
			fwrite($fh, $stringData);
		 }
		
		fwrite($fh, $stringData);
		fclose($fh);
   }
   
   function VerifyNotification(){
       
       if($_POST)
	   {
           $this->order_id=$_POST['item_id_1'];
		   
		   $file = 'post.txt';
		   $somecontent = print_r($_POST, TRUE);
			//echo $somecontent;// see sample output below
			// open file
			$fp = fopen($file, 'w') or die('Could not open file!');
			// write to file
			fwrite($fp, "$somecontent") or die('Could not write to file');
			// close file
			fclose($fp);
		   
		   
		   
		   
           return $this->VerifyPayment();
       }
       else 
		   die("Problem occured in payment.");
   }
    
    
}
}
?>