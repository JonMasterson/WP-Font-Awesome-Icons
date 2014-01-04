<?php
/*
Plugin Name: WP Font Awesome Admin Icons
Plugin URI: http://www.jonmasterson.com
Description: Replace any menu icons with the Font Awesome icon set in the WordPress Admin.
Version: 0.2
Author: Jon Masterson
Author URI: http://jonmasterson.com
Author Email: hello@jonmasterson.com
Credits:
    The Font Awesome icon set was created by Dave Gandy (dave@davegandy.com)
     http://fontawesome.io

License:
  Copyright (C) 2013 Jon Masterson

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

class FontAwesome {
	private static $instance;

    private static function has_instance() {
        return isset(self::$instance) && self::$instance != null;
    }

    public static function get_instance() {
        if (!self::has_instance())
            self::$instance = new FontAwesome;
        return self::$instance;
    }

    public static function setup() {
        self::get_instance();
    }

    protected function __construct() {
        if (!self::has_instance()) {
            add_action('init', array(&$this, 'init'));
        }
    }

    public function init() {
		if ( get_bloginfo( 'version' ) >= '3.8' || 'mp6' === get_user_option( 'admin_color' ) ) { // only works for WordPress version >= 3.8
			add_action( 'admin_enqueue_scripts', array( &$this, 'register_plugin_styles' ) );
			add_action( 'admin_head', array( &$this, 'set_admin_icons' ) );
			require_once( dirname( __FILE__ ) . '/icon-settings.php' );
		} else {
			add_action( 'admin_head', array( &$this,'unsupportedError' ) ); // WordPress version unsupported
		}
    }

    public function register_plugin_styles() {
		wp_register_style( 'font-awesome-icons', plugins_url( 'font-awesome/css/font-awesome.min.css', __FILE__ ), false, '4.0.3' );
   		wp_enqueue_style( 'font-awesome-icons' );
    }
	
	public function unsupportedError() { // Error displays if WordPress version is > 3.8
		echo '<div class="error"><p>' . sprintf( __( 'Sorry, Font Awesome for Admin requires WordPress %s or higher. Please upgrade your WordPress install.' ), '3.8' ) . '</p></div>';
	}
	
	public function set_admin_icons() { 
		global $menu; 
		$icon_options = get_option( 'icon_settings' ); ?>
        
<!-- Styles for Font Awesome Icons -->
<style type="text/css">
#adminmenu .wp-menu-image img {
	display: none;
}
#adminmenu .wp-menu-image {
	background: url('') no-repeat -500px -500px !important;
}
<?php
foreach ( $menu as $m ) {
	if ( isset( $m[5] ) ) {
		$crap = array( "?", "=" );
		$the_id = str_replace( $crap, "-", $m[5] );
		$fa_icon = $icon_options[$the_id.'_icon'];
		if ( isset( $fa_icon ) && $fa_icon != '' ) { 
?>
#adminmenu #<?php esc_attr_e( $the_id ); ?> div.wp-menu-image:before { 
	font-family: FontAwesome !important;
	content: <?php echo "'\\".esc_attr( $fa_icon )."';"; ?> 
}
<?php 
		}
	}
}
?>
</style>
<?php }
}

FontAwesome::setup();
