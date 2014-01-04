<?php
/**
 * Creates a settings page for admin icons under "Settings"
 */
 
if ( !defined('ABSPATH') ) { die('-1'); }

add_action('admin_menu', 'add_icons_page');
add_action( 'admin_init', 'register_icon_settings' );

function add_icons_page() {
	add_theme_page( 'Icons', 'Icons', 'manage_options', 'icon-settings.php', 'icon_admin_settings_page' ); 
}

/**
 * Add scripts and styles for the modal window
 */
function icon_page_scripts_n_styles() {
	$screen = get_current_screen(); 
	if ( $screen->id == 'appearance_page_icon-settings' ) {
		wp_register_script( 'reveal_js', plugins_url( 'scripts/jquery.reveal.js', __FILE__ ), array( 'jquery' ), false, '1.0' );
		wp_enqueue_script('reveal_js');
		wp_register_style( 'reveal_css', plugins_url( 'scripts/reveal.css', __FILE__ ), false, '1.0' );
		wp_enqueue_style('reveal_css');
	}
	else { 
		return;
	}
}
add_action('admin_enqueue_scripts', 'icon_page_scripts_n_styles');

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
        <p>Thank you, <a href="https://twitter.com/davegandy" target="_blank">Dave Gandy</a>, for creating and maintaining <a href="http://fontawesome.io/" target="_blank">Font Awesome</a>.</p>
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
	if ( $menu ) {
		foreach ( $menu as $m ) {
			if ( isset( $m[5] ) ) {
				$crap = array( "?", "=" );
				$the_id = str_replace( $crap, "-", $m[5] );
				if ( isset( $m[0] ) && $m[0] != '' ) {
					$title = preg_replace( '/\d/', '', $m[0] ); // removes the count from some menu titles
					$field_args = array(
						'type'      =>  'links',
						'id'        =>  $the_id.'_icon',
						'name'      =>  $the_id.'_icon',
						'desc'      =>  '',
						'std'       =>  '',
						'label_for' =>  $title,
						'class'     =>  'linker'
					);
					add_settings_field( $the_id, $title, 'build_icon_settings', 'icon-settings.php', 'admin_menu_section', $field_args );
				}
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
Replace icons in your admin menu &mdash; Click "Select Icon" for the menu item you'd like to change, then choose a Font Awesome icon. Save your settings and the icons will change like magic!</p>
<div id='myModal' class='reveal-modal xlarge'>
	<h2>Select an Icon</h2>
	<p>
    <?php
	// array of all Font Awesome icons
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
			echo "<h2 id='letterz'>" . $firstLetter . "</h2>";
		}
		$previous = $firstLetter;
		// create radio button for each icon
		echo "<div id ='iconz'>";
		echo "<a href='#' class='close-reveal-modal' data-icn-val='" . $val . "'> <i class='fa fa-fw'>&#x" . $val . "</i><span style='padding-left: 5px'><em>" . $key . "</em></a>";
		echo "</div>";
	} 
	?>
	</p>
	<a class='close-reveal-modal close-butz'><i class='fa fa-fw'>&#xf057</i></a>
</div>
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
		case 'links':
			$options[$id] = stripslashes( $options[$id] );
			$options[$id] = esc_attr( $options[$id] );
			if ( isset( $options[$id] ) && $options[$id] != '' ) {
				$showicon =  "&#x" . $options[$id];
				$removeicon = "<span class='$id-killIcns'><a href='#' title='Remove Icon' class='killIcns' data-kill-id='$id'>Remove Icon</a>&nbsp; </span>";
			} else {
				$showicon = "";
				$removeicon = "";
			}
			echo "<span class='add-inputfield'></span>";
			echo "<span class='add-inputfield-2'></span>";
			echo "<input class='$class' type='hidden' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";
			echo "<span class='$id-icn'><i class='fa fa-fw'>" . $showicon . "</i></span>&nbsp;<a href='#' data-reveal-id='myModal' data-hidden-id='$id'>Select Icon</a>&nbsp; " . $removeicon . "<span class='$id-ajaxRemove'></span><span class='$id-saveMssg saveMssg'></span>";
		break;  
    }
}

/**
 * Validate the input.
 */
function validate_icon_settings( $input ) {
	foreach( $input as $k => $v ) {
		if ( !preg_match('/^[f]{1}+[0-9]{1}+[A-z0-9]{2}$/', $v ) ) { // match FA unicode
			$newinput[$k] = ''; // Unicode Nazi says "No save for you!"
		} else {
			$newinput[$k] = sanitize_text_field( $v ); // Unicode Nazi lets you save, but glares at you.
		}
	}
	return $newinput;
}
