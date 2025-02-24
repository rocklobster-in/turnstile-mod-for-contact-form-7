<?php
/*
 * Plugin Name: Turnstile integration module for Contact Form 7
 * Plugin URI: https://contactform7.com/
 * Description: This is the Cloudflare Turnstile integration module for Contact Form 7.
 * Author: Takayuki Miyoshi
 * Author URI: https://ideasilo.wordpress.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

add_action( 'plugins_loaded', function () {
	if (
		! defined( 'WPCF7_VERSION' ) or
		version_compare( WPCF7_VERSION, '6.1', '>=' )
	) {
		return;
  }

	$modules_dir = path_join( __DIR__, 'modules' );
	$module_file = path_join( $modules_dir, 'turnstile/turnstile.php' );

	if ( file_exists( $module_file ) ) {
		include_once $module_file;
	}
}, 11, 0 );
