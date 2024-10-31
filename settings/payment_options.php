<?php
global $payment_methods;
$payment_methods = apply_filters('payment_method', $payment_methods);

/*
<div id="gateway-order" class="section" style="display: block;">                        
    <h3><?php echo __("Payment Gateways","odudeshop");?></h3>
        <p><?php echo __("Your activated payment gateways are listed below.","odudeshop");?> </p>
                        <table cellspacing="0" class="wc_gateways widefat">
                            <thead>
                                <tr>
                                    <th width="1%">Default</th>
                                    <th><?php echo __("Gateway","odudeshop");?></th>
                                    <th><?php echo __("Status","odudeshop");?></th>
                                </tr>
                            </thead>
                            <tbody class="ui-sortable">
                            <?php
                           foreach($payment_methods as $payment_method){  
                            if(class_exists($payment_method))
							{
                                        ?>
                                <tr>
                                        <td width="1%" class="radio">
                                            <input type="radio" value="cheque" name="default_gateway">
                                            
                                        </td>
                                        <td>
                                            <p><strong><?php echo ucfirst($payment_method);?></strong><br>
                                            
                                        </td>
                                        <td><?php if(isset($settings[$payment_method]['enabled']))echo __("Active","odudeshop");else echo __("Inactive","odudeshop");?></td>
                                    </tr>
                                    <?php
                                    }
                                }
                           
                        ?>
                                    
                                    
                                                               </tbody>
                        </table>
                        </div>
*/


?>

                        <div style="clear: both;margin-top:20px ;"></div>
                        
 <h3><?php echo __("Payment Methods Configuration","odudeshop");?></h3>
                        <div id="paccordion" class="wpmppgac">
                        <?php
                         
                          
                         foreach($payment_methods as $payment_method)
						 {  
                            if(class_exists($payment_method)){
                                //echo $pdir.$methods[$j];
                                //include_once($pdir.$methods[$j]."/class.".$methods[$j].".php");
                                $obj=new $payment_method();
                                echo '<h3><a href="#">'.ucfirst($payment_method).'</a></h3>';
                                echo "<div>";
                                echo $obj->ConfigOptions();
                                echo '</div>';
                            }
                         }
                                
                        ?>


                        </div>
                        