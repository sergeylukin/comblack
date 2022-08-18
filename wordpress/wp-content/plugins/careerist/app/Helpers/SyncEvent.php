<?php namespace Careerist\Helpers;

use Careerist\Helpers\Database;

/**
 * @package  CareeristPlugin
 */

class SyncEvent {
	private $db;
	private $sync_id = null;
	private $isEnabled = false;

	
	public function __construct(Database $db) {
		$this->db = $db;
		$this->isEnabled = $this->isLoggingEnabled();
	}

	private function createSyncIfNotExist() {
		if (!$this->sync_id) {
			$option = get_option( 'careerist_plugin' );
			$is_in_force_mode = isset( $option[ 'force_sync' ] ) ? $option[ 'force_sync' ] : false;
			$this->sync_id = $this->db->insertSync($is_in_force_mode);
		}
	}

	private function isLoggingEnabled() {
		$option = get_option( 'careerist_plugin' );
		if ($option && isset($option['logs_manager'])) {
			return $option['logs_manager'];
		}
		return false;
	}

	public function log($event_name = '', $adam_id = null, $local_id = null, $post_id = null) {
		if (!$this->isEnabled) return;
		$this->createSyncIfNotExist();
		$this->db->insertSyncEvent($this->sync_id, $event_name, $adam_id, $local_id, $post_id);
	}

	public function end() {
		if (!$this->isEnabled) return;
		$this->db->updateSync($this->sync_id, array('status' => 'finished'));
	}

	public function getLogs() {
		return $this->db->getSyncs();
	}

	public function removeOldLogs() {
		$this->db->deleteLogsAfterIndex(100000);
	}

}
