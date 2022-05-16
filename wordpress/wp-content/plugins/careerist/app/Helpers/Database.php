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

	private $tables;

	
	public function __construct($wpdb, $tables) {
		$this->wpdb = $wpdb;
		$this->tables = $tables;
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

	public function getAllAreas() {
		$arr = $this->wpdb->get_results("SELECT * FROM {$this->tables['areas']}");
		return $arr;
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
		delete_option( 'careerist_plugin_area' );

		return $this;
	}

	public function create_tables() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$careerist_db_version = '1.0';
		$charset_collate = $this->wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$this->tables['areas']} (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			created timestamp NOT NULL default CURRENT_TIMESTAMP,
			name tinytext NULL,
			adam_id mediumint(9) NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";
		dbDelta( $sql );

		$sql = "CREATE TABLE {$this->tables['categories']} (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			created timestamp NOT NULL default CURRENT_TIMESTAMP,
			name tinytext NULL,
			adam_id mediumint(9) NULL,
			adam_parent_id mediumint(9) default 0 NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";
		dbDelta( $sql );

		add_option( 'careerist_db_version', $careerist_db_version );

		return $this;
	}

	public function delete_tables() {
		$this->wpdb->query("DROP TABLE {$this->tables['areas']};");
		$this->wpdb->query("DROP TABLE {$this->tables['categories']};");
		delete_option( 'careerist_db_version' );

		return $this;
	}

}
