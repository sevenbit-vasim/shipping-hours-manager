<?php 
/**
 *  This Class will manage logic when shipping method is active
 * 
 */

if(!class_exists('SHM_ShippingRestrictions'))
{
    class SHM_ShippingRestrictions {
        public function __construct() {
            add_action('woocommerce_before_checkout_process', array($this, 'disable_shipping_based_on_time'));
            add_action('woocommerce_before_checkout_process', array($this, 'disable_shipping_based_on_weekday'));
            add_action('woocommerce_before_checkout_process', array($this, 'disable_shipping_on_specific_dates'));
        }

        // Disable shipping based on time
        public function disable_shipping_based_on_time() {
            // Get the current time
            $current_time = current_time('H:i');

            // Define time range (format: HH:mm)
            $start_time = '12:00';
            $end_time   = '15:00';

            // Disable shipping if current time is within the specified range
            if ($current_time >= $start_time && $current_time <= $end_time) {
                WC()->cart->empty_cart();
                wc_add_notice(__('Shipping is disabled during this time range.'), 'error');
            }
        }

        // Disable shipping based on weekdays
        public function disable_shipping_based_on_weekday() {
            $disabled_weekdays = array('monday', 'wednesday', 'friday');

            // Get the current weekday
            $current_weekday = strtolower(date('l'));

            // Disable shipping if it's a disabled weekday
            if (in_array($current_weekday, $disabled_weekdays)) {
                WC()->cart->empty_cart();
                wc_add_notice(__('Shipping is disabled on this weekday.'), 'error');
            }
        }

        // Disable shipping on specific dates
        public function disable_shipping_on_specific_dates() {
            $disabled_dates = array('2023-11-15', '2023-12-25');

            // Get the current date
            $current_date = date('Y-m-d');

            // Disable shipping if it's on a disabled date
            if (in_array($current_date, $disabled_dates)) {
                WC()->cart->empty_cart();
                wc_add_notice(__('Shipping is disabled on this date.'), 'error');
            }
        }
    }


}