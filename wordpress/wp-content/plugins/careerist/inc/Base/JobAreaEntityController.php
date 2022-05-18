<?php 
/**
 * @package  CareeristPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Logger;

/**
* 
*/
class JobAreaEntityController extends BaseController
{
	public $settings;

	public $subpages = array();

	public $custom_post_types = array();

	public function register()
	{
		if ( ! $this->activated( 'areas_manager' ) ) return;

		$this->settings = new SettingsApi();
		$logger = \App::resolve('Logger');

		$this->setSubpages();

		$this->settings->addSubPages( $this->subpages )->register();
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'careerist_plugin', 
				'page_title' => 'Job Area entity', 
				'menu_title' => 'Areas', 
				'capability' => 'manage_options', 
				'menu_slug' => 'careerist_area', 
				'callback' => array( $this, 'render' )
			)
		);
	}

	public function render()
	{
		return require_once( "$this->plugin_path/templates/areas.php" );
	}



}
