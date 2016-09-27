<?php
/**
 * Plugin Name: The Events Calendar Extension: Show Past Events in Reverse Chronological Order
 * Description: Flips the order of past events so that the most recent past events are at the top of list views.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1x
 * License: GPLv2 or later
 */
 
defined( 'WPINC' ) or die;

class Tribe__Extension__Show_Past_Events_in_Reverse_Chronological_Order {

    /**
     * The semantic version number of this extension; should always match the plugin header.
     */
    const VERSION = '1.0.0';

    /**
     * Each plugin required by this extension
     *
     * @var array Plugins are listed in 'main class' => 'minimum version #' format
     */
    public $plugins_required = array(
        'Tribe__Events__Main' => '4.2'
    );

    /**
     * The constructor; delays initializing the extension until all other plugins are loaded.
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
    }

    /**
     * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
     */
    public function init() {

        // Exit early if our framework is saying this extension should not run.
        if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
            return;
        }

        add_filter( 'the_posts', array( $this, 'past_reverse_chronological' ), 100 );
    }

    /**
     * Flips the order of past events so that the most recent past events are at the top of list views.
     *
     * @param object $post_object
     * @return object
     */
    public function past_reverse_chronological( $post_object ) {

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
}

new Tribe__Extension__Show_Past_Events_in_Reverse_Chronological_Order();
