<?php
/**
 * ChurchPress Genesis Starter.
 *
 * This file adds functions to the ChurchPress Genesis Starter Theme.
 *
 * @package ChurchPress Genesis Starter
 * @author  ChurchPress
 * @license GPL-3.0+
 * @link    https://ChurchPress.co
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( 'cp-genesis-starter', get_stylesheet_directory() . '/languages' );

}

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'nls-se' );
define( 'CHILD_THEME_URL', '' );
define( 'CHILD_THEME_VERSION', '' );

add_action( 'init', 'cp_includes' );
/**
 * Load additional functions and helpers (/includes/*)
 */
function cp_includes() {
	$includes_dir = get_stylesheet_directory() . '/lib';

	//* Load required theme files in the includes directory.
	foreach ( glob( $includes_dir . '/*.php' ) as $file ) {
		require_once $file;
	}

	//* Load required files in subdirectories of the includes directory.
	foreach ( glob( $includes_dir . '/*/*.php' ) as $file ) {
		require_once $file;
	}

}

/**
 * Defines responsive menu settings.
 *
 * @since 2.3.0
 */
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'cp-genesis-starter' ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Submenu', 'cp-genesis-starter' ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Sets the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 702; // Pixels.
}

// Adds support for HTML5 markup structure.
add_theme_support(
	'html5', array(
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
	)
);

// Adds support for accessibility.
add_theme_support(
	'genesis-accessibility', array(
		'404-page',
		'drop-down-menu',
		'headings',
		'rems',
		'search-form',
		'skip-links',
	)
);

// Adds viewport meta tag for mobile browsers.
add_theme_support(
	'genesis-responsive-viewport'
);

// Adds custom logo in Customizer > Site Identity.
add_theme_support(
	'custom-logo', array(
		'height'      => 120,
		'width'       => 700,
		'flex-height' => true,
		'flex-width'  => true,
	)
);

// Renames primary and secondary navigation menus.
add_theme_support(
	'genesis-menus', array(
		'primary'   => __( 'Header Menu', 'cp-genesis-starter' ),
		'secondary' => __( 'Footer Menu', 'cp-genesis-starter' ),
	)
);

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Removes output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

add_action( 'genesis_theme_settings_metaboxes', 'genesis_sample_remove_metaboxes' );
/**
 * Removes output of unused admin settings metaboxes.
 *
 * @since 2.6.0
 *
 * @param string $_genesis_admin_settings The admin screen to remove meta boxes from.
 */
function genesis_sample_remove_metaboxes( $_genesis_admin_settings ) {

	remove_meta_box( 'genesis-theme-settings-header', $_genesis_admin_settings, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_admin_settings, 'main' );

}

add_filter( 'genesis_customizer_theme_settings_config', 'genesis_sample_remove_customizer_settings' );
/**
 * Removes output of header settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function genesis_sample_remove_customizer_settings( $config ) {

	unset( $config['genesis']['sections']['genesis_header'] );
	return $config;

}

// Displays custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

// Remove emoji styles
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' ); 
remove_action( 'wp_print_styles', 'print_emoji_styles' ); 
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Remove the edit link
add_filter ( 'genesis_edit_post_link' , '__return_false' );

// Remove entry header on all pages
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// Use h1 for site title
add_filter( 'genesis_site_title_wrap', 'ea_h1_for_site_title' );
 function ea_h1_for_site_title( $wrap ) {
	return 'h1';
}

// Filter Genesis H1 Post Titles 
add_filter( 'genesis_post_title_output', 'bn_post_title_output', 15 );
function bn_post_title_output( $title ) {

    $title = sprintf( '<h2 class="entry-title">%s</h2>', apply_filters( 'genesis_post_title_text', get_the_title() ) );
    return $title;

}

//* Add no-js class body tag
add_filter( 'genesis_attr_body', 'themeprefix_add_css_attr' );
function themeprefix_add_css_attr( $attributes ) {
 
 // add original plus extra CSS classes
 $attributes['class'] .= ' no-js';
 
 // return the attributes
 return $attributes;
 
}

// Remove type tag from script and style
/* Doesn't seem to work...
add_filter('style_loader_tag', 'codeless_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'codeless_remove_type_attr', 10, 2);
add_filter('autoptimize_html_after_minify', 'codeless_remove_type_attr', 10, 2);
function codeless_remove_type_attr($tag, $handle='') {
    return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
}
*/

// Change the footer copyright etc text

