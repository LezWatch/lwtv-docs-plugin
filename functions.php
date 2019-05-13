<?php
/**
 * Plugin Name: Core LezWatch.TV Docs Plugin
 * Plugin URI:  https://docs.lezwatchtv.com
 * Description: All the base code for LezWatch.TV Docs - If this isn't active, the site dies. An ugly death.
 * Version: 1.0
 * Author: LezWatch.TV
 *
 * @package LWTV_DOCS_PLUGIN
*/

/*
 * Require the library code
 */
if ( file_exists( WP_CONTENT_DIR . '/library/functions.php' ) ) {
	require_once WP_CONTENT_DIR . '/library/functions.php';
	define( 'LWTV_LIBRARY', true );
}

/**
 * class LWTV_Functions
 *
 * The background functions for the site, independant of the theme.
 */
class LWTV_Docs_Functions {

	protected static $version;

	/**
	 * Constructor.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		self::$version = '1.0';
		add_filter( 'http_request_args', array( $this, 'disable_wp_update' ), 10, 2 );
		add_action( 'pre_current_active_plugins', array( $this, 'hide_lwtv_plugin' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
		add_action( 'wp_footer', array( $this, 'gdpr_footer' ), 5 );
	}

	/**
	 * Hide the LWTV Plugin.
	 *
	 * @access public
	 * @return void
	 */
	public function hide_lwtv_plugin() {
		global $wp_list_table;

		$hide_plugins = array(
			plugin_basename( __FILE__ ),
		);
		$curr_plugins = $wp_list_table->items;
		foreach ( $curr_plugins as $plugin => $data ) {
			if ( in_array( $plugin, $hide_plugins, true ) ) {
				unset( $wp_list_table->items[ $plugin ] );
			}
		}
	}

	/**
	 * Disable WP from updating this plugin..
	 *
	 * @access public
	 * @param mixed $return - array to return.
	 * @param mixed $url    - URL from which checks come and need to be blocked (i.e. wp.org)
	 * @return array        - $return
	 */
	public function disable_wp_update( $return, $url ) {
		if ( 0 === strpos( $url, 'https://api.wordpress.org/plugins/update-check/' ) ) {
			$my_plugin = plugin_basename( __FILE__ );
			$plugins   = json_decode( $return['body']['plugins'], true );
			unset( $plugins['plugins'][ $my_plugin ] );
			unset( $plugins['active'][ array_search( $my_plugin, $plugins['active'], true ) ] );
			$return['body']['plugins'] = wp_json_encode( $plugins );
		}
		return $return;
	}

	/**
	 * Enqueue Scripts
	 */
	public function wp_enqueue_scripts() {
		wp_enqueue_style( 'lwtvdocs-gdpr', plugins_url( '/inc/gdpr.css', __FILE__ ), '', self::$version, 'all' );
		wp_enqueue_script( 'lwtvdocs-gdpr', plugins_url( '/inc/gdpr.js', __FILE__ ), array( 'bootstrap' ), self::$version, 'all', true );

	}

	/**
	 * Echo GDPR notice if users aren't logged in
	 * (logged in users alredy know what they're in for, yo)
	 */
	public function gdpr_footer() {
		if ( ! is_user_logged_in() ) {
			?>
			<div id="GDPRAlert" class="alert alert-info alert-dismissible fade collapse alert-gdpr" role="alert">
				We use cookies to personalize content, provide features, analyze traffic, and optimize advertising. By continuing to use this website, you agree to their use. For more information, you may review our <a href="/terms-of-use/">Terms of Use</a> and <a href="/terms-of-use/privacy/">Privacy Policy</a>.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<?php
		}
	}

}
new LWTV_Docs_Functions();

/*
 * Add-Ons.
 */
require_once 'cpts/_main.php';
