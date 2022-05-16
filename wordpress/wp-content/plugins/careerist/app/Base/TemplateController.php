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
class TemplateController extends BaseController
{
	public $callbacks;

	public $subpages = array();

	public function register()
	{
		if ( ! $this->activated( 'templates_manager' ) ) return;

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
				'page_title' => 'Templates Manager', 
				'menu_title' => 'Templates Manager', 
				'capability' => 'manage_options', 
				'menu_slug' => 'careerist_templates', 
				'callback' => array( $this->callbacks, 'adminTemplates' )
			)
		);
	}
}