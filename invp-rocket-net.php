<?php
/**
 * Plugin Name: Inventory Presser - Rocket.net CDN
 * Plugin URI: https://inventorypresser.com
 * Description: Purges Rocket.net CDN cache when vehicles are updated via the WordPress REST API
 * Author: Corey Salzano
 * Author URI: https://github.com/csalzano
 * Version: 1.0.3
 *
 * @package invp-rocket-net
 */

defined( 'ABSPATH' ) || exit;

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

	if ( ! defined( 'CDN_SITE_ID' ) ) {
		// Something's not right.
		return;
	}

	$blog_domain = wp_parse_url( site_url(), PHP_URL_HOST );
	$endpoint    = sprintf(
		'https://api.rocket.net/v1/sites/%d/cache/purge_everything?domain=%s',
		CDN_SITE_ID,
		$blog_domain
	);

	// Send an API request to api.rocket.net.
	$args     = array(
		'headers' => array(
			'Authorization' => 'Bearer ' . $token,
			'Content-Type'  => 'application/json',
		),
	);
	$response = wp_remote_post( $endpoint, $args );
	if ( is_wp_error( $response ) ) {
		error_log( '[invp-rocket-net][' . $blog_domain . '] ' . $response->get_error_message() );
	}
}
