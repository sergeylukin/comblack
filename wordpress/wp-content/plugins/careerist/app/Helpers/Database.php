<?php namespace Careerist\Helpers;

/**
 * @package  CareeristPlugin
 */

class Database {

  /**
   * The Wordpress DB object instance
   *
   */
  protected $wpdb;

	private $tables;

	
	public function __construct($wpdb, $tables) {
		$this->wpdb = $wpdb;
		$this->tables = $tables;
	}
	
	/**
	*
	* Like the constructor, we make __clone private
	* so nobody can clone the instance
	*
	*/
	private function __clone()
	{
	}

	public function getCategoryIdByAdamProfessionId($id) {
		$sql = $this->wpdb->prepare( "SELECT id FROM {$this->tables['categories']} WHERE adam_id = %d ORDER BY created DESC", $id );
		$results = $this->wpdb->get_results( $sql , ARRAY_A );
		if (count($results) > 0) return $results[0]['id'];
		return 0;
	}

	public function getAllJobs() {
		$arr = $this->wpdb->get_results("SELECT * FROM {$this->tables['jobs']} ORDER BY id DESC");
		return $arr;
	}

	public function getAllAreas() {
		$arr = $this->wpdb->get_results("SELECT * FROM {$this->tables['areas']}");
		return $arr;
	}

	public function getAllCategories($id = 0) {
		$arr = $this->wpdb->get_results("SELECT * FROM {$this->tables['categories']} WHERE adam_parent_id = {$id} ORDER BY adam_id;");
		return $arr;
	}

	public function create_settings() {
		$default = array(
			'force_sync' => 0,
			'adam_api_token' => 'ecb8e17c-2acd-413d-a977-12a41b68480a',
			'jobs_manager' => 0,
			'areas_manager' => 1,
			'categories_manager' => 1,
			'logs_manager' => 0,
		);

		if ( ! get_option( 'careerist_plugin' ) ) {
			update_option( 'careerist_plugin', $default );
		}

		return $this;
	}

	public function delete_settings() {

		delete_option( 'careerist_plugin' );

		return $this;
	}

