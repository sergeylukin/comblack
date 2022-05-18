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
		wp_enqueue_style( 'tablestyle', '//cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css');
		wp_enqueue_script( 'jquery', '//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js');
		wp_enqueue_script( 'tablescript', '//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js');
		wp_enqueue_style( 'careerist_style', $this->plugin_url . 'assets/mystyle.css', array(), filemtime(Path::assets() . '/mystyle.css'));
		wp_enqueue_script( 'careerist_script', $this->plugin_url . 'assets/myscript.js', array(), filemtime(Path::assets() . '/myscript.js'), true );
	}
}
