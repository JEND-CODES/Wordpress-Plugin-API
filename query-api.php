<?php
/**
 * Plugin name: Query external APIs
 * Plugin URI: https://github.com/JEND-CODES/Wordpress-Plugin-API
 * Description: Plugin that includes data from external APIs
 * Author: Jean-Eudes Nouaille-Degorce
 * Author URI: http://portfolio.planetcode.fr/
 * version: 0.1.0
 */

defined( 'ABSPATH' ) or die( 'Unauthorized Access' );

function get_data_from_api($atts) {

	// Shortcode attributes
	$atts = shortcode_atts( array(
		'query' => 'photos theme',
		'count' => 'photos count'
	  ), $atts, 'external_data' );
	// Example : echo do_shortcode('[external_data count="6" query="mountain"]')
	// [external_data count="6" query="architecture"]

	$apiKey = '????';

    $url = "https://api.unsplash.com/photos/random?count=" . $atts['count'] . "&query=" . $atts['query'] . "&client_id=" . $apiKey;
    
    $arguments = array(
        'method' => 'GET'
    );

	// https://developer.wordpress.org/reference/functions/wp_remote_get/
	// Performs an HTTP request using the GET method and returns its response
	$response = wp_remote_get( $url, $arguments );

	if ( is_wp_error( $response ) ) {
		$error_message = $response->get_error_message();
		return "Error: $error_message";
	} 
	
	$results = json_decode( wp_remote_retrieve_body( $response ) );

	// var_dump($results);

	foreach( $results as $result ) {
		echo '<img src=' . $result->urls->small . '/>';
	}

}

add_shortcode('external_data', 'get_data_from_api');