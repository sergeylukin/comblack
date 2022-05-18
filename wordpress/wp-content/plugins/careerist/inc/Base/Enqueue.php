<?php 
/**
 * @package  CareeristPlugin
 */
namespace Inc\Base;

use Inc\Base\BaseController;
use Path;

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
		wp_enqueue_style( 'tablestyle', 'https://cdn.datatables.net/v/dt/dt-1.12.0/sc-2.0.6/datatables.min.css');
		wp_enqueue_script( 'tablescript', 'https://cdn.datatables.net/v/dt/dt-1.12.0/sc-2.0.6/datatables.min.js');
		wp_enqueue_style( 'careerist_style', $this->plugin_url . 'assets/mystyle.css', array(), filemtime(Path::assets() . '/mystyle.css'));
		wp_enqueue_script( 'careerist_script', $this->plugin_url . 'assets/myscript.js', array(), filemtime(Path::assets() . '/myscript.js'), true );
	}
}
