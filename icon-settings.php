<?php
/**
 * Creates a settings page for admin icons under "Settings"
 */

if ( !defined('ABSPATH') ) { die('-1'); }

function add_icons_menu() {
	add_theme_page( 
		'Icons',
		'Icons',
		'administrator',
		'icon_settings',
		'display_icon_settings'
	);
}
add_action( 'admin_menu', 'add_icons_menu' );

/**
 * Add scripts and styles for the modal window
 */
function icon_page_scripts_styles() {
	$screen = get_current_screen(); 
	if ( $screen->id == 'appearance_page_icon_settings' ) {
		wp_register_script( 'reveal_js', plugins_url( 'assets/js/jquery.reveal.js', __FILE__ ), array( 'jquery' ), false, '1.0' );
		wp_enqueue_script('reveal_js');
		wp_register_style( 'reveal_css', plugins_url( 'assets/css/reveal.css', __FILE__ ), false, '1.0' );
		wp_enqueue_style('reveal_css');
	}
	else { 
		return;
	}
}
add_action('admin_enqueue_scripts', 'icon_page_scripts_styles');
 
/**
 * Build the Icon Settings Page
 */ 
function display_icon_settings( $active_tab = '' ) { 
	$options = get_option('general_icon_settings');
	$theme_obj = wp_get_theme();
	$theme_name = $theme_obj->get( 'Name' );
?>
<div class="wrap">
	<h2><?php _e( 'Icon Settings', $theme_name ); ?></h2>
    <?php settings_errors(); ?>
    
    <?php if ( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else if ( $active_tab == 'icn_admin_settings' ) {
			$active_tab = 'icn_admin_settings';
		} else if ( $active_tab == 'icn_menu_settings' ) {
				$active_tab = 'icn_menu_settings';
		} else {
			$active_tab = 'icn_general_settings';
		} ?>
        
	<h2 class="nav-tab-wrapper">
			<a href="?page=icon_settings&tab=icn_general_settings" class="nav-tab <?php echo $active_tab == 'icn_general_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General', $theme_name ); ?></a>
			<a href="?page=icon_settings&tab=icn_admin_settings" class="nav-tab <?php echo $active_tab == 'icn_admin_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Admin Menu', $theme_name ); ?></a>
            <?php if ( !isset( $options['frontend_icons'] ) || $options['frontend_icons'] == 0 )  : ?>
			<a href="?page=icon_settings&tab=icn_menu_settings" class="nav-tab <?php echo $active_tab == 'icn_menu_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Nav Menu', $theme_name ); ?></a>
            <?php endif; ?>
		</h2>
        
    <form method="post" enctype="multipart/form-data" action="options.php">
    <?php 
		if ( $active_tab == 'icn_menu_settings' || $active_tab == 'icn_admin_settings' ) {
			$theme_obj = wp_get_theme();
			$theme_name = $theme_obj->get( 'Name' );
			if ( $active_tab == 'icn_admin_settings' ) {
				echo '<p>' . __( 'Replace icons in your admin menu &mdash; Click "Select Icon" for the menu item you\'d like to change, then choose a Font Awesome icon. Save your settings and the icons will change like magic!', $theme_name ) . '</p>';
			} else {
				echo '<p>' . __( 'Add icons to your front end navigation menus &mdash; Click "Select Icon" to add a Font Awesome icon to the menu item. Save your settings and the icons will appear like magic!', $theme_name ) . '</p>';
			}
			echo '<div id="myModal" class="reveal-modal xlarge">';
			echo '<h2>' . __( 'Select an Icon', $theme_name ) . '</h2>';
			echo '<p>';
			$icon_values = array(
				"glass" => "f000",
				"music" => "f001",
				"search" => "f002",
				"envelope-o" => "f003",
				"heart" => "f004",
				"star" => "f005",
				"star-o" => "f006",
				"user" => "f007",
				"film" => "f008",
				"th-large" => "f009",
				"th" => "f00a",
				"th-list" => "f00b",
				"check" => "f00c",
				"times" => "f00d",
				"search-plus" => "f00e",
				"search-minus" => "f010",
				"power-off" => "f011",
				"signal" => "f012",
				"cog" => "f013",
				"trash-o" => "f014",
				"home" => "f015",
				"file-o" => "f016",
				"clock-o" => "f017",
				"road" => "f018",
				"download" => "f019",
				"arrow-circle-o-down" => "f01a",
				"arrow-circle-o-up" => "f01b",
				"inbox" => "f01c",
				"play-circle-o" => "f01d",
				"repeat" => "f01e",
				"refresh" => "f021",
				"list-alt" => "f022",
				"lock" => "f023",
				"flag" => "f024",
				"headphones" => "f025",
				"volume-off" => "f026",
				"volume-down" => "f027",
				"volume-up" => "f028",
				"qrcode" => "f029",
				"barcode" => "f02a",
				"tag" => "f02b",
				"tags" => "f02c",
				"book" => "f02d",
				"bookmark" => "f02e",
				"print" => "f02f",
				"camera" => "f030",
				"font" => "f031",
				"bold" => "f032",
				"italic" => "f033",
				"text-height" => "f034",
				"text-width" => "f035",
				"align-left" => "f036",
				"align-center" => "f037",
				"align-right" => "f038",
				"align-justify" => "f039",
				"list" => "f03a",
				"outdent" => "f03b",
				"indent" => "f03c",
				"video-camera" => "f03d",
				"picture-o" => "f03e",
				"pencil" => "f040",
				"map-marker" => "f041",
				"adjust" => "f042",
				"tint" => "f043",
				"pencil-square-o" => "f044",
				"share-square-o" => "f045",
				"check-square-o" => "f046",
				"arrows" => "f047",
				"step-backward" => "f048",
				"fast-backward" => "f049",
				"backward" => "f04a",
				"play" => "f04b",
				"pause" => "f04c",
				"stop" => "f04d",
				"forward" => "f04e",
				"fast-forward" => "f050",
				"step-forward" => "f051",
				"eject" => "f052",
				"chevron-left" => "f053",
				"chevron-right" => "f054",
				"plus-circle" => "f055",
				"minus-circle" => "f056",
				"times-circle" => "f057",
				"check-circle" => "f058",
				"question-circle" => "f059",
				"info-circle" => "f05a",
				"crosshairs" => "f05b",
				"times-circle-o" => "f05c",
				"check-circle-o" => "f05d",
				"ban" => "f05e",
				"arrow-left" => "f060",
				"arrow-right" => "f061",
				"arrow-up" => "f062",
				"arrow-down" => "f063",
				"share" => "f064",
				"expand" => "f065",
				"compress" => "f066",
				"plus" => "f067",
				"minus" => "f068",
				"asterisk" => "f069",
				"exclamation-circle" => "f06a",
				"gift" => "f06b",
				"leaf" => "f06c",
				"fire" => "f06d",
				"eye" => "f06e",
				"eye-slash" => "f070",
				"exclamation-triangle" => "f071",
				"plane" => "f072",
				"calendar" => "f073",
				"random" => "f074",
				"comment" => "f075",
				"magnet" => "f076",
				"chevron-up" => "f077",
				"chevron-down" => "f078",
				"retweet" => "f079",
				"shopping-cart" => "f07a",
				"folder" => "f07b",
				"folder-open" => "f07c",
				"arrows-v" => "f07d",
				"arrows-h" => "f07e",
				"bar-chart-o" => "f080",
				"twitter-square" => "f081",
				"facebook-square" => "f082",
				"camera-retro" => "f083",
				"key" => "f084",
				"cogs" => "f085",
				"comments" => "f086",
				"thumbs-o-up" => "f087",
				"thumbs-o-down" => "f088",
				"star-half" => "f089",
				"heart-o" => "f08a",
				"sign-out" => "f08b",
				"linkedin-square" => "f08c",
				"thumb-tack" => "f08d",
				"external-link" => "f08e",
				"sign-in" => "f090",
				"trophy" => "f091",
				"github-square" => "f092",
				"upload" => "f093",
				"lemon-o" => "f094",
				"phone" => "f095",
				"square-o" => "f096",
				"bookmark-o" => "f097",
				"phone-square" => "f098",
				"twitter" => "f099",
				"facebook" => "f09a",
				"github" => "f09b",
				"unlock" => "f09c",
				"credit-card" => "f09d",
				"rss" => "f09e",
				"hdd-o" => "f0a0",
				"bullhorn" => "f0a1",
				"bell" => "f0f3",
				"certificate" => "f0a3",
				"hand-o-right" => "f0a4",
				"hand-o-left" => "f0a5",
				"hand-o-up" => "f0a6",
				"hand-o-down" => "f0a7",
				"arrow-circle-left" => "f0a8",
				"arrow-circle-right" => "f0a9",
				"arrow-circle-up" => "f0aa",
				"arrow-circle-down" => "f0ab",
				"globe" => "f0ac",
				"wrench" => "f0ad",
				"tasks" => "f0ae",
				"filter" => "f0b0",
				"briefcase" => "f0b1",
				"arrows-alt" => "f0b2",
				"users" => "f0c0",
				"link" => "f0c1",
				"cloud" => "f0c2",
				"flask" => "f0c3",
				"scissors" => "f0c4",
				"files-o" => "f0c5",
				"paperclip" => "f0c6",
				"floppy-o" => "f0c7",
				"square" => "f0c8",
				"bars" => "f0c9",
				"list-ul" => "f0ca",
				"list-ol" => "f0cb",
				"strikethrough" => "f0cc",
				"underline" => "f0cd",
				"table" => "f0ce",
				"magic" => "f0d0",
				"truck" => "f0d1",
				"pinterest" => "f0d2",
				"pinterest-square" => "f0d3",
				"google-plus-square" => "f0d4",
				"google-plus" => "f0d5",
				"money" => "f0d6",
				"caret-down" => "f0d7",
				"caret-up" => "f0d8",
				"caret-left" => "f0d9",
				"caret-right" => "f0da",
				"columns" => "f0db",
				"sort" => "f0dc",
				"sort-asc" => "f0dd",
				"sort-desc" => "f0de",
				"envelope" => "f0e0",
				"linkedin" => "f0e1",
				"undo" => "f0e2",
				"gavel" => "f0e3",
				"tachometer" => "f0e4",
				"comment-o" => "f0e5",
				"comments-o" => "f0e6",
				"bolt" => "f0e7",
				"sitemap" => "f0e8",
				"umbrella" => "f0e9",
				"clipboard" => "f0ea",
				"lightbulb-o" => "f0eb",
				"exchange" => "f0ec",
				"cloud-download" => "f0ed",
				"cloud-upload" => "f0ee",
				"user-md" => "f0f0",
				"stethoscope" => "f0f1",
				"suitcase" => "f0f2",
				"bell-o" => "f0a2",
				"coffee" => "f0f4",
				"cutlery" => "f0f5",
				"file-text-o" => "f0f6",
				"building-o" => "f0f7",
				"hospital-o" => "f0f8",
				"ambulance" => "f0f9",
				"medkit" => "f0fa",
				"fighter-jet" => "f0fb",
				"beer" => "f0fc",
				"h-square" => "f0fd",
				"plus-square" => "f0fe",
				"angle-double-left" => "f100",
				"angle-double-right" => "f101",
				"angle-double-up" => "f102",
				"angle-double-down" => "f103",
				"angle-left" => "f104",
				"angle-right" => "f105",
				"angle-up" => "f106",
				"angle-down" => "f107",
				"desktop" => "f108",
				"laptop" => "f109",
				"tablet" => "f10a",
				"mobile" => "f10b",
				"circle-o" => "f10c",
				"quote-left" => "f10d",
				"quote-right" => "f10e",
				"spinner" => "f110",
				"circle" => "f111",
				"reply" => "f112",
				"github-alt" => "f113",
				"folder-o" => "f114",
				"folder-open-o" => "f115",
				"smile-o" => "f118",
				"frown-o" => "f119",
				"meh-o" => "f11a",
				"gamepad" => "f11b",
				"keyboard-o" => "f11c",
				"flag-o" => "f11d",
				"flag-checkered" => "f11e",
				"terminal" => "f120",
				"code" => "f121",
				"reply-all" => "f122",
				"mail-reply-all" => "f122",
				"star-half-o" => "f123",
				"location-arrow" => "f124",
				"crop" => "f125",
				"code-fork" => "f126",
				"chain-broken" => "f127",
				"question" => "f128",
				"info" => "f129",
				"exclamation" => "f12a",
				"superscript" => "f12b",
				"subscript" => "f12c",
				"eraser" => "f12d",
				"puzzle-piece" => "f12e",
				"microphone" => "f130",
				"microphone-slash" => "f131",
				"shield" => "f132",
				"calendar-o" => "f133",
				"fire-extinguisher" => "f134",
				"rocket" => "f135",
				"maxcdn" => "f136",
				"chevron-circle-left" => "f137",
				"chevron-circle-right" => "f138",
				"chevron-circle-up" => "f139",
				"chevron-circle-down" => "f13a",
				"html5" => "f13b",
				"css3" => "f13c",
				"anchor" => "f13d",
				"unlock-alt" => "f13e",
				"bullseye" => "f140",
				"ellipsis-h" => "f141",
				"ellipsis-v" => "f142",
				"rss-square" => "f143",
				"play-circle" => "f144",
				"ticket" => "f145",
				"minus-square" => "f146",
				"minus-square-o" => "f147",
				"level-up" => "f148",
				"level-down" => "f149",
				"check-square" => "f14a",
				"pencil-square" => "f14b",
				"external-link-square" => "f14c",
				"share-square" => "f14d",
				"compass" => "f14e",
				"caret-square-o-down" => "f150",
				"caret-square-o-up" => "f151",
				"caret-square-o-right" => "f152",
				"eur" => "f153",
				"gbp" => "f154",
				"usd" => "f155",
				"inr" => "f156",
				"jpy" => "f157",
				"rub" => "f158",
				"krw" => "f159",
				"btc" => "f15a",
				"file" => "f15b",
				"file-text" => "f15c",
				"sort-alpha-asc" => "f15d",
				"sort-alpha-desc" => "f15e",
				"sort-amount-asc" => "f160",
				"sort-amount-desc" => "f161",
				"sort-numeric-asc" => "f162",
				"sort-numeric-desc" => "f163",
				"thumbs-up" => "f164",
				"thumbs-down" => "f165",
				"youtube-square" => "f166",
				"youtube" => "f167",
				"xing" => "f168",
				"xing-square" => "f169",
				"youtube-play" => "f16a",
				"dropbox" => "f16b",
				"stack-overflow" => "f16c",
				"instagram" => "f16d",
				"flickr" => "f16e",
				"adn" => "f170",
				"bitbucket" => "f171",
				"bitbucket-square" => "f172",
				"tumblr" => "f173",
				"tumblr-square" => "f174",
				"long-arrow-down" => "f175",
				"long-arrow-up" => "f176",
				"long-arrow-left" => "f177",
				"long-arrow-right" => "f178",
				"apple" => "f179",
				"windows" => "f17a",
				"android" => "f17b",
				"linux" => "f17c",
				"dribbble" => "f17d",
				"skype" => "f17e",
				"foursquare" => "f180",
				"trello" => "f181",
				"female" => "f182",
				"male" => "f183",
				"gittip" => "f184",
				"sun-o" => "f185",
				"moon-o" => "f186",
				"archive" => "f187",
				"bug" => "f188",
				"vk" => "f189",
				"weibo" => "f18a",
				"renren" => "f18b",
				"pagelines" => "f18c",
				"stack-exchange" => "f18d",
				"arrow-circle-o-right" => "f18e",
				"arrow-circle-o-left" => "f190",
				"caret-square-o-left" => "f191",
				"dot-circle-o" => "f192",
				"wheelchair" => "f193",
				"vimeo-square" => "f194",
				"try" => "f195",
				"plus-square-o" => "f196"
			);
			$previous = null;
			// sort icons alphabetically
			ksort( $icon_values ); 
			foreach( $icon_values as $key => $val ) {
				// sort alphabetized icons by letter
				$firstLetter = substr( $key, 0, 1 );
				if ( $previous !== $firstLetter ) {
					echo "<h2 id='letterz'>" . __( $firstLetter, $theme_name ) . "</h2>";
				}
				if ( $active_tab == 'icn_admin_settings' ) {
					$value = $val;
				} else {
					$value = $key;
				}
				$previous = $firstLetter;
				// create links for each icon
				echo "<div id ='iconz'>";
				echo "<a href='#' class='close-reveal-modal' data-icn-val='" . esc_attr( $value ) . "'> <i class='fa fa-fw'>" . __( '&#x' . $val, $theme_name ) . "</i><span style='padding-left: 5px'><em>" . __( $key, $theme_name ) . "</em></a>";
				echo "</div>";
			} 
		echo '</p>';
		echo '<a class="close-reveal-modal close-butz"><i class="fa fa-fw">' . __( '&#xf057', $theme_name ) . '</i></a>';
		echo '</div>';
	}
	if ( $active_tab == 'icn_general_settings' ) {
		settings_fields( 'general_icon_settings' );
		do_settings_sections( 'general_icon_settings' );
	} elseif ( $active_tab == 'icn_admin_settings' ) {
		settings_fields( 'admin_icon_settings' );
		do_settings_sections( 'admin_icon_settings' );
	} else {
		settings_fields( 'menu_icon_settings' );
		do_settings_sections( 'menu_icon_settings' );
	}
	
	submit_button(); 
	echo '<p>' . __( 'Thank you, ', $theme_name ) . '<a href="https://twitter.com/davegandy" target="_blank">' . __( 'Dave Gandy', $theme_name ) . '</a>' . __( ', for creating and maintaining ', $theme_name ) . '<a href="http://fontawesome.io/" target="_blank">' . __( 'Font Awesome.', $theme_name ) . '</a></p>'; ?>
    </form>
</div>
<?php 
}

/**
 * Provides default values for General Icon Settings.
 */
function default_general_icon_settings() {
	$defaults = array(
		'frontend_icons' =>	'',
		'cdn_fa' =>	'',
	);
	return apply_filters( 'default_general_icon_settings', $defaults );
}

/**
 * Provides default values for Admin Icon Settings.
 */
function default_admin_icon_settings() {
	global $menu;
	$defaults = array();
	if ( $menu ) {
		foreach ( $menu as $m ) {
			if ( isset( $m[5] ) ) {
				$crap = array( "?", "=" );
				$the_id = str_replace( $crap, "-", $m[5] );
				if ( isset( $m[0] ) && $m[0] != '' ) {
					$defaults[ $the_id . '_icon' ] = '';
				}
			}
		}
	}
	return apply_filters( 'default_admin_icon_settings', $defaults );
}

/**
 * Provides default values for Menu Icon Settings.
 */
function default_menu_icon_settings() {
	$defaults = array();
	$nav_menus = get_registered_nav_menus();
	if ( $nav_menus ) {
		foreach ( $nav_menus as $menu => $name ) {
			$items = wp_get_nav_menu_items( $menu );
			if ( $items ) {
				foreach ( $items as $i ) {
					if ( isset( $i->ID ) ) {
						$defaults[ 'icn-menu-item-' . $i->ID ] = '';
						$defaults[ 'icn-after-menu-item-' . $i->ID ] = '';
						$defaults[ 'size-icn-after-menu-item-' . $i->ID ] = '';
						$defaults[ 'size-icn-menu-item-' . $i->ID ] = '';
					}
				}
			}
		}
	}
	return apply_filters( 'default_menu_icon_settings', $defaults );
}

/**
 * Register General Icon Settings
 */ 
function initialize_general_icon_settings() {

	$theme_obj = wp_get_theme();
	$theme_name = $theme_obj->get( 'Name' );
		
	if( false == get_option( 'general_icon_settings' ) ) {	
		add_option( 'general_icon_settings', apply_filters( 'default_general_icon_settings', default_general_icon_settings() ) );
	}
	add_settings_section(
		'general_icon_settings_section',
		__( 'General Icon Settings', $theme_name ),
		'general_icon_settings_callback',
		'general_icon_settings'	
	);
	
	add_settings_field(	
		'frontend_icons',
		__( 'Disable Front End Icons', $theme_name ),
		'frontend_icons_callback',
		'general_icon_settings',
		'general_icon_settings_section',
		array(
			__( 'Disable Font Awesome icons on the front end of your site.', $theme_name ),
		)
	);
	
	add_settings_field(	
		'cdn_fa',
		__( 'Use Local Icon Styles', 'sandbox' ),
		'cdn_fa_callback',
		'general_icon_settings',
		'general_icon_settings_section',
		array(
			__( 'Enqueue Font Awesome icon styles from your site instead of the CDN.', $theme_name ),
		)
	);
	
	register_setting(
		'general_icon_settings',
		'general_icon_settings'
	);
}
add_action( 'admin_init', 'initialize_general_icon_settings' );

/**
 * Register Admin Icon Settings
 */ 
function initialize_admin_icon_settings() {

	$theme_obj = wp_get_theme();
	$theme_name = $theme_obj->get( 'Name' );
		
	if ( false == get_option( 'admin_icon_settings' ) ) {	
		add_option( 'admin_icon_settings', apply_filters( 'default_admin_icon_settings', default_admin_icon_settings() ) );
	}
	
	add_settings_section(
		'admin_icon_settings_section',
		__( 'Admin Menu Icon Settings', $theme_name ),
		'admin_icon_settings_section_callback',
		'admin_icon_settings'
	);
	
	global $menu;
	if ( $menu ) {
		foreach ( $menu as $m ) {
			if ( isset( $m[5] ) ) {
				$crap = array( "?", "=", "/" );
				$the_id = str_replace( $crap, "-", $m[5] );
				if ( isset( $m[0] ) && $m[0] != '' ) {
					$title = preg_replace( '/\d/', '', $m[0] ); // removes the count from some menu titles
					$field_args = array(
						'id'        =>  $the_id.'_icon',
						'name'      =>  $the_id.'_icon',
						'desc'      =>  '',
						'std'       =>  '',
						'label_for' =>  $title,
						'class'     =>  'linker'
					);
					add_settings_field( 
						$the_id, 
						$title, 
						'admin_icon_settings_callback', 
						'admin_icon_settings', 
						'admin_icon_settings_section', 
						$field_args 
					);
				}
			}
		}
	}
	register_setting(
		'admin_icon_settings',
		'admin_icon_settings',
		'sanitize_admin_icon_settings'
	);
}
add_action( 'admin_init', 'initialize_admin_icon_settings' );

/**
 * Register Navigation Menu Icon Settings
 */ 
function initialize_menu_icon_settings() {
	$options = get_option('general_icon_settings');
	if ( !isset( $options['frontend_icons'] ) || $options['frontend_icons'] == 0 ) {

		$theme_obj = wp_get_theme();
		$theme_name = $theme_obj->get( 'Name' );
			
		if ( false == get_option( 'menu_icon_settings' ) ) {	
			add_option( 'menu_icon_settings', apply_filters( 'default_menu_icon_settings', default_menu_icon_settings() ) );
		}
		
		$nav_menus = get_registered_nav_menus();
		if ( $nav_menus ) {
			foreach ( $nav_menus as $menu => $name ) {
				$items = wp_get_nav_menu_items( $menu );
				if ( $items ) {
					add_settings_section(
						$menu . '_section',
						__( $name, $theme_name ),
						'menu_icon_settings_callback',
						'menu_icon_settings'
					);
					foreach ( $items as $i ) {
						if ( isset( $i->title ) && isset ( $i->ID ) ) {
							$before_field = array(
								'id'        =>  'icn-menu-item-' . $i->ID,
								'name'      =>  'icn-menu-item-' . $i->ID,
								'desc'      =>  'Add icon before ' . $i->title,
								'std'       =>  '',
								'label_for' =>  '(Before) ' . $i->title,
								'class'     =>  ''
							);
							$after_field = array(
								'id'        =>  'icn-after-menu-item-' . $i->ID,
								'name'      =>  'icn-after-menu-item-' . $i->ID,
								'desc'      =>  'Add icon after ' . $i->title,
								'std'       =>  '',
								'label_for' =>  $i->title . ' (After)',
								'class'     =>  ''
							);
							$size_before_field = array(
								'id'        =>  'size-icn-menu-item-' . $i->ID,
								'name'      =>  'size-icn-menu-item-' . $i->ID,
								'desc'      =>  'Adjust size of icon before ' . $i->title,
								'std'       =>  '',
								'label_for' =>  '(Before) ' . $i->title . ' Size',
								'class'     =>  ''
							);
							$size_after_field = array(
								'id'        =>  'size-icn-after-menu-item-' . $i->ID,
								'name'      =>  'size-icn-after-menu-item-' . $i->ID,
								'desc'      =>  'Adjust size of icon after ' . $i->title,
								'std'       =>  '',
								'label_for' =>  $i->title . ' (After) Size',
								'class'     =>  ''
							);
							add_settings_field( 
								$i->ID, 
								'(Before) ' . $i->title, 
								'menu_icons_callback', 
								'menu_icon_settings', 
								$menu . '_section', 
								$before_field 
							);
							add_settings_field( 
								$i->ID . '-size', 
								'(Before) ' . $i->title . ' Size', 
								'menu_icons_size_callback', 
								'menu_icon_settings', 
								$menu . '_section', 
								$size_before_field 
							);
							add_settings_field( 
								$i->ID . '-after', 
								$i->title . ' (After)', 
								'menu_icons_callback', 
								'menu_icon_settings', 
								$menu . '_section', 
								$after_field 
							);
							add_settings_field( 
								$i->ID . '-after-size', 
								$i->title . ' (After) Size', 
								'menu_icons_size_callback', 
								'menu_icon_settings', 
								$menu . '_section', 
								$size_after_field 
							);
						}
					}
				}
			}
		}
	}
	
	register_setting(
		'menu_icon_settings',
		'menu_icon_settings',
		'sanitize_menu_icon_settings'
	);
}
add_action( 'admin_init', 'initialize_menu_icon_settings' );

/**
 * General Icon Settings
 */ 
function general_icon_settings_callback() {
	$theme_obj = wp_get_theme();
	$theme_name = $theme_obj->get( 'Name' );
	echo '<p>' . __( 'Disable Font Awesome icons on the front end of your site or change the way you load icon styles.', $theme_name ) . '</p>';
}

function frontend_icons_callback( $args ) {
	$options = get_option('general_icon_settings');
	$html = '<input type="checkbox" id="frontend_icons" name="general_icon_settings[frontend_icons]" value="1" ' . checked( 1, isset( $options['frontend_icons'] ) ? $options['frontend_icons'] : 0, false ) . '/>'; 
	$html .= '<label for="frontend_icons">&nbsp;'  . $args[0] . '</label>'; 
	echo $html;
}

function cdn_fa_callback( $args ) {
	$options = get_option('general_icon_settings');
	$html = '<input type="checkbox" id="cdn_fa" name="general_icon_settings[cdn_fa]" value="1" ' . checked( 1, isset( $options['cdn_fa'] ) ? $options['cdn_fa'] : 0, false ) . '/>'; 
	$html .= '<label for="cdn_fa">&nbsp;'  . $args[0] . '</label>'; 
	echo $html;
}

/**
 * Admin Icon Settings
 */
function admin_icon_settings_section_callback() { } 

function admin_icon_settings_callback( $args ) {
	$theme_obj = wp_get_theme();
	$theme_name = $theme_obj->get( 'Name' );
    extract( $args );
    $option_name = 'admin_icon_settings';
    $options = get_option( $option_name );
	$options[$id] = stripslashes( $options[$id] );
	$options[$id] = esc_attr( $options[$id] );
	if ( isset( $options[$id] ) && $options[$id] != '' ) {
		$showicon =  "&#x" . $options[$id];
		$removeicon = '<span class="' . esc_attr( $id ) . '-killIcns"><a href="#" title="Remove Icon" class="killIcns" data-kill-id="' . esc_attr( $id ) . '">' . __( 'Remove Icon', $theme_name ) . '</a>' . __( '&nbsp; ', $theme_name ) . '</span>';
	} else {
		$showicon = "";
		$removeicon = "";
	}
	echo '<span class="add-inputfield"></span>';
	echo '<span class="add-inputfield-2"></span>';
	echo '<input class="' . esc_attr( $class ) . '" type="hidden" id="' . esc_attr( $id ) . '" name="' . esc_attr( $option_name ) . '[' . esc_attr( $id ) . ']" value="' . $options[$id] . '" />';
	echo '<span class="' . esc_attr( $id ) . '-icn"><i class="fa fa-fw">' . __( $showicon, $theme_name ) . '</i></span>&nbsp;<a href="#" data-reveal-id="myModal" data-hidden-id="' . esc_attr( $id ) . '">' . __( 'Select Icon', $theme_name ) . '</a>' . __( '&nbsp; ' . $removeicon, $theme_name ) . '<span class="' . esc_attr( $id ) . '-ajaxRemove"></span><span class="' . esc_attr( $id ) . '-saveMssg saveMssg"></span>';
}

/**
 * Nav Menu Icon Settings
 */
function add_icon_nav_class( $classes, $item ) {
    if ( $item->title == 'Blog' ) {
        $classes[] = 'fa';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'add_icon_nav_class', 10, 2 );
 
function menu_icon_settings_callback() {}

function menu_icons_callback( $args ) {
	$theme_obj = wp_get_theme();
	$theme_name = $theme_obj->get( 'Name' );
    extract( $args );
    $option_name = 'menu_icon_settings';
    $options = get_option( $option_name );
	$options[$id] = stripslashes( $options[$id] );
	$options[$id] = esc_attr( $options[$id] );
	if ( isset( $options[$id] ) && $options[$id] != '' ) {
		$showicon =  "fa-" . $options[$id];
		$removeicon = '<span class="' . esc_attr( $id ) . '-killIcns"><a href="#" title="Remove Icon" class="killIcns" data-kill-id="' . esc_attr( $id ) . '">' . __( 'Remove Icon', $theme_name ) . '</a>' . __( '&nbsp; ', $theme_name ) . '</span>';
	} else {
		$showicon = "";
		$removeicon = "";
	}
	echo '<span class="add-inputfield"></span>';
	echo '<span class="add-inputfield-2"></span>';
	echo '<input class="' . esc_attr( $class ) . '" type="hidden" id="' . esc_attr( $id ) . '" name="' . esc_attr( $option_name ) . '[' . esc_attr( $id ) . ']" value="' . $options[$id] . '" />';
	echo '<span class="' . esc_attr( $id ) . '-icon"><i class="fa ' . __( $showicon, $theme_name ) . '"></i></span>&nbsp;<a href="#" data-reveal-id="myModal" data-hidden-id="' . esc_attr( $id ) . '">' . __( 'Select Icon', $theme_name ) . '</a>' . __( '&nbsp; ' . $removeicon, $theme_name ) . '<span class="' . esc_attr( $id ) . '-ajaxRemove"></span><span class="' . esc_attr( $id ) . '-saveMssg saveMssg"></span><br /><span class="description">' . esc_attr( $desc ) . '</span>';
}

function menu_icons_size_callback( $args ) {
	$theme_obj = wp_get_theme();
	$theme_name = $theme_obj->get( 'Name' );
    extract( $args );
    $options = get_option( 'menu_icon_settings' );
	$options[$id] = stripslashes( $options[$id] );
	$options[$id] = esc_attr( $options[$id] );
	$html = '<select id="' . esc_attr( $id ) . '" name="menu_icon_settings[' . esc_attr( $id ) . ']">';
	$html .= '<option value="default">' . __( 'Normal', $theme_name ) . '</option>';
	$html .= '<option value="fa-lg"' . selected( $options[$id], 'fa-lg', false ) . '>' . __( 'Large', $theme_name ) . '</option>';
	$html .= '<option value="fa-2x"' . selected( $options[$id], 'fa-2x', false ) . '>' . __( '2x', $theme_name ) . '</option>';
	$html .= '<option value="fa-3x"' . selected( $options[$id], 'fa-3x', false ) . '>' . __( '3x', $theme_name ) . '</option>';	
	$html .= '<option value="fa-4x"' . selected( $options[$id], 'fa-4x', false ) . '>' . __( '4x', $theme_name ) . '</option>';	
	$html .= '<option value="fa-5x"' . selected( $options[$id], 'fa-5x', false ) . '>' . __( '5x', $theme_name ) . '</option>';	
	$html .= '</select>';
	echo $html;
}


function sanitize_admin_icon_settings( $input ) {
	foreach( $input as $k => $v ) {
		if ( !preg_match('/^[f]{1}+[0-9]{1}+[A-z0-9]{2}$/', $v ) ) { // match FA unicode
			$newinput[$k] = ''; // Unicode Nazi says "No save for you!"
		} else {
			$newinput[$k] = sanitize_text_field( $v ); // Unicode Nazi lets you save, but glares at you.
		}
	}
	return $newinput;
}

function sanitize_menu_icon_settings( $input ) {
	$output = array();
	foreach( $input as $key => $value ) {
		if( isset( $input[$key] ) ) {
			$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
		}
	}
	return apply_filters( 'sanitize_menu_icon_settings', $output, $input );
}