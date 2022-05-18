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
	}

	public function sync() {
		global $App;

		global $wpdb;

			header("Content-Type: application/json");
			$existing_ids = $wpdb->get_col("SELECT adam_id FROM {$App['table.areas']}");

			$areas = $App->AdamAPI->getAreas();
			$inserts = true;
			foreach($areas as $area) {
				if (in_array($area['AreaId'], $existing_ids)) continue;

				$table_name = $App['table.areas'];;
				$episode_title = sanitize_text_field($_POST['episode_title']);
				$episode_desc = sanitize_text_field($_POST['episode_desc']);
				$air_date = sanitize_text_field($_POST['air_date']);

				$insert = $wpdb->insert(
					$table_name,
					array(
						'name' => $area['AreaName'],
						'adam_id' => $area['AreaId'],
					)
				);
				if (!$insert) $inserts = false;
			}
			$result = [
					'success' => (!$insert ? false : true),
					'foo' => 'barrrr'
			];
			echo json_encode($result);
			die();
	}

}
