<?php
function wppre_additional_preview_images(){             
    @extract(get_post_meta($_GET['post'],"odudes_list_opts",true)); 
    $adpdir = odudes_IMAGE_DIR;     
?>
<style type="">
#apvUploader {background: transparent url('<?php echo plugins_url(); ?>/odudeshop/images/browse.png') left top no-repeat; }
#apvUploader:hover {background-position: left bottom; }
.highlight{
    border:1px solid #F79D2B;
    background:#FDE8CE;
    width: 40px;
    height: 40px;
    float:left;padding:5px;
}
.adp{
    float:left;padding:5px;
}
</style>






<?php
// adjust values here
$id = "img1"; // this will be the name of form field. Image url(s) will be submitted in $_POST using this key. So if $id == �img1� then $_POST[�img1�] will have all the image urls
 
$svalue = ""; // this will be initial value of the above form field. Image urls.
 
$multiple = true; // allow multiple files upload
 
$width = null; // If you want to automatically resize all uploaded images then provide width here (in pixels)
 
$height = null; // If you want to automatically resize all uploaded images then provide height here (in pixels)
?>
 
<input type="hidden" name="odudes_list[images1]" id="<?php echo $id; ?>" value="<?php echo $svalue; ?>" />
<!--<input type="hidden" name="odudes_list[images][]" id="<?php echo $id; ?>" value="<?php echo $svalue; ?>" />-->
<div class="plupload-upload-uic hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-upload-ui">
    <input id="<?php echo $id; ?>plupload-browse-button" type="button" value="<?php esc_attr_e(__('Browse','odudeshop')); ?>" class="button" />
    <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($id . 'pluploadan'); ?>"></span>
    <?php if ($width && $height): ?>
            <span class="plupload-resize"></span><span class="plupload-width" id="plupload-width<?php echo $width; ?>"></span>
            <span class="plupload-height" id="plupload-height<?php echo $height; ?>"></span>
    <?php endif; ?>
    <div class="filelist"></div>
</div>
<div class="plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-thumbs">
</div>
<div class="clear"></div>



  
  
<ul id="adpcon">
<?php
  
    if(isset($images) && is_array($images)){
        foreach($images as $mpv){
            //if(file_exists($adpdir.$mpv)){
            
			$uiu = odudes_IMAGE_URL;
			$odude_large_sub ="{$uiu}{$mpv}";
			$pp=odudes_IMAGE_DIR."odude_75_".$mpv;
			 
			 if (file_exists($pp))
			 {
					$odude_large_sub ="{$uiu}odude_75_{$mpv}";
				
			 }
				$mmv=0; 
			?>
             <li id='<?php echo ++$mmv; ?>' class='adp'>
             <input type='hidden'  id='in_<?php echo $mmv; ?>' name='odudes_list[images][]' value='<?php echo $mpv; ?>' />
             <img style='position:absolute;z-index:9999;cursor:pointer;' id='del_<?php echo $mmv; ?>' rel="<?php echo $mmv; ?>" src='<?php echo plugins_url(); ?>/odudeshop/images/remove.png' class="del_adp" align=left />
             <img src='<?php echo $odude_large_sub; ?>' width='75' height='75'/>
             <div style='clear:both'></div>
             </li>
            <?php
        }
    //}
    }
?>
</ul><br clear="all" />
<!--<input type="file" id="apv" name="apv">-->

<div class="clear"></div>
 
 
<script type="text/javascript">
      
      jQuery(document).ready(function() {
        jQuery('#adpcon').sortable({placeholder:'highlight'});
             
        jQuery('.del_adp').live("click",function(){
                                if(confirm('Are you sure?')){
                                    //jQuery.post(ajaxurl,{action:'odudes_delete_preview',file:jQuery('#in_'+jQuery(this).attr('rel')).val()})
                                    jQuery('#'+jQuery(this).attr('rel')).fadeOut().remove();
                                }
                                
                            });
   
      });
  
      </script>
<?php    
} 

function odudes_format_name($text){
            $allowed = "/[^a-z0-9\\.\\-\\_]/i";      
            $text = preg_replace($allowed,"-",$text);
            $text = preg_replace("/([\\-]+)/i","-",$text);
            return $text;
}   

function odudes_upload_previews()
{
     $adpdir = odudes_IMAGE_DIR;
     if((isset($_GET['task'],$_FILES['Filedata']['tmp_name']) && is_uploaded_file($_FILES['Filedata']['tmp_name'])   && $_GET['task']=='odudes_upload_previews')){
        $tempFile = $_FILES['Filedata']['tmp_name'];    
        $targetFile =  $adpdir ."wpdm-adp-". time().'-'.odudes_format_name($_FILES['Filedata']['name']);
        move_uploaded_file($tempFile, $targetFile);
        echo basename($targetFile);        
        die();
     }
     
}

function odudes_delete_preview(){
    @unlink(odudes_IMAGE_DIR.$_POST['file']);
    
    die();
}

 
 
function odudes_get_thumbs($id){
    global $post;
    @extract(get_post_meta($id,"odudes_list_opts",true));      
    $img = '';     
     
    if($images){
    $t = count($images);
    foreach($images as $p){
        ++$k;
        echo "<a class='colorbox' rel='colorbox' title='{$post->post_title} &#187; Image {$k} of $t' href='".odudes_IMAGE_URL."{$p}' id='more_previews_a_{$k}' class='more_previews_a' ><img id='more_previews_{$k}' class='more_previews' src='".odudes_IMAGE_URL.$p."'/></a>";
    }}
    
   
}

function odudes_meta_box_images($meta_boxes)
{
    $meta_boxes['odudes-images'] = array('title'=>__('Product Images',"odudeshop"),'callback'=>'wppre_additional_preview_images','position'=>'side','priority'=>'low');
    return $meta_boxes;
}

if(is_admin())  {
    /*wp_enqueue_script('swfobject',plugins_url().'/odudeshop/uploadify/swfobject.js');
    wp_enqueue_script('uploadify',plugins_url().'/odudeshop/uploadify/jquery.uploadify.v2.1.4.min.js');
    wp_enqueue_style('uploadify',plugins_url().'/odudeshop/uploadify/uploadify.css');*/
    
    add_action("init","odudes_upload_previews");
    add_action("wp_ajax_odudes_delete_preview","odudes_delete_preview");
    add_filter("odudes_meta_box","odudes_meta_box_images");
}


 
