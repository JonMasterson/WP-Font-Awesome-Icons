<?php
/*
Plugin Name: WP Font Awesome Icons
Plugin URI: http://www.jonmasterson.com
Description: Utilize the Font Awesome icon set to replace admin menu icons, easily add icons to posts from the TinyMCE dropdown menu, and quickly add icons to your native navigation menus.
Version: 4.0.3
Author: Jon Masterson
Author URI: http://jonmasterson.com
Author Email: hello@jonmasterson.com
Credits:
    The Font Awesome icon set was created by Dave Gandy (dave@davegandy.com)
     http://fontawesome.io

License:
  Copyright (C) 2014 Jon Masterson

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

class WPFontAwesomeIcons {
    private static $instance;
    const VERSION = '4.0.3';
	
	private static function has_instance() {
        return isset( self::$instance ) && self::$instance != null;
    }

    public static function get_instance() {
        if ( !self::has_instance() )
            self::$instance = new WPFontAwesomeIcons;
        return self::$instance;
    }

    public static function setup() {
        self::get_instance();
    }

    protected function __construct() {
        if ( !self::has_instance() ) {
            add_action( 'init', array( &$this, 'init_WPFAI' ) );
        }
    }

    public function init_WPFAI() {
		add_action( 'admin_enqueue_scripts', array( &$this, 'register_plugin_styles' ) );
		add_action( 'admin_head', array( &$this, 'set_admin_icons' ) );
		require_once( dirname( __FILE__ ) . '/icon-settings.php' );
		
		$options = get_option( 'general_icon_settings' );
		if ( !isset( $options['frontend_icons'] ) || $options['frontend_icons'] == 0 ) {
			add_action( 'wp_enqueue_scripts', array( &$this, 'register_plugin_styles' ) );
			add_shortcode( 'icon', array( $this, 'icon_shortcode' ) );
			add_filter( 'widget_text', 'do_shortcode' );
			add_filter( 'wp_nav_menu' , array( &$this, 'nav_menu_icn_callback' ), 10, 2 );
			if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) ) {
				add_filter( 'mce_external_plugins', array( &$this, 'register_mce_plugin' ) );
				add_filter( 'mce_buttons', array( &$this, 'add_mce_button' ) );
				add_filter( 'mce_css', array( &$this, 'add_mce_editor_sytle' ) );
				add_filter( 'tiny_mce_before_init', array( &$this, 'change_mce_options' ) );
			}
		}
    }

    public function register_plugin_styles() {
		$options = get_option( 'general_icon_settings' );
		if ( !isset( $options['cdn_fa'] ) || $options['cdn_fa'] == 0 ) {
			wp_enqueue_style( 'icon-styles', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', false, '4.0.3' );
		} else {
        	wp_enqueue_style( 'icon-styles', plugins_url( 'assets/css/font-awesome.min.css', __FILE__ ), false, '4.0.3' );
		}
    }
	
	public function set_admin_icons() { 
		global $menu; 
		$icon_options = get_option( 'admin_icon_settings' ); ?>
        
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
		$poo = array( "?", "=", "/" );
		$the_id = str_replace( $poo, "-", $m[5] );
		$fa_icon = $icon_options[$the_id.'_icon'];
		if ( isset( $fa_icon ) && $fa_icon != '' ) { 
?>
#adminmenu #<?php esc_attr_e( $the_id ); ?> div.wp-menu-image:before { 
	font-family: FontAwesome !important;
	content: <?php echo "'\\".esc_attr( $fa_icon )."' !important;"; ?> 
}
<?php 
		}
	}
}
?>
</style>
<?php }
	
	/**
	 * TinyMCE Editor
	 */
	public function change_mce_options( $init ) { 
		$init[ 'extended_valid_elements' ] = 'i[*]'; // prevent <i> from being eliminated in editor
		return $init;
	}
	
	public function icon_shortcode($params) { // set up shortcode
        extract(shortcode_atts(array(
                    'name'  => '',
                ), $params));
        return '<i class="' . sanitize_html_class( $name ) . '"></i>';
    }
	
	public function register_mce_plugin( $plugin_array ) { // register TinyMCE plugin
        $plugin_array[ 'font_awesome_icons' ] = plugins_url( 'assets/js/mce-icons.js', __FILE__ );
		return $plugin_array;
    }
	
    public function add_mce_button( $buttons ) { // add icon selector to editor
        array_push( $buttons, '|', 'fontAwesomeIconSelect' );
        return $buttons;
    }

    public function add_mce_editor_sytle($mce_css) { // add icon styles to editor
		$options = get_option( 'general_icon_settings' );
		if ( ! empty( $mce_css ) )
			$mce_css .= ',';
		if ( !isset( $options['cdn_fa'] ) || $options['cdn_fa'] == 0 ) {
			$mce_css .= 'http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css';
		} else {
			$mce_css .= plugins_url( 'assets/css/font-awesome.min.css', __FILE__ );
		}
		return $mce_css;
    }
	
	/**
	 * Navigation Menu
	 */
	public function nav_menu_icn_callback( $nav ){
        $menu_item = preg_replace_callback(
            '/(<li[^>]+class=")([^"]+)("?[^>]+>[^>]+>)([^<]+)<\/a>/',
            array( $this, 'replace_nav_menu_item' ),
            $nav
        );
        return $menu_item;
    }
	
	function replace_nav_menu_item( $a ){
		$start = $a[ 1 ];
		$classes = $a[ 2 ];
		$rest = $a[ 3 ];
		$text = $a[ 4 ];
    	$icon_classes = get_option( 'menu_icon_settings' );
		if ( $icon_classes ) {
			$icn_keys = array_keys( $icon_classes );
			$clazzez = explode( ' ', $classes );
			foreach ( $clazzez as $key => $val ) {
				if ( in_array( 'icn-' . $val, $icn_keys ) || in_array( 'icn-after-' . $val, $icn_keys ) || in_array( 'size-icn-after-' . $val, $icn_keys ) || in_array( 'size-icn-' . $val, $icn_keys ) ) {
					if ( $icon_classes[ 'icn-' . $val ] != '' && $icon_classes[ 'icn-after-' . $val ] == '' ) {
						if ( $icon_classes[ 'size-icn-' . $val ] != '' ) {
							$icn_before[] = $icon_classes[ 'icn-' . $val ] . ' ' . $icon_classes[ 'size-icn-' . $val ];
						} else {
							$icn_before[] = $icon_classes[ 'icn-' . $val ];
						}
					} elseif ( $icon_classes[ 'icn-' . $val ] == '' && $icon_classes[ 'icn-after-' . $val ] != '' ) {
						if ( $icon_classes[ 'size-icn-after-' . $val ] != '' ) {
							$icn_after[] = $icon_classes[ 'icn-after-' . $val ] . ' ' . $icon_classes[ 'size-icn-after-' . $val ];
						} else {
							$icn_after[] = $icon_classes[ 'icn-after-' . $val ];
						}
					} elseif ( $icon_classes[ 'icn-' . $val ] != '' && $icon_classes[ 'icn-after-' . $val ] != '' ) {
						if ( $icon_classes[ 'size-icn-' . $val ] != '' ) {
							$icn_both_before[] = $icon_classes[ 'icn-' . $val ] . ' ' . $icon_classes[ 'size-icn-' . $val ];
						} else {
							$icn_both_before[] = $icon_classes[ 'icn-' . $val ];
						}
						if ( $icon_classes[ 'size-icn-after-' . $val ] != '' ) {
							$icn_both_after[] = $icon_classes[ 'icn-after-' . $val ] . ' ' . $icon_classes[ 'size-icn-after-' . $val ];
						} else {
							$icn_both_after[] = $icon_classes[ 'icn-after-' . $val ];
						}
					}
				}
			}
			
			if ( !empty( $icn_before ) && empty( $icn_after ) && empty( $icn_both_before ) ) {
				$newtext = '<i class="fa fa-' . implode( ' ', $icn_before ) . '"></i>&nbsp;&nbsp;' . $text;
			} elseif ( empty( $icn_before ) && !empty( $icn_after ) && empty( $icn_both_before ) ) {
				$newtext = $text . '&nbsp;&nbsp;<i class="fa fa-'. implode( ' ', $icn_after ) .'"></i>';
			} elseif ( empty( $icn_before ) && empty( $icn_after ) && !empty( $icn_both_before ) ) {
				$newtext = '<i class="fa fa-' . implode( ' ', $icn_both_before ) . '"></i>&nbsp;&nbsp;' . $text . '&nbsp;&nbsp;<i class="fa fa-'. implode( ' ', $icn_both_after ) .'"></i>';
			} else {
				$newtext = $text;
			}
			
			$item = $start.$classes.$rest.$newtext.'</a>';
			return $item;
		}
	}
}

WPFontAwesomeIcons::setup();
