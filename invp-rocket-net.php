<?php
defined( 'ABSPATH' ) || exit;

/**
 * Plugin Name: Inventory Presser - Rocket.net CDN
 * Plugin URI: https://inventorypresser.com
 * Description: Purges Rocket.net CDN cache when vehicles are updated via the WordPress REST API
 * Author: Corey Salzano
 * Author URI: https://github.com/csalzano
 */

add_action( 'invp_feed_complete', 'invp_rocket_purge' );
/**
 * Purges the Rocket.net CDN cache after an inventory update.
 *
 * @return void
 */
function invp_rocket_purge() {
	// Do we even have a Rocket.net API token?
	$token = get_option( 'invp_api_rocket_net_token' );
	if ( empty( $token ) ) {
		// No. Abort.
		return;
	}
	// Which install this site is on?
	$home_url       = get_home_url();
	$primary_domain = wp_parse_url( $home_url, PHP_URL_HOST ); // Should be fm01.friday.systems not chrisgoodnowautosales.com.
	$install_label  = explode( '.', $primary_domain )[0] ?? '';
	if ( empty( $install_label ) ) {
		error_log( '[invp-rocket-net] Failed to purge Rocket.net CDN during invp_feed_complete action hook.' );
		return;
	}
	$site_id = 19367; // 19367 = fm01.
	if ( 'fm02' === $install_label ) {
		$site_id = 51224; // 51224 = fm02.
	}
	$endpoint = sprintf(
		'https://api.rocket.net/v1/sites/%d/cache/purge_everything',
		$site_id
	);

	// Send an API request to api.rocket.net.
	$blog_domain = wp_parse_url( site_url(), PHP_URL_HOST );
	$args        = array(
		'headers' => array(
			'Authorization' => 'Bearer ' . $token,
			'Content-Type'  => 'application/json',
		),
		'body'    => wp_json_encode(
			array(
				'domain' => $blog_domain,
			)
		),
	);
	$response    = wp_remote_post( $endpoint, $args );
	if ( is_wp_error( $response ) ) {
		error_log( '[invp-rocket-net][' . $blog_domain . '] ' . $response->get_error_message() );
	}
}
