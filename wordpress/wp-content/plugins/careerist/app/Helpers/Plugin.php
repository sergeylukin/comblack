<?php namespace Careerist\Helpers;

use Careerist\Helpers\Database;
use Monolog\Logger;

/**
 * @package  CareeristPlugin
 */

class Plugin {

	
	public function __construct(Database $db, Logger $logger) {
		$this->db = $db;
		$this->logger = $logger;
	}

	public function activate() {
		flush_rewrite_rules();

		$this->logger->debug( 'Careerist activated');
		$this->db->create_settings()->create_tables();
	}

	public function deactivate() {
		flush_rewrite_rules();

		$this->logger->debug( 'Careerist deactivated');
		$this->db->delete_settings()->delete_tables();
	}

}
