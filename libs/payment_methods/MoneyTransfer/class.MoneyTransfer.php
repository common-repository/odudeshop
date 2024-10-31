<?php
if(!class_exists('MoneyTransfer')){
class MoneyTransfer extends CommonVers{
    var $TestMode;
    
    var $GatewayUrl = "https://www.MoneyTransfer.com/cgi-bin";
    var $GatewayUrl_TestMode = "https://www.sandbox.MoneyTransfer.com/cgi-bin";
    var $Message;
    
    
    function MoneyTransfer($TestMode = 0){
        $this->TestMode = $TestMode;                
        if($TestMode==1)
        $this->GatewayUrl = $this->GatewayUrl_TestMode;
        ///$this->LoadSettings();
    }
    
    
    function ConfigOptions()
	{    
		$this->Enabled='';
		$this->Message='';
        $settings = maybe_unserialize(get_option('_odudes_settings'));
		if(isset($settings['MoneyTransfer']['enabled']))
        $this->Enabled = $settings['MoneyTransfer']['enabled'];
		if(isset($settings['MoneyTransfer']['Message']))
        $this->Message = $settings['MoneyTransfer']['Message'];
        
        
        if(isset($settings['MoneyTransfer_mode']) && $settings['MoneyTransfer_mode']=='sandbox')            
        $this->GatewayUrl = $this->GatewayUrl_TestMode;
        
        if($this->Enabled)$enabled='checked="ehecked"';
        else $enabled = "";
        
        $data='<table>
<tr><td>'.__("Enable/Disable:","odudeshop").'</td><td><input type="checkbox" value="1" '.$enabled.' name="_odudes_settings[MoneyTransfer][enabled]" style=""> '.__("Enable MoneyTransfer","odudeshop").'</td></tr>
<tr><td>'.__("Remark:","odudeshop").'</td><td><textarea name="_odudes_settings[MoneyTransfer][Message]">'.stripslashes($this->Message).'</textarea></td></tr>
<tr><td>
Image URL:
</td><td><img src="'.WP_PLUGIN_URL.'/odudeshop/libs/payment_methods/MoneyTransfer/logo.jpg"><br>
'.WP_PLUGIN_URL.'/odudeshop/libs/payment_methods/MoneyTransfer/logo.jpg
</td></tr>
</table>';
        return $data;
    }
    
    function ShowPaymentForm($AutoSubmit = 0){
        
        if($AutoSubmit==1) $hide = "display:none;'";
        $MoneyTransfer = plugins_url().'/odudeshop/images/MoneyTransfer.png';
        $Form = " 
                   <div class='alert alert-success' style='margin-top:10px'> <b>".__("Order Completed.","odudeshop")."</b> <br> ".__("Please wait while redirected.","odudeshop")."</div>
        
        ";
        
        if($AutoSubmit==1)
        $Form .= "<script language='javascript'>location.href='".home_url()."/members/orders/'</script>";
        
        return $Form;
        
        
    }
    
    
    function VerifyPayment() {

          // parse the MoneyTransfer URL
          $url_parsed=parse_url($this->GatewayUrl);        

          // generate the post string from the _POST vars aswell as load the
          // _POST vars into an arry so we can play with them from the calling
          // script.
          //print_r($_POST);
          
          $this->InvoiceNo = $_POST['invoice'];
          
          $post_string = '';    
          foreach ($_POST as $field=>$value) { 
             $this->ipn_data["$field"] = $value;
             $post_string .= $field.'='.urlencode(stripslashes($value)).'&'; 
          }
          $post_string.="cmd=_notify-validate"; // append ipn command

          // open the connection to MoneyTransfer
          $fp = fsockopen($url_parsed[host],"80",$err_num,$err_str,30); 
          if(!$fp) {
              
             // could not open the connection.  If loggin is on, the error message
             // will be in the log.
             $this->last_error = "fsockopen error no. $errnum: $errstr";
             $this->log_ipn_results(false);       
             return false;
             
          } else { 
     
             // Post the data back to MoneyTransfer
             fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n"); 
             fputs($fp, "Host: $url_parsed[host]\r\n"); 
             fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
             fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
             fputs($fp, "Connection: close\r\n\r\n"); 
             fputs($fp, $post_string . "\r\n\r\n"); 

             // loop through the response from the server and append to variable
             while(!feof($fp)) { 
                $this->ipn_response .= fgets($fp, 1024); 
             } 

             fclose($fp); // close connection

          }
                              
          if (eregi("VERIFIED",$this->ipn_response)) {
      
             // Valid IPN transaction.             
             return true;       
             
          } else {
      
             // Invalid IPN transaction.  Check the log for details.
             $this->VerificationError = 'IPN Validation Failed.';             
             return false;
         
      }
      
   }
    
    
}
}
?>