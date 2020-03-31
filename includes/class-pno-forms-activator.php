<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Pno_Forms
 * @subpackage Pno_Forms/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Pno_Forms
 * @subpackage Pno_Forms/includes
 * @author     Your Name <email@example.com>
 */
class Pno_Forms_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$version         = (int) get_site_option( 'pno_forms' );
	
		if ( $version < 1 ) {
			$sql = "CREATE TABLE `{$wpdb->base_prefix}pno_forms_form_submissions` (
			submission_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			form_id bigint(20) UNSIGNED NOT NULL,
			created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			sent_to varchar(255),
			fields longtext,
			files longtext,
			PRIMARY KEY  (submission_id)
			) $charset_collate;";
	
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );
			$success = empty( $wpdb->last_error );
	
			update_site_option( 'pno_forms', 1 );

		}
	}

}
