<?php
//odudes-all-catlist functions here
$disp='';
$ptype='';
if(isset($params['ptype'])) $ptype = $params['ptype'];
$show_empty='0';
if(isset($params['show_empty'])) $show_empty = $params['show_empty'];
$show_as='0';
if(isset($params['show_as'])) $show_as = $params['show_as'];
$show_count='0';
if(isset($params['show_count'])) $show_count = $params['show_count'];

$cates = get_term_by('slug', $ptype, 'ptype');
$catesid=$cates->term_id;


	$args = array(
	'show_option_all'    => '',
	'orderby'            => 'name',
	'order'              => 'ASC',
	'style'              => 'list',
	'show_count'         => $show_count,
	'hide_empty'         => $hide_empty,
	'use_desc_for_title' => 1,
	'child_of'           => $catesid,
	'feed'               => '',
	'feed_type'          => '',
	'feed_image'         => '',
	'exclude'            => '',
	'exclude_tree'       => '',
	'include'            => '',
	'hierarchical'       => 1,
	'title_li'           => __( 'Categories' ),
	'show_option_none'   => __( 'Select Category' ),
	'number'             => null,
	'echo'               => 0,
	'depth'              => 0,
	'current_category'   => 0,
	'pad_counts'         => 0,
	'taxonomy'           => 'ptype',
	'walker'             => null,
	'value_field'	     => 'slug'
    );

	

$categories = get_categories( $args );
$catesdesp=$cates->description;

	

if($show_as=='link')
		{
				$disp.=wp_list_categories( $args );
		}
		else
		{
			
			
			
			
				 $disp.=wp_dropdown_categories( $args );
				 //$replace = "<select$1 onchange='window.location.href =/section/'>";
				 //$disp.= preg_replace( '#<select([^>]*)>#', $replace, $select );
			
			$disp.='<script type="text/javascript">
     var urlmenu = document.getElementById("cat");
     urlmenu.onchange = function() 
	 {
          window.open( "'.get_site_url().'/section/"+this.options[ this.selectedIndex ].value, "_self");
     };
    </script>';
			
			
		}	
	
return $disp;
?>