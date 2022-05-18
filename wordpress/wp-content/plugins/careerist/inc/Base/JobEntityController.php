<?php 
/**
 * @package  CareeristPlugin
 */
namespace Inc\Base;

use Path;
use Inc\Api\SettingsApi;
use Logger;

/**
* 
*/
class JobEntityController extends BaseController
{
	public $settings;

	public $callbacks;

	public $subpages = array();

	public $custom_post_types = array();

	public function register()
	{
		if ( ! $this->activated( 'jobs_manager' ) ) return;

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
				'page_title' => 'Job entity', 
				'menu_title' => 'Jobs', 
				'capability' => 'manage_options', 
				'menu_slug' => 'careerist_jobs', 
				'callback' => array( $this, 'render' )
			)
		);
	}

	public function render()
	{
		return require_once( Path::templates() . "/jobs.php" );
	}


}
