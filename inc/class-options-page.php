<?php 

if(!class_exists('ShippingHoursManagerOptions')){
    
    class ShippingHoursManagerOptions {
        public function __construct() {
            add_action('admin_menu', array($this, 'add_admin_menu'));
            add_action('admin_init', array($this, 'initialize_settings'));
        }
    
        // Add admin menu
        public function add_admin_menu() {
            add_menu_page(
                'Shipping Hours Manager',
                'Shipping Hours',
                'manage_options',
                'shipping_hours_manager',
                array($this, 'display_option_page'),
                'dashicons-clock' // Use a Dashicon for the menu item
            );
        }
    
        // Display option page
        public function display_option_page() {
            ?>
            <div class="wrap">
                <h1>Shipping Hours Manager</h1>
                <?php
                settings_errors(); // Display any settings errors or success messages
                ?>
                <form method="post" action="options.php">
                    <?php
                        settings_fields('shipping_hours_manager_settings');
                        do_settings_sections('shipping_hours_manager');
                        submit_button();
                    ?>
                </form>
            </div>
            <?php
        }
    
        // Initialize settings
        public function initialize_settings() {
            register_setting('shipping_hours_manager_settings', 'shipping_hours_manager_start_time');
            register_setting('shipping_hours_manager_settings', 'shipping_hours_manager_end_time');
            register_setting('shipping_hours_manager_settings', 'shipping_hours_manager_closing_days');
            register_setting('shipping_hours_manager_settings', 'shipping_hours_manager_closing_dates');
    
            add_settings_section('shipping_hours_manager_section', 'Shipping Hours Settings', array($this, 'display_section_callback'), 'shipping_hours_manager');
    
            add_settings_field('start_time', 'Start Time', array($this, 'display_start_time_callback'), 'shipping_hours_manager', 'shipping_hours_manager_section');
            add_settings_field('end_time', 'End Time', array($this, 'display_end_time_callback'), 'shipping_hours_manager', 'shipping_hours_manager_section');
            add_settings_field('closing_days', 'Closing Days', array($this, 'display_closing_days_callback'), 'shipping_hours_manager', 'shipping_hours_manager_section');
            add_settings_field('closing_dates', 'Closing Dates', array($this, 'display_closing_dates_callback'), 'shipping_hours_manager', 'shipping_hours_manager_section');
            add_settings_error('shipping_hours_manager_settings', 'settings_updated', __('Settings updated successfully.'), 'updated');

        }
    
        // Section callback function
        public function display_section_callback() {
            echo 'Configure the start and end time, closing days, and closing dates for shipping hours.';
        }
    
        // Start time field callback function
        public function display_start_time_callback() {
            $start_time = get_option('shipping_hours_manager_start_time', '');
            echo '<input type="time" name="shipping_hours_manager_start_time" value="' . esc_attr($start_time) . '" />';
        }
    
        // End time field callback function
        public function display_end_time_callback() {
            $end_time = get_option('shipping_hours_manager_end_time', '');
            echo '<input type="time" name="shipping_hours_manager_end_time" value="' . esc_attr($end_time) . '" />';
        }
    
        // Closing days field callback function
        public function display_closing_days_callback() {
            $closing_days = get_option('shipping_hours_manager_closing_days', '');
            echo '<input type="text" name="shipping_hours_manager_closing_days" value="' . esc_attr($closing_days) . '" placeholder="e.g., Saturday, Sunday" />';
            echo '<p class="description">Enter closing days separated by commas (e.g., Saturday, Sunday).</p>';
        }
    
        // Closing dates field callback function
        public function display_closing_dates_callback() {
            $closing_dates = get_option('shipping_hours_manager_closing_dates', '');
            echo '<input type="text" name="shipping_hours_manager_closing_dates" value="' . esc_attr($closing_dates) . '" placeholder="e.g., 2023-12-25, 2023-12-31" />';
            echo '<p class="description">Enter closing dates separated by commas (e.g., 2023-12-25, 2023-12-31).</p>';
        }
        
    }
    
    // Instantiate the class
    $shipping_hours_manager = new ShippingHoursManagerOptions();
    

}
