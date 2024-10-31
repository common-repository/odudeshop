<?php
$settings = maybe_unserialize(get_option('_odudes_settings')); 
$whatsell='';
if(isset($settings['whatsell']))  
$whatsell=$settings['whatsell'];
if($whatsell=='d')
{
	
function odudes_product_files()
{ 
    if(isset($_GET['post'])) $m = get_post_meta($_GET['post'],"odudes_list_opts",true);
    if(isset($m)) @extract($m); 
    // print_r($m);
    $adpdir = odudes_UPLOAD_DIR; //WP_PLUGIN_DIR.'/odudeshop/product-files/';     
?>
      
<div id="product_upload_box">  
    

<?php
// adjust values here
$id = "img2"; // this will be the name of form field. Image url(s) will be submitted in $_POST using this key. So if $id == �img1� then $_POST[�img1�] will have all the image urls
 
$svalue = ""; // this will be initial value of the above form field. Image urls.
 
$multiple = true; // allow multiple files upload
 
$width = null; // If you want to automatically resize all uploaded images then provide width here (in pixels)
 
$height = null; // If you want to automatically resize all uploaded images then provide height here (in pixels)
?>
 
 
<input type="hidden" name="odudes_list[file1]" id="<?php echo $id; ?>" value="<?php echo $svalue; ?>" />
<div class="plupload-upload-uic hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-upload-ui">
    <input id="<?php echo $id; ?>plupload-browse-button" type="button" value="<?php esc_attr_e('Select Product File(s)'); ?>" class="button" />
    <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($id . 'pluploadan'); ?>"></span>
    <?php if ($width && $height): ?>
            <span class="plupload-resize"></span><span class="plupload-width" id="plupload-width<?php echo $width; ?>"></span>
            <span class="plupload-height" id="plupload-height<?php echo $height; ?>"></span>
    <?php endif; ?>
    <div class="filelist"></div>
</div>
<div class="plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-thumbs">
</div>

<ul id="currentfiles">
<?php
        

 if(isset($file) && !is_array($file)&&$file!=''){
     $temp=$file;
        $file=array();
        $file[]=$temp;
 }   
 if(isset($file) && is_array($file)){
     $mmv=0;
        foreach($file as $sfile){
            if($sfile != ""):
?>  
<li id='pro_<?php echo $mmv; ?>'>
<input type="hidden" value="<?php echo $sfile; ?>" name="odudes_list[file][]">
<a href='#' id='<?php echo $mmv; ?>' class="del_pro">&times;</a> <?php echo $sfile; ?>              
             <div style='clear:both'></div>
             </li>
            <?php
            ++$mmv;
            endif;
        }
        
   
    }
?>
</ul><br clear="all" />
<script type="text/javascript">
jQuery(".del_pro").live("click",function(){
    if(confirm("are you sure")){
    jQuery("#pro_"+jQuery(this).attr("id")).remove();
    }
    return false;
});
</script>    
  

<div class="clear"></div>


        
 

      </div>
<?php    
} 



function odudes_delete_product_file(){
    @unlink(odudes_UPLOAD_DIR.$_POST['file']);
    die();
}

function odudes_meta_box_demo($post)
{     
    
      @extract(get_post_meta($post->ID,"odudes_list_opts",true));  
    ?>
    <div id="demo_box">
      
   <ul>
   <li>Multiple file will be downloaded as single zip file.
   <li>Original file source will be hidden
   <li>Files without price will be treated as free download.
   </ul>
      </div>
     <?php
} 

function odudes_digital_files($post)
{
       @extract(get_post_meta($post->ID,"odudes_list_opts",true));
    ?>
    <div>
	<input type="hidden" id="digital_activate" name="odudes_list[digital_activate]" value="1">
    <div style="clear: both; margin: 5px;"></div>

    <div id="dpbox"> 
    <table width="100%">
    <tr>
    <td width="50%"><?php odudes_product_files(); ?></td>
    <td width="50%"><?php odudes_meta_box_demo($post); ?></td>
    </tr>
    </table>
    <?php
    
       
       
       echo "<div class='clear'></div></div>";
}

function odudes_meta_box_product_upload($meta_boxes)
{
    
    $meta_boxes['odudeshop-digital-files'] = array('title'=>'Digital Products','callback'=>'odudes_digital_files','position'=>'normal','priority'=>'core');
    
    return $meta_boxes;
}

if(is_admin())  {
    
    add_action("wp_ajax_odudes_delete_product","odudes_delete_product");
    add_filter("odudes_meta_box","odudes_meta_box_product_upload");

}

}
