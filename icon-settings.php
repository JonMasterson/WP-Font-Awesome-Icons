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
            <?php if ( !isset( $options['frontend_icons'] ) || $options['frontend_icons'] == 0 )  : 
				if ( !isset( $options['the_nav_icons'] ) || $options['the_nav_icons'] == 0 )  : ?>
                    <a href="?page=icon_settings&tab=icn_menu_settings" class="nav-tab <?php echo $active_tab == 'icn_menu_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Nav Menu', $theme_name ); ?></a>
                <?php endif;
				endif; ?>
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
				"adjust" => "f042",
				"adn" => "f170",
				"align-center" => "f037",
				"align-justify" => "f039",
				"align-left" => "f036",
				"align-right" => "f038",
				"ambulance" => "f0f9",
				"anchor" => "f13d",
				"android" => "f17b",
				"angle-double-down" => "f103",
				"angle-double-left" => "f100",
				"angle-double-right" => "f101",
				"angle-double-up" => "f102",
				"angle-down" => "f107",
				"angle-left" => "f104",
				"angle-right" => "f105",
				"angle-up" => "f106",
				"apple" => "f179",
				"archive" => "f187",
				"arrow-circle-down" => "f0ab",
				"arrow-circle-left" => "f0a8",
				"arrow-circle-o-down" => "f01a",
				"arrow-circle-o-left" => "f190",
				"arrow-circle-o-right" => "f18e",
				"arrow-circle-o-up" => "f01b",
				"arrow-circle-right" => "f0a9",
				"arrow-circle-up" => "f0aa",
				"arrow-down" => "f063",
				"arrow-left" => "f060",
				"arrow-right" => "f061",
				"arrow-up" => "f062",
				"arrows" => "f047",
				"arrows-alt" => "f0b2",
				"arrows-h" => "f07e",
				"arrows-v" => "f07d",
				"asterisk" => "f069",
				"automobile" => "f1b9",
				"backward" => "f04a",
				"ban" => "f05e",
				"bank" => "f19c",
				"bar-chart-o" => "f080",
				"barcode" => "f02a",
				"bars" => "f0c9",
				"beer" => "f0fc",
				"behance" => "f1b4",
				"behance-square" => "f1b5",
				"bell" => "f0f3",
				"bell-o" => "f0a2",
				"bitbucket" => "f171",
				"bitbucket-square" => "f172",
				"bitcoin" => "f15a",
				"bold" => "f032",
				"bolt" => "f0e7",
				"bomb" => "f1e2",
				"book" => "f02d",
				"bookmark" => "f02e",
				"bookmark-o" => "f097",
				"briefcase" => "f0b1",
				"btc" => "f15a",
				"bug" => "f188",
				"building" => "f1ad",
				"building-o" => "f0f7",
				"bullhorn" => "f0a1",
				"bullseye" => "f140",
				"cab" => "f1ba",
				"calendar" => "f073",
				"calendar-o" => "f133",
				"camera" => "f030",
				"camera-retro" => "f083",
				"car" => "f1b9",
				"caret-down" => "f0d7",
				"caret-left" => "f0d9",
				"caret-right" => "f0da",
				"caret-square-o-down" => "f150",
				"caret-square-o-left" => "f191",
				"caret-square-o-right" => "f152",
				"caret-square-o-up" => "f151",
				"caret-up" => "f0d8",
				"certificate" => "f0a3",
				"chain" => "f0c1",
				"chain-broken" => "f127",
				"check" => "f00c",
				"check-circle" => "f058",
				"check-circle-o" => "f05d",
				"check-square" => "f14a",
				"check-square-o" => "f046",
				"chevron-circle-down" => "f13a",
				"chevron-circle-left" => "f137",
				"chevron-circle-right" => "f138",
				"chevron-circle-up" => "f139",
				"chevron-down" => "f078",
				"chevron-left" => "f053",
				"chevron-right" => "f054",
				"chevron-up" => "f077",
				"child" => "f1ae",
				"circle" => "f111",
				"circle-o" => "f10c",
				"circle-o-notch" => "f1ce",
				"circle-thin" => "f1db",
				"clipboard" => "f0ea",
				"clock-o" => "f017",
				"cloud" => "f0c2",
				"cloud-download" => "f0ed",
				"cloud-upload" => "f0ee",
				"cny" => "f157",
				"code" => "f121",
				"code-fork" => "f126",
				"codepen" => "f1cb",
				"coffee" => "f0f4",
				"cog" => "f013",
				"cogs" => "f085",
				"columns" => "f0db",
				"comment" => "f075",
				"comment-o" => "f0e5",
				"comments" => "f086",
				"comments-o" => "f0e6",
				"compass" => "f14e",
				"compress" => "f066",
				"copy" => "f0c5",
				"credit-card" => "f09d",
				"crop" => "f125",
				"crosshairs" => "f05b",
				"css3" => "f13c",
				"cube" => "f1b2",
				"cubes" => "f1b3",
				"cut" => "f0c4",
				"cutlery" => "f0f5",
				"dashboard" => "f0e4",
				"database" => "f1c0",
				"dedent" => "f03b",
				"delicious" => "f1a5",
				"desktop" => "f108",
				"deviantart" => "f1bd",
				"digg" => "f1a6",
				"dollar" => "f155",
				"dot-circle-o" => "f192",
				"download" => "f019",
				"dribbble" => "f17d",
				"dropbox" => "f16b",
				"drupal" => "f1a9",
				"edit" => "f044",
				"eject" => "f052",
				"ellipsis-h" => "f141",
				"ellipsis-v" => "f142",
				"empire" => "f1d1",
				"envelope" => "f0e0",
				"envelope-o" => "f003",
				"envelope-square" => "f199",
				"eraser" => "f12d",
				"eur" => "f153",
				"euro" => "f153",
				"exchange" => "f0ec",
				"exclamation" => "f12a",
				"exclamation-circle" => "f06a",
				"exclamation-triangle" => "f071",
				"expand" => "f065",
				"external-link" => "f08e",
				"external-link-square" => "f14c",
				"eye" => "f06e",
				"eye-slash" => "f070",
				"facebook" => "f09a",
				"facebook-square" => "f082",
				"fast-backward" => "f049",
				"fast-forward" => "f050",
				"fax" => "f1ac",
				"female" => "f182",
				"fighter-jet" => "f0fb",
				"file" => "f15b",
				"file-archive-o" => "f1c6",
				"file-audio-o" => "f1c7",
				"file-code-o" => "f1c9",
				"file-excel-o" => "f1c3",
				"file-image-o" => "f1c5",
				"file-movie-o" => "f1c8",
				"file-o" => "f016",
				"file-pdf-o" => "f1c1",
				"file-photo-o" => "f1c5",
				"file-picture-o" => "f1c5",
				"file-powerpoint-o" => "f1c4",
				"file-sound-o" => "f1c7",
				"file-text" => "f15c",
				"file-text-o" => "f0f6",
				"file-video-o" => "f1c8",
				"file-word-o" => "f1c2",
				"file-zip-o" => "f1c6",
				"files-o" => "f0c5",
				"film" => "f008",
				"filter" => "f0b0",
				"fire" => "f06d",
				"fire-extinguisher" => "f134",
				"flag" => "f024",
				"flag-checkered" => "f11e",
				"flag-o" => "f11d",
				"flash" => "f0e7",
				"flask" => "f0c3",
				"flickr" => "f16e",
				"floppy-o" => "f0c7",
				"folder" => "f07b",
				"folder-o" => "f114",
				"folder-open" => "f07c",
				"folder-open-o" => "f115",
				"font" => "f031",
				"forward" => "f04e",
				"foursquare" => "f180",
				"frown-o" => "f119",
				"gamepad" => "f11b",
				"gavel" => "f0e3",
				"gbp" => "f154",
				"ge" => "f1d1",
				"gear" => "f013",
				"gears" => "f085",
				"gift" => "f06b",
				"git" => "f1d3",
				"git-square" => "f1d2",
				"github" => "f09b",
				"github-alt" => "f113",
				"github-square" => "f092",
				"gittip" => "f184",
				"glass" => "f000",
				"globe" => "f0ac",
				"google" => "f1a0",
				"google-plus" => "f0d5",
				"google-plus-square" => "f0d4",
				"graduation-cap" => "f19d",
				"group" => "f0c0",
				"h-square" => "f0fd",
				"hacker-news" => "f1d4",
				"hand-o-down" => "f0a7",
				"hand-o-left" => "f0a5",
				"hand-o-right" => "f0a4",
				"hand-o-up" => "f0a6",
				"hdd-o" => "f0a0",
				"header" => "f1dc",
				"headphones" => "f025",
				"heart" => "f004",
				"heart-o" => "f08a",
				"history" => "f1da",
				"home" => "f015",
				"hospital-o" => "f0f8",
				"html5" => "f13b",
				"image" => "f03e",
				"inbox" => "f01c",
				"indent" => "f03c",
				"info" => "f129",
				"info-circle" => "f05a",
				"inr" => "f156",
				"instagram" => "f16d",
				"institution" => "f19c",
				"italic" => "f033",
				"joomla" => "f1aa",
				"jpy" => "f157",
				"jsfiddle" => "f1cc",
				"key" => "f084",
				"keyboard-o" => "f11c",
				"krw" => "f159",
				"language" => "f1ab",
				"laptop" => "f109",
				"leaf" => "f06c",
				"legal" => "f0e3",
				"lemon-o" => "f094",
				"level-down" => "f149",
				"level-up" => "f148",
				"life-bouy" => "f1cd",
				"life-ring" => "f1cd",
				"life-saver" => "f1cd",
				"lightbulb-o" => "f0eb",
				"link" => "f0c1",
				"linkedin" => "f0e1",
				"linkedin-square" => "f08c",
				"linux" => "f17c",
				"list" => "f03a",
				"list-alt" => "f022",
				"list-ol" => "f0cb",
				"list-ul" => "f0ca",
				"location-arrow" => "f124",
				"lock" => "f023",
				"long-arrow-down" => "f175",
				"long-arrow-left" => "f177",
				"long-arrow-right" => "f178",
				"long-arrow-up" => "f176",
				"magic" => "f0d0",
				"magnet" => "f076",
				"mail-forward" => "f064",
				"mail-reply" => "f112",
				"mail-reply-all" => "f122",
				"male" => "f183",
				"map-marker" => "f041",
				"maxcdn" => "f136",
				"medkit" => "f0fa",
				"meh-o" => "f11a",
				"microphone" => "f130",
				"microphone-slash" => "f131",
				"minus" => "f068",
				"minus-circle" => "f056",
				"minus-square" => "f146",
				"minus-square-o" => "f147",
				"mobile" => "f10b",
				"mobile-phone" => "f10b",
				"money" => "f0d6",
				"moon-o" => "f186",
				"mortar-board" => "f19d",
				"music" => "f001",
				"navicon" => "f0c9",
				"openid" => "f19b",
				"outdent" => "f03b",
				"pagelines" => "f18c",
				"paper-plane" => "f1d8",
				"paper-plane-o" => "f1d9",
				"paperclip" => "f0c6",
				"paragraph" => "f1dd",
				"paste" => "f0ea",
				"pause" => "f04c",
				"paw" => "f1b0",
				"pencil" => "f040",
				"pencil-square" => "f14b",
				"pencil-square-o" => "f044",
				"phone" => "f095",
				"phone-square" => "f098",
				"photo" => "f03e",
				"picture-o" => "f03e",
				"pied-piper" => "f1a7",
				"pied-piper-alt" => "f1a8",
				"pied-piper-square" => "f1a7",
				"pinterest" => "f0d2",
				"pinterest-square" => "f0d3",
				"plane" => "f072",
				"play" => "f04b",
				"play-circle" => "f144",
				"play-circle-o" => "f01d",
				"plus" => "f067",
				"plus-circle" => "f055",
				"plus-square" => "f0fe",
				"plus-square-o" => "f196",
				"power-off" => "f011",
				"print" => "f02f",
				"puzzle-piece" => "f12e",
				"qq" => "f1d6",
				"qrcode" => "f029",
				"question" => "f128",
				"question-circle" => "f059",
				"quote-left" => "f10d",
				"quote-right" => "f10e",
				"ra" => "f1d0",
				"random" => "f074",
				"rebel" => "f1d0",
				"recycle" => "f1b8",
				"reddit" => "f1a1",
				"reddit-square" => "f1a2",
				"refresh" => "f021",
				"renren" => "f18b",
				"reorder" => "f0c9",
				"repeat" => "f01e",
				"reply" => "f112",
				"reply-all" => "f122",
				"retweet" => "f079",
				"rmb" => "f157",
				"road" => "f018",
				"rocket" => "f135",
				"rotate-left" => "f0e2",
				"rotate-right" => "f01e",
				"rouble" => "f158",
				"rss" => "f09e",
				"rss-square" => "f143",
				"rub" => "f158",
				"ruble" => "f158",
				"rupee" => "f156",
				"save" => "f0c7",
				"scissors" => "f0c4",
				"search" => "f002",
				"search-minus" => "f010",
				"search-plus" => "f00e",
				"send" => "f1d8",
				"send-o" => "f1d9",
				"share" => "f064",
				"share-alt" => "f1e0",
				"share-alt-square" => "f1e1",
				"share-square" => "f14d",
				"share-square-o" => "f045",
				"shield" => "f132",
				"shopping-cart" => "f07a",
				"sign-in" => "f090",
				"sign-out" => "f08b",
				"signal" => "f012",
				"sitemap" => "f0e8",
				"skype" => "f17e",
				"slack" => "f198",
				"sliders" => "f1de",
				"smile-o" => "f118",
				"sort" => "f0dc",
				"sort-alpha-asc" => "f15d",
				"sort-alpha-desc" => "f15e",
				"sort-amount-asc" => "f160",
				"sort-amount-desc" => "f161",
				"sort-asc" => "f0de",
				"sort-desc" => "f0dd",
				"sort-down" => "f0dd",
				"sort-numeric-asc" => "f162",
				"sort-numeric-desc" => "f163",
				"sort-up" => "f0de",
				"soundcloud" => "f1be",
				"space-shuttle" => "f197",
				"spinner" => "f110",
				"spoon" => "f1b1",
				"spotify" => "f1bc",
				"square" => "f0c8",
				"square-o" => "f096",
				"stack-exchange" => "f18d",
				"stack-overflow" => "f16c",
				"star" => "f005",
				"star-half" => "f089",
				"star-half-empty" => "f123",
				"star-half-full" => "f123",
				"star-half-o" => "f123",
				"star-o" => "f006",
				"steam" => "f1b6",
				"steam-square" => "f1b7",
				"step-backward" => "f048",
				"step-forward" => "f051",
				"stethoscope" => "f0f1",
				"stop" => "f04d",
				"strikethrough" => "f0cc",
				"stumbleupon" => "f1a4",
				"stumbleupon-circle" => "f1a3",
				"subscript" => "f12c",
				"suitcase" => "f0f2",
				"sun-o" => "f185",
				"superscript" => "f12b",
				"support" => "f1cd",
				"table" => "f0ce",
				"tablet" => "f10a",
				"tachometer" => "f0e4",
				"tag" => "f02b",
				"tags" => "f02c",
				"tasks" => "f0ae",
				"taxi" => "f1ba",
				"tencent-weibo" => "f1d5",
				"terminal" => "f120",
				"text-height" => "f034",
				"text-width" => "f035",
				"th" => "f00a",
				"th-large" => "f009",
				"th-list" => "f00b",
				"thumb-tack" => "f08d",
				"thumbs-down" => "f165",
				"thumbs-o-down" => "f088",
				"thumbs-o-up" => "f087",
				"thumbs-up" => "f164",
				"ticket" => "f145",
				"times" => "f00d",
				"times-circle" => "f057",
				"times-circle-o" => "f05c",
				"tint" => "f043",
				"toggle-down" => "f150",
				"toggle-left" => "f191",
				"toggle-right" => "f152",
				"toggle-up" => "f151",
				"trash-o" => "f014",
				"tree" => "f1bb",
				"trello" => "f181",
				"trophy" => "f091",
				"truck" => "f0d1",
				"try" => "f195",
				"tumblr" => "f173",
				"tumblr-square" => "f174",
				"turkish-lira" => "f195",
				"twitter" => "f099",
				"twitter-square" => "f081",
				"umbrella" => "f0e9",
				"underline" => "f0cd",
				"undo" => "f0e2",
				"university" => "f19c",
				"unlink" => "f127",
				"unlock" => "f09c",
				"unlock-alt" => "f13e",
				"unsorted" => "f0dc",
				"upload" => "f093",
				"usd" => "f155",
				"user" => "f007",
				"user-md" => "f0f0",
				"users" => "f0c0",
				"video-camera" => "f03d",
				"vimeo-square" => "f194",
				"vine" => "f1ca",
				"vk" => "f189",
				"volume-down" => "f027",
				"volume-off" => "f026",
				"volume-up" => "f028",
				"warning" => "f071",
				"wechat" => "f1d7",
				"weibo" => "f18a",
				"weixin" => "f1d7",
				"wheelchair" => "f193",
				"windows" => "f17a",
				"won" => "f159",
				"wordpress" => "f19a",
				"wrench" => "f0ad",
				"xing" => "f168",
				"xing-square" => "f169",
				"yahoo" => "f19e",
				"yen" => "f157",
				"youtube" => "f167",
				"youtube-play" => "f16a",
				"youtube-square" => "f166"
			);
			$previous = null;
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
		'the_nav_icons' =>	'',
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
				$crap = array( "?", "=", "/" );
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
		'the_nav_icons',
		__( 'Disable Nav Menu Icons', $theme_name ),
		'the_nav_icons_callback',
		'general_icon_settings',
		'general_icon_settings_section',
		array(
			__( 'Disable Font Awesome icons in the nav menu of your site.', $theme_name ),
		)
	);
	
	add_settings_field(	
		'cdn_fa',
		__( 'Use Local Icon Styles', $theme_name ),
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
		if ( !isset( $options['the_nav_icons'] ) || $options['the_nav_icons'] == 0 ) {
			$theme_obj = wp_get_theme();
			$theme_name = $theme_obj->get( 'Name' );
			if ( false == get_option( 'menu_icon_settings' ) ) {	
				add_option( 'menu_icon_settings', apply_filters( 'default_menu_icon_settings', default_menu_icon_settings() ) );
			}
			
			$nav_menus = get_registered_nav_menus();
			if ( $nav_menus ) {
				foreach ( $nav_menus as $menu => $name ) {
					$nav_menu_locations = get_nav_menu_locations();
					if ( $nav_menu_locations ) {
						$menu_id = $nav_menu_locations[ $menu ]; 
						$items = wp_get_nav_menu_items( $menu_id );
						if ( $items ) {
							  add_settings_section(
								  $menu . '_section',
								  __( $name, $theme_name ),
								  'menu_icon_settings_callback',
								  'menu_icon_settings'
							  );
							  foreach ( (array) $items as $key => $i ) {
								  if ( isset( $i->title ) && isset( $i->ID ) ) {
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

function the_nav_icons_callback( $args ) {
	$options = get_option('general_icon_settings');
	$html = '<input type="checkbox" id="the_nav_icons" name="general_icon_settings[the_nav_icons]" value="1" ' . checked( 1, isset( $options['the_nav_icons'] ) ? $options['the_nav_icons'] : 0, false ) . '/>'; 
	$html .= '<label for="the_nav_icons">&nbsp;'  . $args[0] . '</label>'; 
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
	if ( isset( $options[$id] ) && $options[$id] != "" ) {
		$option_val = stripslashes( $options[$id] );
		$showicon =  "&#x" . $options[$id];
		$removeicon = '<span class="' . esc_attr( $id ) . '-killIcns"><a href="#" title="Remove Icon" class="killIcns" data-kill-id="' . esc_attr( $id ) . '">' . __( 'Remove Icon', $theme_name ) . '</a>' . __( '&nbsp; ', $theme_name ) . '</span>';
	} else {
		$option_val = "";
		$showicon = "";
		$removeicon = "";
	}
	echo '<span class="add-inputfield"></span>';
	echo '<span class="add-inputfield-2"></span>';
	echo '<input class="' . esc_attr( $class ) . '" type="hidden" id="' . esc_attr( $id ) . '" name="' . esc_attr( $option_name ) . '[' . esc_attr( $id ) . ']" value="' . esc_attr( $option_val ) . '" />';
	echo '<span class="' . esc_attr( $id ) . '-icn"><i class="fa fa-fw">' . __( $showicon, $theme_name ) . '</i></span>&nbsp;<a href="#" data-reveal-id="myModal" data-hidden-id="' . esc_attr( $id ) . '">' . __( 'Select Icon', $theme_name ) . '</a>' . __( '&nbsp; ' . $removeicon, $theme_name ) . '<span class="' . esc_attr( $id ) . '-ajaxRemove"></span><span class="' . esc_attr( $id ) . '-saveMssg saveMssg"></span>';
}

/**
 * Nav Menu Icon Settings
 */
function menu_icon_settings_callback() {}

function menu_icons_callback( $args ) {
	$theme_obj = wp_get_theme();
	$theme_name = $theme_obj->get( 'Name' );
    extract( $args );
    $option_name = 'menu_icon_settings';
    $options = get_option( $option_name );
	if ( isset( $options[$id] ) && $options[$id] != "" ) {
		$option_val = stripslashes( $options[$id] );
		$showicon =  $options[$id];
		$removeicon = '<span class="' . esc_attr( $id ) . '-killIcns"><a href="#" title="Remove Icon" class="killIcns" data-kill-id="' . esc_attr( $id ) . '">' . __( 'Remove Icon', $theme_name ) . '</a>' . __( '&nbsp; ', $theme_name ) . '</span>';
	} else {
		$option_val = "";
		$showicon = "";
		$removeicon = "";
	}
	echo '<span class="add-inputfield"></span>';
	echo '<span class="add-inputfield-2"></span>';
	echo '<input class="' . esc_attr( $class ) . '" type="hidden" id="' . esc_attr( $id ) . '" name="' . esc_attr( $option_name ) . '[' . esc_attr( $id ) . ']" value="' . esc_attr( $option_val ) . '" />';
	echo '<span class="' . esc_attr( $id ) . '-icon"><i class="fa fa-' . $showicon . '"></i></span>&nbsp;<a href="#" data-reveal-id="myModal" data-hidden-id="' . esc_attr( $id ) . '">' . __( 'Select Icon', $theme_name ) . '</a>' . __( '&nbsp; ' . $removeicon, $theme_name ) . '<span class="' . esc_attr( $id ) . '-ajaxRemove"></span><span class="' . esc_attr( $id ) . '-saveMssg saveMssg"></span><br /><span class="description">' . esc_attr( $desc ) . '</span>';
}

function menu_icons_size_callback( $args ) {
	$theme_obj = wp_get_theme();
	$theme_name = $theme_obj->get( 'Name' );
    extract( $args );
    $options = get_option( 'menu_icon_settings' );
	if ( isset( $options[$id] ) && $options[$id] != "" ) {
		$options_val = stripslashes( $options[$id] );
		$options_val = esc_attr( $options[$id] );
	} else {
		$options_val = '';
	}
		$html = '<select id="' . esc_attr( $id ) . '" name="menu_icon_settings[' . esc_attr( $id ) . ']">';
		$html .= '<option value="default">' . __( 'Normal', $theme_name ) . '</option>';
		$html .= '<option value="fa-lg"' . selected( $options_val, 'fa-lg', false ) . '>' . __( 'Large', $theme_name ) . '</option>';
		$html .= '<option value="fa-2x"' . selected( $options_val, 'fa-2x', false ) . '>' . __( '2x', $theme_name ) . '</option>';
		$html .= '<option value="fa-3x"' . selected( $options_val, 'fa-3x', false ) . '>' . __( '3x', $theme_name ) . '</option>';	
		$html .= '<option value="fa-4x"' . selected( $options_val, 'fa-4x', false ) . '>' . __( '4x', $theme_name ) . '</option>';	
		$html .= '<option value="fa-5x"' . selected( $options_val, 'fa-5x', false ) . '>' . __( '5x', $theme_name ) . '</option>';	
		$html .= '</select>';
		$html .= '<br /><br /><hr />';
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
