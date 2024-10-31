<?php
$output_middle='

<div class="pure-u-1 pure-u-md-1-'.$perrow.'">

    
  <div class="obox">
    <div class="header"><a href="'.$permalink.'">'.$thetitle.'</a>
      <div class="date">'.$price.'</div>
    </div>
    <div class="body" style="text-align:center"><a href="'.$permalink.'">'.odude_img('icon').'</a></div>
   
    <div class="footer" style="text-align:center">

	'.$cart_but.'
	
	</div>
  </div>
  
  </div>';
  
  return $output_middle;
  ?>