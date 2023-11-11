<?php
/*
Plugin Name: Shipping Hours Manager
Description: Manage shipping based on time, weekdays, week-offs, and specific dates for WooCommerce.
Version: 1.0
Author: Vasim Shaikh
*/
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define your constants
define('SHIPPING_HOURS_MANAGER_VERSION', '1.0.0');
define('SHIPPING_HOURS_MANAGER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SHIPPING_HOURS_MANAGER_PLUGIN_URL', plugin_dir_url(__FILE__));
// Add more constants as needed


function shippping_woo_check() {    
    
    //check is woocommerce installed and active
    if(!is_plugin_active('woocommerce/woocommerce.php')){

        // Deactivate the current plugin
        deactivate_plugins(plugin_basename(__FILE__));
        
        ?>
            <div class="notice notice-error is-dismissible">
                <p><?php _e('WooCommerce is not active. Shipping Restrictions requires WooCommerce to function properly.'); ?></p>
            </div>
            <?php
    }
}
add_action( 'admin_init', 'shippping_woo_check' );



include_once SHIPPING_HOURS_MANAGER_PLUGIN_DIR.'inc/class-options-page.php';

include_once SHIPPING_HOURS_MANAGER_PLUGIN_DIR.'inc/class-disable-shipping.php';

$shipping_restrictions = new SHM_ShippingRestrictions();

