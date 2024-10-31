 <?php
    function odudes_update_shipping(){
        if($_REQUEST['update_shipping']=="update"){
            $cart_data=odudes_get_cart_data();            
            $cart_data['shipping']['shipping_method']=$_POST['shipping_method'];
            $cart_data['shipping']['shipping_rate']=$_POST['shipping_rate'];
            odudes_update_cart_data($cart_data);
            
            die();
        }
    }
?>