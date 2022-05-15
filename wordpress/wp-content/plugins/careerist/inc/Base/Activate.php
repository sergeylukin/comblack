<?php
/**
 * @package  CareeristPlugin
 */
namespace Inc\Base;
use DB;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();

		$default = array();

		if ( ! get_option( 'careerist_plugin' ) ) {
			update_option( 'careerist_plugin', $default );
		}

		if ( ! get_option( 'careerist_plugin_cpt' ) ) {
			update_option( 'careerist_plugin_cpt', $default );
		}


		global $wpdb;
		$plugin_name_db_version = '1.0';
		$table_name = $wpdb->prefix . "plugin_name_customers"; 
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			created timestamp NOT NULL default CURRENT_TIMESTAMP,
			name tinytext NULL,
			custom_field varchar(255) DEFAULT '' NOT NULL,
			email varchar(255) DEFAULT '' NOT NULL,
			UNIQUE KEY id (id)
) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option( 'plugin_name_db_version', $plugin_name_db_version );
	}
}
