<?php 
/**
 * @package  CareeristPlugin
 */
namespace Inc\Base;

use Inc\Base\BaseController;

/**
* 
*/
class Enqueue extends BaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}
	
	function enqueue($hook_suffix) {
		if (strpos($hook_suffix, '_page_careerist') === false) return;
		// enqueue all our scripts
		wp_enqueue_style( 'mypluginstyle', $this->plugin_url . 'assets/mystyle.css' );
		wp_enqueue_script( 'mypluginscript', $this->plugin_url . 'assets/myscript.js' );
	}
}
