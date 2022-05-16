<?php 
/**
 * @package  CareeristPlugin
 */
namespace Careerist\Base;

use Careerist\Api\SettingsApi;
use Careerist\Base\BaseController;
use Careerist\Api\Callbacks\AdminCallbacks;

/**
* 
*/
class GalleryController extends BaseController
{
	public $callbacks;

	public $subpages = array();

	public function register()
	{
		if ( ! $this->activated( 'gallery_manager' ) ) return;

		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->setSubpages();

		$this->settings->addSubPages( $this->subpages )->register();
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'careerist_plugin', 
				'page_title' => 'Gallery Manager', 
				'menu_title' => 'Gallery Manager', 
				'capability' => 'manage_options', 
				'menu_slug' => 'careerist_gallery', 
				'callback' => array( $this->callbacks, 'adminGallery' )
			)
		);
	}
}