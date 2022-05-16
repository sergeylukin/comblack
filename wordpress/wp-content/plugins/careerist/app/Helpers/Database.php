<?php namespace Careerist\Helpers;

/**
 * @package  CareeristPlugin
 */

class Database {

  /**
   * The Wordpress DB object instance
   *
   */
  protected $wpdb;

	
	public function __construct($wpdb) {
		$this->wpdb = $wpdb;
	}
	
	/**
	*
	* Like the constructor, we make __clone private
	* so nobody can clone the instance
	*
	*/
	private function __clone()
	{
	}

	public function create_settings() {
		$default = array();

		if ( ! get_option( 'careerist_plugin' ) ) {
			update_option( 'careerist_plugin', $default );
		}

		if ( ! get_option( 'careerist_plugin_cpt_settings' ) ) {
			update_option( 'careerist_plugin_cpt_settings', $default );
		}

		return $this;
	}

	public function delete_settings() {

		delete_option( 'careerist_plugin' );
		delete_option( 'careerist_plugin_cpt_settings' );

		return $this;
	}

	public function create_tables() {
		$careerist_db_version = '1.0';
		$table_name = $this->wpdb->prefix . "careerist_areas"; 
		$charset_collate = $this->wpdb->get_charset_collate();

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
		add_option( 'careerist_db_version', $careerist_db_version );

		return $this;
	}

	public function delete_tables() {
		$table_name = $this->wpdb->prefix . "careerist_areas"; 

		$this->wpdb->query("DROP TABLE $table_name;");
		delete_option( 'careerist_db_version' );

		return $this;
	}

}
