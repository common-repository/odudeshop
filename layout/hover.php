<?php
$output_middle='
<div class="pure-u-1 pure-u-md-1-'.$perrow.'">

	<div class="image-frame">
	  <h2><a href="'.$permalink.'">'.$thetitle.'</a></h2>
	  <div class="img">'.odude_img('medium').'</div>
	  <p>'.$price.'</p>
	  <div class="image-hover">
		<a href="'.$permalink.'" class="read-more">'.__("More Info","odudeshop").'</a>    
	</div>
	</div>

</div>
';
  
  return $output_middle;
  ?>