<?php
/*
Plugin Name: BP No Notifications
Description: Only send notifications if the user has explicitly enabled them.
Author: r-a-y
Author URI: http://profiles.wordpress.org/r-a-y
Version: 0.1
*/

/**
 * BP No Notifications
 *
 * @package BP_No_Notifications
 * @subpackage Loader
 */
 
 // Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Loads the plugin only if BuddyPress is activated
 */
function bp_no_notifications_init() {
	require( dirname( __FILE__ ) . '/bp-no-notifications.php' );
}
add_action( 'bp_include', 'bp_no_notifications_init' );
