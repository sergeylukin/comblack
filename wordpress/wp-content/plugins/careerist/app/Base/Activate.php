<?php
/**
 * @package  CareeristPlugin
 */
namespace Careerist\Base;
use Careerist\Helpers\DB;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();

		echo "Activation";
		// DB::obtain()
		// 	->create_settings()
		// 	->create_tables();
	}
}
