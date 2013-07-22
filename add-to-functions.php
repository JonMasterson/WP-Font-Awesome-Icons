<?php
// Add this to your theme's functions file...

function check_active_plugins() {
 if ( is_plugin_active( 'mp6/mp6.php' ) ) { // check if MP6 is active within WP admin
 function admin_icons() {
 wp_register_style( 'admin-ui-icons-css', get_template_directory_uri() . '/css/icon-styles.css', false, '1.0.0' );
 wp_enqueue_style( 'admin-ui-icons-css' );
 }
 add_action( 'admin_enqueue_scripts', 'admin_icons' ); // hook into WP admin
 } 
}
add_action( 'admin_init', 'check_active_plugins' );
