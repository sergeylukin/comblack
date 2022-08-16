<?php /** * @package  CareeristPlugin */ namespace Inc\Base;

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
			'areas_manager' => 'Enable & sync areas',
			'categories_manager' => 'Enable & sync categories',
			'jobs_manager' => 'Enable & sync jobs',
			'force_sync' => 'Force sync',
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