add_filter( 'genesis_footer_creds_text', 'wpb_footer_creds_text' );
function wpb_footer_creds_text () {
	$copyright = '';
    return $copyright;
}


add_filter('genesis_footer', 'designed_by', 10);
function designed_by() {
	echo '<p style="clear:left; margin:20px 0 0 18px; padding-top: 20px;">' . do_shortcode('[footer_copyright]') . ' National Library of Scotland</p>';
}

// Footer logo
add_action('genesis_footer', 'footer_logo', 9 );
function footer_logo(){

		echo '<a class="site-footer__logo-lnk" href="https://www.nls.uk/" target="_blank"><img class="site-footer__logo" src="' . home_url() . '/wp-content/themes/nls-se/assets/images/nls_logo.png" alt="National Library of Scotland logo"></a>';
}

// Homepage output - Hero image
add_action('genesis_after_header', 'home_page_before', 10 );
function home_page_before(){
	if ( is_page_template('home-page.php') ) {

			echo '<div class="landing-banner" tabindex="0"><figure class="landing-banner__img" itemscope="" itemtype="http://schema.org/ImageObject"><img src="' . types_render_field( 'home-banner-image', array('url' => 'true') ) . '" alt="' . types_render_field( 'home-image-alt-text', array() ) . '" itemprop="contentUrl" class="landing-banner__img__item">';
		//		echo'<figcaption class="landing-banner__caption" itemprop="description">' . types_render_field( 'home-image-alt-text', array() ) . '</figcaption>';
			echo'</figure>';
		// 		echo'<button class="landing-banner__toggle-decript closed" id="landing-banner__toggle-decript">View image description</button>';
			echo'</div>';
	}
}

// Homepage output - content
add_action('genesis_entry_content', 'home_page_10', 10 );
function home_page_10(){
	if ( is_page_template('home-page.php') ) {

			echo '<div class="home-copy">' . types_render_field( 'home-main-copy', array() ) . '</div>';
			echo '<div class="home-audio-intro"><figure class="home-audio-intro__audio"><audio controls class="home-audio-intro__player"><source src="' . types_render_field( 'home-audio-track', array('raw' => 'true') ) . '" type="audio/mpeg"></audio><figcaption class="home-audio-intro__caption">' . types_render_field( 'home-overview', array() ) . '<a target="_blank" class="view-btn view-btn--1" href="'. home_url() . '/wp-content/uploads/transcription-of-audio.pdf">Read Transcript (opens in new tab or window)</a></figcaption></figure></div>';
			
		
	}
}

// Key People Landing List output
/*
add_action('genesis_entry_content', 'key_landing_page_11', 11 );
function key_landing_page_11(){
	if ( is_page_template('key-people-landing.php') ) {

		echo do_shortcode('[wpv-view name="key-people-list"]');
		
	}
}
*/
// Encyclopedia Brit Landing LIST output
add_action('genesis_entry_content', 'encyclo_landing_page_11', 11 );
function encyclo_landing_page_11(){
	if ( is_page_template('encyclopaedia.php') ) {

			echo do_shortcode('[wpv-view name="encyclodpaedia-source-list"]');
		
	}
}

// Town Planning Landing LIST output
add_action('genesis_entry_content', 'town_planning_landing_page_11', 11 );
function town_planning_landing_page_11(){
	if ( is_page_template('town-planning.php') ) {

			echo do_shortcode('[wpv-view name="town-planning-source-list"]');
		
	}
}
// Scotticisms Landing LIST output
add_action('genesis_entry_content', 'scotticisms_landing_page_11', 11 );
function scotticisms_landing_page_11(){
	if ( is_page_template('scotticisms.php') ) {

			echo do_shortcode('[wpv-view name="scotticisms-source-list"]');
		
	}
}

// Stats Account Landing LIST output
add_action('genesis_entry_content', 'stats_landing_page_11', 11 );
function stats_landing_page_11(){
	if ( is_page_template('staticistical-account.php') ) {

			echo do_shortcode('[wpv-view name="stat-account-source-list"]');
		
	}
}

// Ossian Landing LIST output
add_action('genesis_entry_content', 'ossian_landing_page_11', 11 );
function ossian_landing_page_11(){
	if ( is_page_template('ossian.php') ) {

			echo do_shortcode('[wpv-view name="ossian-source-list"]');
		
	}
}

