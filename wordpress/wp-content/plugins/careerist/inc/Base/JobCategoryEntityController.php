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
class JobCategoryEntityController extends BaseController
{
	public $settings;

	public $callbacks;

	public $subpages = array();

	public $custom_post_types = array();

	public function register()
	{
		if ( ! $this->activated( 'categories_manager' ) ) return;

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
				'page_title' => 'Job Category entity', 
				'menu_title' => 'Categories', 
				'capability' => 'manage_options', 
				'menu_slug' => 'careerist_categories', 
				'callback' => array( $this, 'render' )
			)
		);
	}

	public function render()
	{
		$data = [];
		$DB = $this->App['Database'];
		$categories = $DB->getAllCategories();
		foreach ($categories as $category) {
			array_push($data, $category);
			$subcategories = $DB->getAllCategories($category->adam_id);
			foreach ($subcategories as $subcategory) {
				array_push($data, $subcategory);
			}
		}

		$args = array(
				'hide_empty' => false, // also retrieve terms which are not used yet
				'taxonomy'  => 'categories',
		);
		$taxonomy_items = get_terms( $args );

		return require_once( Path::templates() . "/categories.php" );
	}

}
