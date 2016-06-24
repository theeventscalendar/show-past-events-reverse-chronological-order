<?php
/**
 * Plugin Name: The Events Calendar — Show Past Events in Reverse Chronological Order
 * Description: Flips the order of past events so that the most recent past events are at the top of list views.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1x
 * License: GPLv2 or later
 */
 
defined( 'WPINC' ) or die;

function tribe_past_reverse_chronological( $post_object ) {

	if ( ! is_array( $post_object ) || empty( $post_object ) ) {
		return $post_object;
	}
	
	$past_ajax = false;

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX && $_REQUEST['tribe_event_display'] === 'past' ) {
		$past_ajax = true;
	}

	if ( tribe_is_past() || $past_ajax ) {
		$post_object = array_reverse( $post_object );
	}
	
	return $post_object;
}

add_filter( 'the_posts', 'tribe_past_reverse_chronological', 100 );