// Clubs and Societies Landing LIST output
add_action('genesis_entry_content', 'clubs_landing_page_11', 11 );
function clubs_landing_page_11(){
	if ( is_page_template('clubs-and-societies.php') ) {

			echo do_shortcode('[wpv-view name="clubs-societies-source-list"]');
		
	}
}

// -------------------------------- Landing pages MAIN COPY output ----------------------------------
add_action('genesis_entry_content', 'landing_pages_10', 10 );
function landing_pages_10(){
	if ( is_page_template('encyclopaedia.php') || is_page_template('town-planning.php') || is_page_template('scotticisms.php') || is_page_template('staticistical-account.php') || is_page_template('ossian.php') || is_page_template('clubs-and-societies.php') ) {
			
			echo '<div class="landing-banner" tabindex="0"><figure class="landing-banner__img" itemscope itemtype="http://schema.org/ImageObject"><img src="' . types_render_field( 'top-level-image', array("output" => "raw") ) . '" alt="' . types_render_field( 'top-level-image-caption', array("output" => "raw") ) . '" itemprop="contentUrl" class="landing-banner__img__item"><figcaption class="landing-banner__caption" itemprop="description">' . types_render_field( 'top-level-image-caption', array("output" => "raw") ) . ' <span class="landing-banner__caption__shelfmark">' . types_render_field( 'nls-shelfmark', array() ) . '</span></figcaption></figure><button class="landing-banner__toggle-decript closed" id="landing-banner__toggle-decript">View image description</button></div>';
			//echo '<div>' . types_render_field( 'top-level-image-caption', array() ) . '</div>';
			echo '<div class="landing-copy">' . types_render_field( 'top-level-main-copy', array() ) . '</div>';
	}
}

// Key People Landing Copy output
add_action('genesis_entry_content', 'key_landing_page_11', 11 );
function key_landing_page_11(){
	if ( is_page_template('key-people-landing.php') ) {

			echo types_render_field( 'key-people-landing2-copy', array() );
		
	}
}


/*--------------------------- Single Source - source list --------------------------------*/

// Encyclopedia Brit - Output Source list in single post
add_action('genesis_after_content', 'encyclo_source_11', 10 );
function encyclo_source_11(){
	if ( in_category( '2' )  ) {

		echo do_shortcode('[wpv-view name="encyclodpaedia-source-list"]');
	}
}

// Town Planning - Output Source list in single post
add_action('genesis_after_content', 'town_planning_source_11', 10 );
function town_planning_source_11(){
	if ( in_category( '1' )  ) {

		echo do_shortcode('[wpv-view name="town-planning-source-list"]');
	}
}

// Scotticisms - Output Source list in single post
add_action('genesis_after_content', 'scotticisms_source_11', 10 );
function scotticisms_source_11(){
	if ( in_category( '3' )  ) {

		echo do_shortcode('[wpv-view name="scotticisms-source-list"]');
	}
}

// Stats Account - Output Source list in single post
add_action('genesis_after_content', 'stats_account_source_11', 10 );
function stats_account_source_11(){
	if ( in_category( '4' )  ) {

		echo do_shortcode('[wpv-view name="stat-account-source-list"]');
	}
}

// Ossian - Output Source list in single post
add_action('genesis_after_content', 'ossian_source_11', 10 );
function ossian_source_11(){
	if ( in_category( '5' )  ) {

		echo do_shortcode('[wpv-view name="ossian-source-list"]');
	}
}

// Clubs and Societies - Output Source list in single post
add_action('genesis_after_content', 'clubs_societies_source_11', 10 );
function clubs_societies_source_11(){
	if ( in_category( '6' )  ) {

		echo do_shortcode('[wpv-view name="clubs-societies-source-list"]');
	}
}

// Gallery page output
add_action('genesis_entry_content', 'gallery_view', 10 );
function gallery_view(){
	if ( is_page_template('gallery-page.php') ) {

			echo do_shortcode('[wpv-view name="gallery2"]');
		
	}
}

// Clubs and Societies - Output Source title
add_action('genesis_entry_content', 'clubs_societies_source_9', 9 );
function clubs_societies_source_9(){
	if ( in_category( '6' )  ) {

		//echo '<div class="source-content"><h2 class="source-entry-header">Clubs and Societies</h2>';
	}
}

