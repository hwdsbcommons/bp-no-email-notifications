<?php
/**
 * BP No Notifications Core
 *
 * @package BP_No_Notifications
 * @subpackage Core
 */

 // Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Core class for BP No Notifications
 *
 * @package BP_No_Notifications
 * @subpackage Classes
 */
class BP_No_Notifications {

	/**
	 * Static init method.
	 *
	 * @return BP_No_Notifications object
	 */
	public static function init() {
		return new self();
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'get_user_metadata', array( $this, 'notification_setting' ), 10, 4 );
	}

	/**
	 * Filter user meta to check for notification settings.
	 *
	 * If notification setting is not explicitly set, set no notification to be sent.
	 */
	public function notification_setting( $retval, $user_id, $meta_key, $single ) {
		// not a BP notification, stop now!
		// there is a slim chance that this might conflict with other non-BP plugins...
		if ( strpos( $meta_key, 'notification_' ) === false ) {
			return $retval;
		}

		if ( ! $meta_key )
			return $retval;

		$meta_cache = wp_cache_get( $user_id, 'user_meta' );

		if ( ! $meta_cache ) {
			$meta_cache = update_meta_cache( 'user', array( $user_id ) );
			$meta_cache = $meta_cache[$user_id];
		}

		if ( isset( $meta_cache[$meta_key] ) ) {
			if ( $single ) {
				$retval = maybe_unserialize( $meta_cache[$meta_key][0] );
			} else {
				$retval = array_map( 'maybe_unserialize', $meta_cache[$meta_key] );
			}

			if ( empty( $retval ) ) {
				$retval = null;
			}

		}

		if ( null === $retval ) {
			return 'no';
		}

		return $retval;

	}

}

// Wind it up!
add_action( 'bp_init', array( 'BP_No_Notifications', 'init' ) );