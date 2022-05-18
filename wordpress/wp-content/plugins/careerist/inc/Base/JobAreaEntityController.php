<?php 
/**
 * @package  CareeristPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Logger;
use Path;

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
		$data = [];
		$DB = $this->App['Database'];
		$data = $DB->getAllAreas();

		$args = array(
				'hide_empty' => false, // also retrieve terms which are not used yet
				'taxonomy'  => 'area',
		);
		$taxonomy_items = get_terms( $args );

		return require_once( Path::templates() . "/areas.php" );
	}



}