// Add entry (page) title to Key People landing
add_action('genesis_before_content_sidebar_wrap', 'key_people_title', 11 );
function key_people_title(){
	if ( is_post_type_archive( 'key-people2' )  ) {

			echo '<div class="key-people-page-header"><h2 class="mt1">Key People</h2>
			<div class="key-people-interactive-cta"><ul class="source-list source-list--key-people">
        	<li class="source-list__item"><a class="source-list__lnk source-list__lnk--interactive" itemprop="url" href="#interactive-no-js"><dl class="source-list__definition source-list__definition"><dt class="source-list__definition__title" itemprop="name">Interactive</dt><dd class="source-list__definition__description source-list__definition__description--key-people" itemprop="description">Explore the Enlightenment Connections</dd></dl></a></li></ul><noscript><div id="interactive-no-js" class="interactive-no-js"><p>This feature requires JavaScript to be enabled.</p></div></noscript></div><div style="clear:both;"></div></div>';
		
	}
}

// Add entry (page) title to Gallery
add_action('genesis_before_content_sidebar_wrap', 'gallery_title', 11 );
function gallery_title(){
	if ( is_post_type_archive( 'gallery-item' )  ) {

			echo '<h2 class="gallery-page-header">Gallery</h2>';
		
	}
}

// Configure thumbnails
set_post_thumbnail_size( 520, 572, array( 'center', 'top')  ); // 520 pixels wide by 572 pixels tall, crop from the top center

// 

add_action('genesis_after_footer', 'child_script_managment');
function child_script_managment() {
		wp_enqueue_style( 'slider', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css',false,'1.1','all');

    	wp_enqueue_script( 'script', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js', array ( 'jquery' ), 1.1, true);

}


// Resources landing page output
add_action('genesis_entry_content', 'resources_landing_10', 10 );
function resources_landing_10(){
	if ( is_page_template('resources-page.php') ) {

			echo '<div class="resources-copy">' . types_render_field( 'resources-main-copy', array() ) . '</div>';
			echo '<aside class="source-list-container">
					<nav itemscope="" itemtype="https://schema.org/SiteNavigationElement">
      					<ul class="source-list">
       						<li class="source-list__item"><a class="source-list__lnk source-list__lnk--interactive source-list__lnk--gallery" itemprop="url" href="https://asmith-dev2.net/scottish-enlightenment/gallery/"><dl class="source-list__definition source-list__definition"><dt class="source-list__definition__title" itemprop="name">Gallery</dt><dd class="source-list__definition__description" itemprop="description"></dd></dl></a></li>
  							<li class="source-list__item"><a target="_blank" class="source-list__lnk" itemprop="url" href="' . types_render_field( 'resource-1', array('url' => 'true') ) . '"><dl class="source-list__definition"><dt class="source-list__definition__title" itemprop="name">Activity</dt><dd class="source-list__definition__description" itemprop="description">The Scottish Enlightenment <br>(PDF opens in new tab or window)</dd></dl></a></li>
  							<li class="source-list__item"><a target="_blank" class="source-list__lnk" itemprop="url" href="' . types_render_field( 'resource-2', array('output' => 'raw') ) . '"><dl class="source-list__definition"><dt class="source-list__definition__title" itemprop="name">Activity</dt><dd class="source-list__definition__description" itemprop="description">Scotticisms <br>(PDF opens in new tab or window)</dd></dl></a></li>
      					</ul>
					</nav>
				</aside>';		
	}
}

// Interactive map output
add_action('genesis_entry_content', 'interactive_map', 11 );
function interactive_map(){
	if ( is_single( array( 72, 50, 164, 166, 168, 170, 172 ) ) || is_page( '51') ) {

			echo '<div class="interactive-modal" id="interactive-modal"><div class="interactive-modal__inner"><a href="#" class="interactive-modal__close" id="interactive-modal__close">Close</a><iframe src="https://northern-lights.dev2.grizzleandtan.co.uk/map" frameborder="0" allowfullscreen style="width:100%; height: 100%; border:0;"></iframe></div></div>';
	}
}

// Interactive key people output
add_action('genesis_after_content_sidebar_wrap', 'interactive_map2', 11 );
function interactive_map2(){
	if ( is_post_type_archive( 'key-people2' ) ) {

			echo '<div class="interactive-modal" id="interactive-modal"><div class="interactive-modal__inner"><a href="#" class="interactive-modal__close" id="interactive-modal__close">Close</a>
				<iframe src="https://northern-lights.dev2.grizzleandtan.co.uk/influencers" frameborder="0" allowfullscreen style="width:100%; height: 100%; border:0;"></iframe></div></div>';		
	}
}

