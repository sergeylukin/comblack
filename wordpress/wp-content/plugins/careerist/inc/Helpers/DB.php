<?php
/**
 * @package  CareeristPlugin
 */
namespace Inc\Base;

class DB
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
class DB extends Core {

	/**
	 * Holds an insance of self
	 * @var $instance
	 */
	//private static $instance = NULL;

	
	public function __construct() {}

	/**
	*
	* Return DB instance only if it was not created yet
	*
	* @return object (PDO)
	*
	* @access protected (should be called only from Core class)
	*
	*/
	public static function obtain($db_type=null, $db_hostname=null, $db_port=null, $db_name=null, $db_username=null, $db_password=null) {
		
		/*** set Connection parameters ***/
		$db_type = ($db_type!=null) ? $db_type : Core::$_objects['Config']->database['db_type'];
		$db_hostname = ($db_hostname!=null) ? $db_hostname : Core::$_objects['Config']->database['db_hostname'];
		$db_port = ($db_port!=null) ? $db_port : Core::$_objects['Config']->database['db_port'];
        $db_name = ($db_name!=null) ? $db_name : Core::$_objects['Config']->database['db_name'];
        $db_username = ($db_username!=null) ? $db_username : Core::$_objects['Config']->database['db_username'];
        $db_password = ($db_password!=null) ? $db_password : Core::$_objects['Config']->database['db_password'];
        
        /*** Initiate PDO object ***/
        $DBH = new PDO("$db_type:host=$db_hostname;port=$db_port;dbname=$db_name", $db_username, $db_password);
        $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        
        return $DBH;
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

}
