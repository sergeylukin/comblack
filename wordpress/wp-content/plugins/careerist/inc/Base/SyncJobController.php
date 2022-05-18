<?php 
/**
 * @package  CareeristPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AreaCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;
use Logger;

/**
* 
*/
class SyncJobController extends BaseController
{
	public $settings;

	public $callbacks;

	public $subpages = array();

	public $custom_post_types = array();

	public function register()
	{
    add_action("wp_ajax_careerist_sync_trigger", array($this, "sync"));
    add_action("wp_ajax_careerist_wire_taxonomy", array($this, "wire_taxonomy"));
	}

	public function sync() {

			header("Content-Type: application/json");
			if ($this->activated('areas_manager')) $this->sync_areas();
			if ($this->activated('categories_manager')) $this->sync_categories();
			if ($this->activated('jobs_manager')) $this->sync_jobs();
			$result = [
					'success' => true,
			];
			echo json_encode($result);
			die();
	}


	private function sync_areas() {
		global $App, $wpdb;
		$existing_ids = $wpdb->get_col("SELECT adam_id FROM {$App['table.areas']}");

		$areas = $App->AdamAPI->getAreas();
		foreach($areas as $area) {
			if (in_array($area['adam_id'], $existing_ids)) continue;

			$insert = $wpdb->insert(
				$App['table.areas'],
				array(
					'name' => $area['name'],
					'adam_id' => $area['adam_id'],
				)
			);
		}
	}

	private function sync_categories() {
		global $App, $wpdb;
		$existing_categories = $wpdb->get_results("SELECT id, adam_id FROM {$App['table.categories']}");
		$existing_ids = array_map(function($o) { return $o->adam_id;}, $existing_categories);

		$categories = $App->AdamAPI->getCategories();
		$force_sync = $this->activated('force_sync');
		foreach($categories as $category) {
			$exists = in_array($category['adam_id'], $existing_ids);

			if (!$exists) {
				$insert = $wpdb->insert(
					$App['table.categories'],
					array(
						'name' => $category['name'],
						'adam_id' => $category['adam_id'],
						'adam_parent_id' => $category['adam_parent_id'],
					)
				);
			}

			if ($exists && $force_sync) {
				$index = array_search($category['adam_id'], array_column($existing_categories, 'adam_id'));
				$row = $existing_categories[$index];
				$insert = $wpdb->update(
					$App['table.categories'],
					array(
						'name' => $category['name'],
						'adam_id' => $category['adam_id'],
						'adam_parent_id' => $category['adam_parent_id'],
					),
					array('id' => $row->id)
				);
			}
		}
	}

	private function sync_jobs() {
		$existing_jobs = $this->wpdb->get_results("SELECT id, adam_id FROM {$this->App['table.jobs']}");
		$existing_ids = array_map(function($o) { return $o->adam_id;}, $existing_jobs);

		$jobs = $this->App->AdamAPI->getJobs();
		foreach($jobs as $job) {
			$exists = in_array($job['adam_id'], $existing_ids);

			if (!$exists) {
				$insert = $this->wpdb->insert(
					$this->App['table.jobs'],
					$job
				);
			}

			if ($exists && $force_sync) {
				$index = array_search($job['adam_id'], array_column($existing_jobs, 'adam_id'));
				$row = $existing_jobs[$index];
				$insert = $this->wpdb->update(
					$this->App['table.jobs'],
					$job,
					array('id' => $row->id)
				);
			}
		}
	  
	}

	public function wire_taxonomy() {
		$taxonomy = $_POST['taxonomy'];
		$careerist_id = $_POST['careerist_id'];
		$id = $_POST['id'];

		Logger::warning('UPDATING ' . $taxonomy . ' ' . $careerist_id . ' to ' . $id, $_POST);
		$this->wpdb->update(
					$this->App["table.{$taxonomy}"],
					array(
						'local_taxonomy_id' => $id,
					),
					array('id' => $careerist_id)
				);
			$result = [
					'success' => true,
			];
			echo json_encode($result);
		die();
	}

}
