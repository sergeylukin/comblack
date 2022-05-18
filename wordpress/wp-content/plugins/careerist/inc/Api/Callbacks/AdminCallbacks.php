<?php 
/**
 * @package  CareeristPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{

	public function adminArea()
	{
		return require_once( "$this->plugin_path/templates/area.php" );
	}

	public function adminCategory()
	{
		return require_once( "$this->plugin_path/templates/category.php" );
	}

	public function adminLogs()
	{
		return require_once( "$this->plugin_path/templates/logs.php" );
	}

}
