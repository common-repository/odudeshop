
<?php
global $sap; 
    wp_enqueue_script('jquery-validate',plugins_url("odudeshop/js/jquery.validate.js"));
?>
       <div class="header" style="<?php if($current_user->ID)echo "display:none";else echo "";?>"><?php echo __("Register / Login","odudeshop");?><div class="date"> &nbsp;</div> </div>
	  <div class="pure-g">
        <div style="<?php if($current_user->ID)echo "display:none";else echo "";?>" class="step a-item" id="csl">
            <div class="row row-fluid">
          <div class="pure-u-1 pure-u-md-1-2"> 
        <h4><?php echo __("Register","odudeshop");?></h4>
       
            <p><?php echo __("Register with us for future convenience:","odudeshop");?></p>
            <div style="display: none;" id="rloading_first"><img  src="<?php echo home_url();?>/wp-admin/images/loading.gif" /></div><div id="rloading_message"></div>
                <form method="post" action="<?php the_permalink(); echo $sap; ?>checkout_register=register" id="registerform" name="registerform" class="pure-form pure-form-stacked" >
                    <?php wp_nonce_field('checkout_register_form', 'checkout_register_nonce'); ?>
                    <input type="hidden" name="permalink" value="<?php the_permalink(); ?>" />
                   
                            <label ><?php echo __("Username","odudeshop"); ?></label>
                            <input type="text"  class="input-text required" id="registerform_user_login" value="<?php echo $_SESSION['tmp_reg_info']['user_login']; ?>" name="reg[user_login]">
                      
                            <label ><?php echo __("E-mail","odudeshop"); ?></label>
                            <input type="text" class="input-text required email" id="registerform_user_email" value="<?php echo $_SESSION['tmp_reg_info']['user_email']; ?>" name="reg[user_email]">
                       
                        
                            <label ><?php echo __("Password","odudeshop"); ?></label>
                            <input type="password" class="input-text required " id="registerform_user_pass" value="<?php echo $_SESSION['tmp_reg_info']['user_email']; ?>" name="reg[user_pass]">
                       
    

<div style="clear: both;"></div>              


            <b><?php echo __("Register and save time!","odudeshop");?></b>
            <p><?php echo __("Register with us for future convenience:","odudeshop");?></p>
            <ul class="ul">
                <li><?php echo __("Fast and easy check out","odudeshop");?></li>
                <li><?php echo __("Easy access to your order history and status","odudeshop");?></li>
            </ul>
             <button id="register_btn" class="btn btn-success" type="submit"><?php echo __("Register","odudeshop");?></button>
             <div id="rmsg"></div>
           </form>
            </div>
     <div class="pure-u-1 pure-u-md-1-2"> 
        <h4><?php echo __("Login","odudeshop");?></h4>
        <p><?php echo __('if you arelady have an account login here:',"odudeshop"); ?></p>
        <div style="display: none;" id="loading_first"><img  src="<?php echo home_url();?>/wp-admin/images/loading.gif" /></div><div id="loading_message"></div>
                <form name="loginform" id="loginform" action="<?php the_permalink(); echo $sap; ?>&task=login" method="post" class="login-form" > 
                    <?php wp_nonce_field('checkout_login_form', 'checkout_login_nonce'); ?>
<input type="hidden" name="permalink" value="<?php the_permalink(); ?>" />
<h1><?php echo __("Login","odudeshop");?></h1>
             
                <label  for="user_login"><?php echo __("Username","odudeshop"); ?></label> 
                <input type="text" name="login[log]" id="loginform_user_login" class="input-text required" value="" size="20" /> 
             
            <br>
                <label  for="user_pass"><?php echo __("Password","odudeshop"); ?></label> 
                <input type="password" name="login[pwd]" id="loginform_user_pass" class="input-text required" value="" size="20" /> 
            
            
            <p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php echo __("Remember Me","odudeshop");?></label></p> 
            
            <p class="login-submit"> 
                <button type="submit" name="wp-submit" id="loginbtn" class="btn btn-success" ><?php echo __("Log In","odudeshop");?></button> 
                <div id="lmsg"></div>
                <input type="hidden" name="redirect_to" value="<?php the_permalink(); ?>" /> 
            </p> 
            <p>  <br>
            <a href="<?php echo home_url('wp-login.php?action=lostpassword'); ?>"><?php echo __('Forgot password?',"odudeshop"); ?></a>
 
<div style="clear: both;"></div>              
            
</form> 
    </div>
</div>
            <div style="clear: both;"></div>
            
        </div>
        </div>
       
    
