<?php 
/**
 *  This Class will manage logic when shipping method is active
 * 
 */
if(!class_exists('SHM_ShippingRestrictions')) {
    class SHM_ShippingRestrictions {
        public function __construct() {

            add_filter('woocommerce_package_rates', array($this, 'disable_shipping_based_on_time'));
            add_filter('woocommerce_package_rates', array($this, 'disable_shipping_based_on_weekday'));
            add_filter('woocommerce_package_rates', array($this, 'disable_shipping_on_specific_dates'));
        }

        // Disable shipping based on time
        public function disable_shipping_based_on_time() {
            // Get the current time
            $current_time = current_time('H:i');

            $start_time = get_option('shipping_hours_manager_start_time', '');
            $end_time = get_option('shipping_hours_manager_end_time', '');


            // Disable shipping if current time is within the specified range
            if ($current_time >= $start_time && $current_time <= $end_time) {
                WC()->cart->empty_cart();
                wc_add_notice(__('Shipping is disabled during this time range.'), 'error');
            }
        }

        // Disable shipping based on weekdays
        public function disable_shipping_based_on_weekday() {
            // $disabled_weekdays = array('monday', 'wednesday', 'friday');
            $disabled_weekdays_str = strtolower(get_option('shipping_hours_manager_closing_days', ''));

            $disabled_weekdays =  explode(',', $disabled_weekdays_str);
            // Get the current weekday
            $current_weekday = strtolower(date('l'));

            // Disable shipping if it's a disabled weekday
            if (in_array($current_weekday, $disabled_weekdays)) {
                WC()->cart->empty_cart();
                wc_add_notice(__('Shipping is disabled on '.$disabled_weekdays_str), 'error');
            }
        }

        // Disable shipping on specific dates
        public function disable_shipping_on_specific_dates() {
            // $disabled_dates = array('2023-11-15', '2023-12-25');


            $disabled_dates_str = get_option('shipping_hours_manager_closing_dates', '');

            $disabled_dates =  explode(',', $disabled_dates_str);

            // Get the current date
            $current_date = date('Y-m-d');

            // Disable shipping if it's on a disabled date
            if (in_array($current_date, $disabled_dates)) {
                WC()->cart->empty_cart();
                wc_add_notice(__('Shipping is disabled on '.$disabled_dates_str), 'error');
            }
        }
    }


}