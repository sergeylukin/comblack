<?php
/**
 * @package  CareeristPlugin
 */
namespace Careerist\Base;

class Deactivate
{
	public static function deactivate() {
		echo "Deactivation";
		flush_rewrite_rules();
	}
}