	public function create_tables() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$careerist_db_version = '1.3';
		if (get_option('careerist_plugin')) {
			update_option( 'careerist_db_version', $careerist_db_version );
		} else {
			add_option( 'careerist_db_version', $careerist_db_version );
		}
		$charset_collate = $this->wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$this->tables['areas']} (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			created timestamp NOT NULL default CURRENT_TIMESTAMP,
			name tinytext NULL,
			adam_id mediumint(9) NULL,
      local_taxonomy_id mediumint(9) NULL,
			UNIQUE KEY id (id),
			UNIQUE KEY adam_id (adam_id)
		) $charset_collate;";
		dbDelta( $sql );

		$sql = "CREATE TABLE {$this->tables['categories']} (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			created timestamp NOT NULL default CURRENT_TIMESTAMP,
			name tinytext NULL,
			adam_id mediumint(9) NULL,
			adam_parent_id mediumint(9) default 0 NOT NULL,
      local_taxonomy_id mediumint(9) NULL,
			UNIQUE KEY id (id),
			UNIQUE KEY adam_id (adam_id)
		) $charset_collate;";
		dbDelta( $sql );

		$sql = "CREATE TABLE {$this->tables['jobs']} (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			created timestamp NOT NULL default CURRENT_TIMESTAMP,
      updated_date timestamp NULL,
			description tinytext NULL,
			adam_id mediumint(9) NULL,
      category_id mediumint(9) NULL,
      subcategory_id mediumint(9) NULL,
			adam_close_date tinytext NULL,
			adam_closeDate_ddmmyyy tinytext NULL,
			adam_description text NULL,
			adam_email_rakaz tinytext NULL,
			adam_email_snif tinytext NULL,
			adam_living_area1 tinytext NULL,
			adam_living_area2 tinytext NULL,
			adam_living_area3 tinytext NULL,
			adam_living_area4 tinytext NULL,
			adam_name_snif tinytext NULL,
			adam_order_snif smallint UNSIGNED NULL,
			adam_notes text NULL,
			adam_order_email tinytext NULL,
			adam_order_id int UNSIGNED NULL,
			adam_perot_tafked tinytext NULL,
			adam_profession_name tinytext NULL,
			adam_rakaz tinytext NULL,
			adam_tat_profession_name tinytext NULL,
			adam_telefon tinytext NULL,
			adam_tkofat_avoda_moza tinytext NULL,
			adam_toar tinytext NULL,
			adam_update_date tinytext NULL,
			adam_updateDate_ddmmyyyy tinytext NULL,
			adam_work_area tinytext NULL,
			adam_order_def_prof1 tinyint UNSIGNED NULL,
			adam_order_def_prof_name1 tinytext NULL,
			adam_order_def_subprof1 tinyint UNSIGNED NULL,
			adam_order_def_sub_prof_name1 tinytext NULL,
			adam_order_def_prof2 tinyint UNSIGNED NULL,
			adam_order_def_prof_name2 tinytext NULL,
			adam_order_def_subprof2 tinyint UNSIGNED NULL,
			adam_order_def_sub_prof_name2 tinytext NULL,
			adam_order_def_prof3 tinyint UNSIGNED NULL,
			adam_order_def_prof_name3 tinytext NULL,
			adam_order_def_subprof3 tinyint UNSIGNED NULL,
			adam_order_def_sub_prof_name3 tinytext NULL,
			adam_order_def_prof4 tinyint UNSIGNED NULL,
			adam_order_def_prof_name4 tinytext NULL,
			adam_order_def_subprof4 tinyint UNSIGNED NULL,
			adam_order_def_sub_prof_name4 tinytext NULL,
			adam_order_def_prof5 tinyint UNSIGNED NULL,
			adam_order_def_prof_name5 tinytext NULL,
			adam_order_def_subprof5 tinyint UNSIGNED NULL,
			adam_order_def_sub_prof_name5 tinytext NULL,
			adam_order_def_area1 tinyint UNSIGNED NULL,
			adam_order_def_area_name1 tinytext NULL,
			adam_order_def_area2 tinyint UNSIGNED NULL,
			adam_order_def_area_name2 tinytext NULL,
			adam_order_def_area3 tinyint UNSIGNED NULL,
			adam_order_def_area_name3 tinytext NULL,
			adam_order_def_area4 tinyint UNSIGNED NULL,
			adam_order_def_area_name4 tinytext NULL,
			adam_order_def_area5 tinyint UNSIGNED NULL,
			adam_order_def_area_name5 tinytext NULL,
			adam_order_def_area6 tinyint UNSIGNED NULL,
			adam_order_def_area_name6 tinytext NULL,
			adam_order_def_job_scope1 tinyint UNSIGNED NULL,
			adam_order_def_job_scope2 tinyint UNSIGNED NULL,
			adam_order_def_job_scope3 tinyint UNSIGNED NULL,
			adam_orderno_external tinytext NULL,
			adam_Order_place tinytext NULL,
			adam_ProffesionID tinyint UNSIGNED NULL,
			adam_SubProffesionID tinyint UNSIGNED NULL,
			adam_SubProffesionIDUntil tinyint UNSIGNED NULL,
			adam_Branch tinyint UNSIGNED NULL,
			adam_IaHot tinyint UNSIGNED NULL,
			adam_IsHot tinyint UNSIGNED NULL,
			adam_RakazID tinyint UNSIGNED NULL,
			adam_snifCode tinyint UNSIGNED NULL,
			adam_orderDate tinytext NULL,
			adam_orderDate_ddmmyyyy tinytext NULL,
			adam_advertising_destination tinyint UNSIGNED NULL,
			adam_car_owner tinytext NULL,
			adam_client_name tinytext NULL,
			adam_requirement1 tinytext NULL,
			adam_requirement2 tinytext NULL,
			adam_category_id tinytext NULL,
			adam_category_name tinytext NULL,
			adam_client_parent_id tinyint UNSIGNED NULL,
			adam_client_parent_name tinytext NULL,
			adam_internal_job_deadline tinytext NULL,
			adam_rakaz_handle_id tinyint UNSIGNED NULL,
			adam_rakaz_handle_name tinytext NULL,
			adam_start_advertising_date tinytext NULL,
			adam_end_advertising_date tinytext NULL,
			adam_friend_reward tinyint UNSIGNED  NULL,
			adam_is_html_notes tinytext NULL
			UNIQUE KEY id (id),
			UNIQUE KEY adam_id (adam_id)
		) $charset_collate;";
		dbDelta( $sql );

		return $this;
	}

	public function delete_tables() {
		// $this->wpdb->query("DROP TABLE {$this->tables['areas']};");
		// $this->wpdb->query("DROP TABLE {$this->tables['categories']};");
		// $this->wpdb->query("DROP TABLE {$this->tables['jobs']};");
		// delete_option( 'careerist_db_version' );

		return $this;
	}

}
