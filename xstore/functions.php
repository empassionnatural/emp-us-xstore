<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array('bootstrap'));
    

    if ( is_rtl() ) {
    	wp_enqueue_style( 'rtl-style', get_template_directory_uri() . '/rtl.css');
    }
    
    $timestamp = strtotime("now");
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style', 'bootstrap'),'0.1.'.$timestamp
    );

    wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array(), '', true );

}

add_action( 'wp_enqueue_scripts', 'plugin_scripts', 99 );
function plugin_scripts() {

	wp_enqueue_style( 'bootstrap-select-multi', get_stylesheet_directory_uri() . '/plugins/bootstrap-select/css/bootstrap-select.min.css' );
	wp_enqueue_script( 'bootstrap-core', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', false, false, true );
	wp_enqueue_script( 'bootstrap-select-multi', get_stylesheet_directory_uri() . '/plugins/bootstrap-select/js/bootstrap-select.min.js', array( 'jquery' ), '1.1.1', false );

}
//enqueue custom scripts
add_action( 'wp_enqueue_scripts', 'empdev_custom_scripts_frontend', 99 );

function empdev_custom_scripts_frontend(){

	wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array('jquery'), '1.2.5', false );

}

add_action('pmpro_after_checkout', 'sync_woo_billing_func');

if(!function_exists('sync_woo_billing_func')){
	function sync_woo_billing_func(){
		global $current_user;
		$user_id = get_current_user_id();

		update_user_meta($user_id, 'billing_first_name', $_REQUEST['bfirstname']);
		update_user_meta($user_id, 'billing_last_name', $_REQUEST['blastname']);
		update_user_meta($user_id, 'billing_address_1', $_REQUEST['baddress1']);
		update_user_meta($user_id, 'billing_address_2', $_REQUEST['baddress2']);
		update_user_meta($user_id, 'billing_city', $_REQUEST['bcity']);
		update_user_meta($user_id, 'billing_state', $_REQUEST['bstate']);
		update_user_meta($user_id, 'billing_postcode', $_REQUEST['bzipcode']);
		update_user_meta($user_id, 'billing_country', $_REQUEST['bcountry']);
		update_user_meta($user_id, 'billing_email', $_REQUEST['bconfirmemail']);
		update_user_meta($user_id, 'billing_phone', $_REQUEST['bphone']);

		update_user_meta($user_id, 'shipping_first_name', $_REQUEST['bfirstname']);
		update_user_meta($user_id, 'shipping_last_name', $_REQUEST['blastname']);
		update_user_meta($user_id, 'shipping_address_1', $_REQUEST['baddress1']);
		update_user_meta($user_id, 'shipping_address_2', $_REQUEST['baddress2']);
		update_user_meta($user_id, 'shipping_city', $_REQUEST['bcity']);
		update_user_meta($user_id, 'shipping_state', $_REQUEST['bstate']);
		update_user_meta($user_id, 'shipping_postcode', $_REQUEST['bzipcode']);
		update_user_meta($user_id, 'shipping_country', $_REQUEST['bcountry']);

	}
}

function wc_ninja_remove_password_strength() {
  if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
    wp_dequeue_script( 'wc-password-strength-meter' );
  }
}
add_action( 'wp_print_scripts', 'wc_ninja_remove_password_strength', 100 );

add_filter( "pmpro_registration_checks", "check_username" );

function check_username($pmpro_continue_registration){
  $isValid = preg_match('/^[-a-zA-Z0-9 .]+$/',$_REQUEST['username']);
  $pmpro_error_fields[] = ""; 
  $pmpro_continue_registration = true;  
  if(!$isValid){
      pmpro_setMessage( __( "Invalid username. White space and Special character is not allowed.", 'paid-memberships-pro' ), "pmpro_error" );
      $pmpro_error_fields[] = "username";
      $pmpro_continue_registration = false; 
  }

  return $pmpro_continue_registration;  
}

//EMP Dev Woocommerce
require_once( get_stylesheet_directory() . '/emp-dev-wc/emp-dev-theme-functions.php' );
require_once( get_stylesheet_directory() . '/emp-dev-wc/class-emp-dev-wc-meta-option.php' );

