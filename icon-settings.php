<?php
/**
 * Creates a settings page for admin icons under "Settings"
 */
 
if ( !defined('ABSPATH') ) { die('-1'); }

add_action('admin_menu', 'add_icons_page');
add_action( 'admin_init', 'register_icon_settings' );

function add_icons_page() {
     add_options_page( 'Icons', 'Icons', 'manage_options', 'icon-settings.php', 'icon_admin_settings_page' ); 
}

/**
 * Build the Icon Settings Page
 */ 
function icon_admin_settings_page() { 
?>
<div class="wrap">
	<h2>Icon Settings</h2>
    <form method="post" enctype="multipart/form-data" action="options.php">
		<?php
            settings_fields('icon_settings');
            do_settings_sections('icon-settings.php');
        ?>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Settings') ?>" />  
        </p>
    </form>
</div>
<?php 
}

/**
 * Register Icon Settings
 */ 
function register_icon_settings() {
    register_setting( 'icon_settings', 'icon_settings', 'validate_icon_settings' );
    add_settings_section( 'admin_menu_section', 'Admin Menu Icons', 'build_admin_menu_section', 'icon-settings.php' );
	global $menu;
	foreach ( $menu as $m ) {
		if ( isset( $m[5] ) ) {
			if ( isset( $m[0] ) && $m[0] != '' ) {
				$title = preg_replace( '/\d/', '', $m[0] ); // removes the count from some menu titles
				$field_args = array(
      				'type'      => 'unicode',
					'id'        => $m[5].'_icon',
					'name'      => $m[5].'_icon',
					'desc'      => 'Enter the unicode of the Font Awesome icon.',
					'std'       => '',
					'label_for' => $title,
					'class'     => ''
				);
				add_settings_field( $m[5], $title, 'build_icon_settings', 'icon-settings.php', 'admin_menu_section', $field_args );
			}
		}
	}
}

/**
 * Text for start of section
 */
function build_admin_menu_section( $section ) { 
?>
<p>
Replace icons in your admin menu &mdash; visit <a href="http://fontawesome.io/cheatsheet/" target="_blank">Font Awesome's cheatsheet</a>, choose an icon, and then copy/paste the icon's unicode (e.g. "f000") into the fields below. Save your settings and the icons will change like magic!
</p>
<?php
}

/**
 * Build Icon Settings
 */
function build_icon_settings( $args ) {
    extract( $args );
    $option_name = 'icon_settings';
    $options = get_option( $option_name );
    switch ( $type ) {  
          case 'unicode':  
              $options[$id] = stripslashes( $options[$id] );  
              $options[$id] = esc_attr( $options[$id] );  
              echo "<input class='regular-text$class' type='text' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";  
              echo ( $desc != '' ) ? "<br /><span class='description'>$desc</span>" : "";  
          break;  
    }
}

/**
 * Validate the input.
 */
function validate_icon_settings( $input ) {
  foreach( $input as $k => $v ) {
	$input = str_replace( '&#x', '', $v ); // remove extra unicode gunk
	$newinput[$k] = sanitize_text_field( $input ); // no html!
  }
  return $newinput;
}
