<?php 
/**
 * @package  CareeristPlugin
 */
namespace Careerist\Base;

class BaseController
{
	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public $managers = array();

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/careerist-plugin.php';

		$this->managers = array(
			'areas_manager' => 'Activate Areas entity Manager',
			'categories_manager' => 'Activate Categories entity Manager',
			'jobs_manager' => 'Activate Jobs entity Manager',
			'logs_manager' => 'Activate Logs Manager',
		);
	}

	public function activated( string $key )
	{
		$option = get_option( 'careerist_plugin_settings' );

		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}
}
