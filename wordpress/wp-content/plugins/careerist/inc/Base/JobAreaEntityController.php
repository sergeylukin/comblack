<?php 
/**
 * @package  CareeristPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AreaCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;
use Logger;

/**
* 
*/
class JobAreaEntityController extends BaseController
{
	public $settings;

	public $callbacks;

	public $subpages = array();

	public $custom_post_types = array();

	public function register()
	{
		if ( ! $this->activated( 'areas_manager' ) ) return;

		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();
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
				'callback' => array( $this->callbacks, 'adminArea' )
			)
		);
	}


}
