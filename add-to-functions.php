<?php
// Add this to your theme's functions file...

if ( 'mp6' === get_user_option( 'admin_color' ) ) { // check for MP6 with get_user_option
 function admin_icons() {
  wp_register_style( 'admin-ui-icons-css', get_template_directory_uri() . '/css/icon-styles.css', false, '1.0.0' );
   wp_enqueue_style( 'admin-ui-icons-css' );
 }
 add_action( 'admin_enqueue_scripts', 'admin_icons' ); // hook into WP admin
}
