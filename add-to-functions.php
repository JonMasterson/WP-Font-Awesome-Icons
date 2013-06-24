<?php
// Add this to your theme's functions file...

function admin_icons() {
	wp_register_style( 'admin-ui-icons-css', get_template_directory_uri() . '/css/icon-styles.css', '1.0.0' );
	wp_enqueue_style( 'admin-ui-icons-css' );
}
add_action( 'admin_enqueue_scripts', 'admin_icons' );