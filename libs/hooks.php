<?php		
//Adding facebook image meta tag for product page
add_action('wp_head', 'odude_metatag_facebook_head');	
add_action('init', 'odudes_check_user');
add_action('init', 'odudes_post_types');
add_action('init', 'odudes_update_cart');
//add_action( 'init', 'odudes_update_shipping');
add_action('init', 'odudes_remove_cart_item');
add_action('wp_loaded', 'odudes_do_register');
add_action('wp_loaded', 'odudes_do_login');
add_action('init', 'odudes_save_billing_info');
add_action('init', 'odudes_save_shipping_info');
add_action('init', 'odudes_save_payment_method_info');
add_action('init', 'odudes_place_order');
//for the payment notification by the user
add_action("init", "odudes_payment_notification");

add_action('init', 'ajaxinit');
add_action('init', 'odudes_add_to_cart');
//payment from the theme orders panel
add_action('init', 'odudes_ajax_payfront');


//for the print invoice
add_action('init', 'odudes_print_invoice');

add_action('init', 'register_ODudeShop_product_taxonomies');
add_action('init', 'odudes_download', 0);
add_action('the_content', 'odudes_buynow', 999999);
add_filter('the_content', 'odudes_myorders');
add_filter('wp_head', 'odudes_head');
add_filter("the_content", "odudes_the_content");
add_filter("odudes_product_price", "odudes_weightndim");
add_shortcode('odudes-checkout', 'odudes_checkout');
add_shortcode("odudes-cart", "odudes_show_cart");
//short code for edit profile
add_shortcode("odudes-edit-profile", "odudes_edit_profile");
//user orders
add_shortcode('my-orders-sc', 'odudes_user_order');
add_shortcode("odudes-orders", "odudes_orders");
add_shortcode("odudes-all-products", "odudes_all_products");
add_shortcode("odudes-all-catlist", "odudes_all_catlist");
add_shortcode("odudes-all-section", "odudes_all_section");

//add_shortcode("odudes-all-feature-products", "odudes_all_feature_products");

if (is_admin()) {
	add_action("admin_menu", "odudes_menu");
	add_action('admin_init', 'odudes_meta_boxes', 0);
	add_action('save_post', 'odudes_save_meta_data', 10, 2);
	//add_action('delete_post', 'odudes_delete_product');
	add_action('wp_ajax_odudes_save_settings', 'odudes_save_settings');
	add_action('wp_ajax_odudes_ajax_call', 'odudes_ajax_call');
	add_action('wp_ajax_moveuploadprevfile', 'odudes_move_upload_previewfile');
	add_action('wp_ajax_moveuploadprofile', 'odudes_move_upload_productfile');
	add_action('wp_ajax_moveuploadfeaturedfile', 'odudes_move_upload_featuredfile');
	//for auto suggest tool
	add_action('wp_ajax_odudes_autosuggest', 'odudes_autosuggest');
	//for removing feature product
	add_action('wp_ajax_odudes_remove_featured', 'odudes_remove_featured');

	//add_action( 'wp_ajax_odudes_save_currencies', 'odudes_save_currencies');
	//for default currency saving
	add_action('wp_ajax_odudes_default_currency', 'odudes_default_currency');
	//for default currency deleting
	add_action('wp_ajax_odudes_default_currency_del', 'odudes_default_currency_del');
	//wp_enqueue_script('jquery-form');
}
if(!is_admin())
add_action('init', 'odudes_delete_product');
add_action('wp_enqueue_scripts', 'odudes_enqueue_scripts');
add_action('admin_enqueue_scripts', 'odudes_enqueue_scripts');
add_action('init', 'odudes_init');
add_action('admin_enqueue_scripts', 'odudes_plu_admin_enqueue');
add_action("admin_head", "plupload_admin_head");
add_action('wp_ajax_plupload_action', "g_plupload_action");
add_action('admin_notices', 'odudes_check_dir');

add_action('show_user_profile', 'add_zip_profile_fields');
add_action('edit_user_profile', 'add_zip_profile_fields');
add_action('profile_update', 'save_userzip_data', 10, 2);

add_action('init', 'odudes_languages');
add_action('init', 'odudes_update_profile');