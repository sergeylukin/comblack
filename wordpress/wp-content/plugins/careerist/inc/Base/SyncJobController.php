<?php 
/**
 * @package  CareeristPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AreaCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;
use CSV;
use Database;
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
		// Allow non-logged in visitors run this script
    add_action("wp_ajax_nopriv_careerist_sync_trigger", array($this, "sync"));
    add_action("wp_ajax_careerist_adam_api_get_order_details_as_is", array($this, "adam_api_get_order_details"));
		// Allow non-logged in visitors run this script
    add_action("wp_ajax_nopriv_careerist_adam_api_get_order_details_as_is", array($this, "adam_api_get_order_details"));
    add_action("wp_ajax_careerist_wire_taxonomy", array($this, "wire_taxonomy"));
		add_action('wp_ajax_careerist_list_jobs', array($this, 'list_jobs'));
		add_action('wp_ajax_careerist_export_jobs', array($this, 'export_jobs'));
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

	public function adam_api_get_order_details() {
			header("Content-Type: application/json");
			$job = $this->App->AdamAPI->getJob($_GET['orderno']);
			$result = [
					'adam_response' => $job,
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

			$wpdb->insert(
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
				$wpdb->insert(
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
				$wpdb->update(
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
		$existing_jobs = $this->wpdb->get_results("SELECT id, adam_id, adam_update_date FROM {$this->App['table.jobs']}");
		$existing_ids = array_map(function($o) { return $o->adam_id;}, $existing_jobs);

		$force_sync = $this->activated('force_sync');
		$jobs = $this->App->AdamAPI->getJobs();
		foreach($jobs as $job) {
			$exists = in_array($job['adam_id'], $existing_ids);

			if (!$exists) {
				$this->wpdb->insert(
					$this->App['table.jobs'],
					$job
				);
				$job_id = $this->wpdb->insert_id;


				$post_array = [
					"post_title" => $job['description'],
					"post_type" => "careers",
					"post_content" => $job['adam_notes'],
					"post_status"=>"publish",
				];
				$post_id = wp_insert_post($post_array);
				update_post_meta( $post_id, 'careerist_id', $job_id );

				$wp_cat_id = $this->App['Database']->categoryIdToTaxonomyId($job['category_id']);
				$wp_subcat_id = $this->App['Database']->categoryIdToTaxonomyId($job['subcategory_id']);

				// attaching the category
				if($wp_cat_id){
					$tag = [$wp_cat_id];
					if ($wp_subcat_id) $tag[] = $wp_subcat_id;
					wp_set_post_terms( $post_id, $tag, 'categories' );    
				}  


				if ($areaId = $job['adam_order_def_area1']) {
					$term_id = $this->App['Database']->adamAreaIdToTaxonomyId($areaId);
					wp_set_post_terms( $post_id, [$term_id], 'area' );        
				}

				$this->wpdb->update(
					$this->App['table.jobs'],
					['local_post_id' => $post_id],
					['id' => $job_id]
				);
			}

			if ($exists) {
				$index = array_search($job['adam_id'], array_column($existing_jobs, 'adam_id'));
				$row = $existing_jobs[$index];
				$isDirty = $job['adam_update_date'] !== $row->adam_update_date;
				if ($isDirty || $force_sync) {
					$this->wpdb->update(
						$this->App['table.jobs'],
						$job,
						array('id' => $row->id)
					);
				}
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

	public function list_jobs2() {
      $mock_path = __DIR__ . '/jobs.json';
      $json = file_get_contents($mock_path);
			echo $json;
			die();
	}

	public function list_jobs() {
		echo json_encode(['data' => Database::getJobsWithCategories()]);
		die();
	}

	public function export_jobs() {
		CSV::from(Database::getJobsWithCategories(), 'comblack_jobs.csv');
		die();
	}

}
