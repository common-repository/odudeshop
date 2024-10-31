jQuery(function($){
    
    $('.cart_form').submit(function(e){
        e.preventDefault();
        var form = $(this);
        form.find("button[type=submit]").html("<i class='fa fa-spin fa-spinner'></i> Adding to cart... <i class='fa fa-arrow-right'></i>");  
        form.ajaxSubmit({
            success: function(res)
			{
              form.find("button[type=submit]").html("<i class='fa fa-check-circle'></i> Add more <i class='fa fa-arrow-right'></i>").after("<div class='odude_right' style='position:absolute;z-index:99999;padding:3px 10px;'><a href='"+res+"' title='View Cart'><i class=\"fa fa-truck fa-lg\"></i></a></div>");  
            ajax_call();
			}
        });
        
        return false;
        
    });
    
     
    
});



	function ajax_call()
	{	
	jQuery.ajax({
  url: ajaxurl,
  type: 'POST',
  data: { post_id : 1, action : 'get_item_in_cart' },
  beforeSend: function() {
		jQuery("#odude_ajax_loading").show();
		jQuery("#odude_default").hide();
		//jQuery("#odude_ajax_loading").html('Loading...');
  },		  
  success: function(data) {
		jQuery("#odude_ajax_loading").html(data);
  }
});
	}
