<?php 
/**
 * @package  CareeristPlugin
 */
namespace Inc\Base;

class BaseController
{
	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public $managers = array();

	protected $App;

	protected $wpdb;

	public function __construct($App, $wpdb) {
		$this->App = $App;
		$this->wpdb = $wpdb;
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/careerist-plugin.php';

		$this->managers = array(
			'force_sync' => 'Force update values in DB during Sync',
			'areas_manager' => 'Activate Areas entity Manager',
			'categories_manager' => 'Activate Categories entity Manager',
			'jobs_manager' => 'Activate Jobs entity Manager',
			'logs_manager' => 'Activate Logs Manager',
		);
	}

	public function activated( string $key )
	{
		$option = get_option( 'careerist_plugin' );

		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}

	public function activate($key) {
		if ( $current = get_option( 'careerist_plugin' ) ) {
			$current[$key] = true;
			update_option( 'careerist_plugin', $current  );
		}
	}
}
