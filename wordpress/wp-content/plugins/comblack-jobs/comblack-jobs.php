<?php
/**
 * Plugin Name: Comblack Jobs
 * Plugin URI: a124662-tmp.s933.upress.link
 * Description: This plugin will handle comblack-jobs.
 * Version: 1.0
 * Author: Yigal
 * Author URI: a124662-tmp.s933.upress.link
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: comblack-jobs
 */
 

$url  = untrailingslashit(plugin_dir_url( __FILE__ ));
$path = untrailingslashit(plugin_dir_path( __FILE__ ));

define('COMBLACK_URL', $url);
define('COMBLACK_PATH', $path);
define('COMBLACK_LOG', false);

define('COMBLACK_TAXONOMY','categories');
// Includes
// include_once $path . '/functions.php';

class Comblack_Jobs{
    
    
    private static $ins = null;
    
    public static function get_instance()
    {
        // create a new object if it doesn't exist.
        is_null(self::$ins) && self::$ins = new self;
        return self::$ins;
    }
    
    static function activate_plugin() {
        
        $cron_interval = 'daily';
        if (! wp_next_scheduled( 'pull_jobs_categories_after_a_day' ) ) {
            wp_schedule_event( time(), $cron_interval, 'pull_jobs_categories_after_a_day');
        }
    }
    
     static function deactivate_plugin(){
        
        wp_clear_scheduled_hook( 'pull_jobs_categories_after_a_day' );
    }
    
    
    
    function __construct() {

        // add_action( 'rest_api_init', array( $this , 'comblack_apis' ));
        
        add_action('pull_jobs_categories_after_a_day', array($this, 'run_crons'), 11);
        add_action('wp_ajax_pull_jobs_categories_after_a_day', array($this, 'run_crons'), 11);
        // add_action('pull_jobs_categories_after_a_day', array($this, 'insert_subcategory'), 11);
        // add_action('pull_jobs_categories_after_a_day', array($this, 'insert_job'), 99);

        // add_action('init', array($this, 'init'));

    }

    function init(){

        $this->insert_job();
    }

    function run_crons(){

        // $this->pa('runing cron '.time());
        $this->insert_category();
        $this->insert_job();
    }
    
    function comblack_apis(){
        register_rest_route('jobs/v1', 'job_ids', array(
            'methods' => 'GET',
            'callback' => array(
                $this,
                'insert_job'
            )
        ));
    }


    function insert_category() {
        
        $categories = getJobCategoriesFromAPI();
        // $this->log($categories);
        echo "========START CATEGORIES0============";
        print_r($categories);
        echo "========END CATEGORIES0============";
        
        $category_ids_exists = $this->wcgs_get_linked_category_ids();

        foreach($categories['p'] as $category){

            $category_id = $category['@attributes']['i'];
            if( in_array($category_id, $category_ids_exists) ) continue;

            $term = wp_insert_term($category['@attributes']['n'],COMBLACK_TAXONOMY);
            $update_res = update_term_meta($term['term_id'], 'careers_category_id', $category_id);
            // var_dump($category_id, $term_id, $update_res);
        }
    }

    function insert_subcategory() {
        
        $categories = getJobCategoriesFromAPI();
        // $this->log($categories);
        
        $category_ids_exists = $this->wcgs_get_linked_subcategory_ids();

        foreach($categories['p'] as $category){

            $category_id = $category['@attributes']['i'];
            if( in_array($category_id, $category_ids_exists) ) continue;

            $term = wp_insert_term($category['@attributes']['n'],COMBLACK_TAXONOMY);
            $update_res = update_term_meta($term['term_id'], 'careers_category_id', $category_id);
            // var_dump($category_id, $term_id, $update_res);
        }
    }
    
    function insert_job() {


        $jobs = $this->get_jobs();
        // $this->log($jobs);
        echo "========START JOBS============";
        print_r($jobs);
        echo "========END JOBS============"; // setting all jobs to draft
        $this->wcgs_set_job_status_draft();

        $jobs_ids_exists = $this->wcgs_get_linked_job_ids();
        // $this->log($jobs_ids_exists);
        $categories_ids = $this->wcgs_get_linked_category_id_vs_id();

        // $subcategories_ids = $this->wcgs_get_linked_subcategory_id_vs_id();
        
        foreach($jobs['o'] as $job){
            
            $job_id = $job['@attributes']['i'];
            $category_id = $job['@attributes']['order_def_prof1'];
            $subcategory_id = $job['@attributes']['order_def_subprof1'];

            $post_array = [];
            if( in_array($job_id, $jobs_ids_exists) ) {

                $post_id = $this->wcgs_get_post_id_by_job_id($job_id);
                // $this->log($job_id);
                // $this->log($post_id);
                if( $post_id ) {                    
                    $post_array = [
                    "ID"        => $post_id,
                    "post_title" => $job['@attributes']['d'],
                    "post_type" => "careers",
                    "post_content" => $job['@attributes']['n'],
                    "post_status"=>"publish",
                    ];
                }
            } else {
                $post_array = [
                "post_title" => $job['@attributes']['d'],
                "post_type" => "careers",
                "post_content" => $job['@attributes']['n'],
                "post_status"=>"publish",
                ];
            }
            
        
            $post_id = wp_insert_post($post_array);
            
            update_field( 'job_id', $job_id, $post_id );
            update_post_meta( $post_id, 'careers_job_id', $job_id );

            $wp_cat_id = isset($categories_ids[$category_id]) ? intval($categories_ids[$category_id]) : null;

            // $wp_subcat_id = isset($categories_ids[$subcategory_id]) ? intval($categories_ids[$subcategory_id]) : null;

            // attaching the category
            if($wp_cat_id){
                $tag = [$wp_cat_id];
                wp_set_post_terms( $post_id, $tag, COMBLACK_TAXONOMY );    
            }  

            // attaching the sub category
            // if($wp_subcat_id){
            //     $tag = [$wp_subcat_id];
            //     wp_set_post_terms( $post_id, $tag, COMBLACK_TAXONOMY );    
            // }           

            // attaching subcategory
            if(!empty($job['@attributes']['sub_proffesion_name'])){                
                $sub_proffesion_name = trim($job['@attributes']['sub_proffesion_name']); 
                $subcat_term = term_exists($sub_proffesion_name, 'subcategory');
                if ( !$subcat_term ) {
                    $subcat_term = wp_insert_term($sub_proffesion_name, 'subcategory');
                }
                $subcat_term_id = intval($subcat_term['term_id']);
                $tag = [$subcat_term_id];
                wp_set_post_terms( $post_id, $tag, 'subcategory' );        
            }

            // attaching the areas
            // $areas = $this->get_areas();
            if(!empty($job['@attributes']['area1'])){                
                $area1 = trim($job['@attributes']['area1']); 
                $term1 = term_exists($area1, 'area');
                if ( !$term1 ) {
                    $term1 = wp_insert_term($area1, 'area');
                }
                $tag = [$term1['term_id']];
                wp_set_post_terms( $post_id, $tag, 'area' );        
            }

            if(!empty($job['@attributes']['area2'])){                
                $area2 = trim($job['@attributes']['area2']); 
                $term2 = term_exists($area2, 'area');
                if ( !$term2 ) {
                    $term2 = wp_insert_term($area2, 'area');
                }
                $tag = [$term2['term_id']];
                wp_set_post_terms( $post_id, $tag, 'area' );
            }

            if(!empty($job['@attributes']['area3'])){                
                $area3 = trim($job['@attributes']['area3']); 
                $term3 = term_exists($area3, 'area');
                if ( !$term3 ) {
                    $term3 = wp_insert_term($area3, 'area');
                }
                $tag = [$term3['term_id']];
                wp_set_post_terms( $post_id, $tag, 'area' );
            }

            if(!empty($job['@attributes']['area4'])){                
                $area4 = trim($job['@attributes']['area4']); 
                $term4 = term_exists($area4, 'area');
                if ( !$term4 ) {
                    $term4 = wp_insert_term($area4, 'area');
                }
                $tag = [$term4['term_id']];
                wp_set_post_terms( $post_id, $tag, 'area' );
            }
        }
    }
    
    
    function get_jobs() {
        
        $array = apiRequest('https://services.adamtotal.co.il/api/Career/GetOrdersDetails');
        
        return $array;
    }

    function get_areas() {

        $areas = get_terms('area', 'hide_empty=0');

        $only_ids = array_map(function($t){
                return $t->term_id;
        }, $areas);

        $only_names = array_map(function($t){
                return $t->name;
        }, $areas);

        $areas = array_combine($only_names, $only_ids);

        return $areas;

        // $this->pa($areas);

    }

    function get_subcategories() {

        $areas = get_terms('subcategory', 'hide_empty=0');

        $only_ids = array_map(function($t){
                return $t->term_id;
        }, $areas);

        $only_names = array_map(function($t){
                return $t->name;
        }, $areas);

        $areas = array_combine($only_names, $only_ids);

        return $areas;

        // $this->pa($areas);
    }

    function pa($arr){
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }

    function log ( $log )  {
    
        if ( COMBLACK_LOG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                  $resp = error_log( print_r( $log, true ), 3, COMBLACK_PATH.'/log/comblack.txt' );
            } else {
                  $resp = error_log( $log, 3, COMBLACK_PATH.'/log/comblack.txt' );
            }
        }
    }


    function wcgs_get_linked_job_ids() {
    
        global $wpdb;
        
        $qry = "SELECT meta_value from {$wpdb->prefix}postmeta where meta_key = 'careers_job_id';";
        
        $result = $wpdb->get_results($qry, ARRAY_N);
        $result = array_map(function($c){
            return $c[0];
        }, $result);
        // $this->pa($result);
        
        return apply_filters('wcgs_non_linked_products_ids', $result);
    }

    function wcgs_get_linked_category_ids() {
    
        global $wpdb;
        
        $qry = "SELECT meta_value from {$wpdb->prefix}termmeta where meta_key = 'careers_category_id';";
        $qry = "SELECT meta_value from {$wpdb->prefix}termmeta;";
        echo $qry;
        
        $result = $wpdb->get_results($qry, ARRAY_N);
        $result = array_map(function($c){
            return $c[0];
        }, $result);
        $this->pa($result);
        
        return apply_filters('wcgs_get_linked_category_ids', $result);
    }

    function wcgs_get_linked_subcategory_ids() {
    
        global $wpdb;
        
        $qry = "SELECT meta_value from {$wpdb->prefix}termmeta where meta_key = 'careers_category_id';";
        $qry = "SELECT meta_value from {$wpdb->prefix}termmeta;";
        echo $qry;
        
        $result = $wpdb->get_results($qry, ARRAY_N);
        $result = array_map(function($c){
            return $c[0];
        }, $result);
        $this->pa($result);
        
        return apply_filters('wcgs_get_linked_subcategory_ids', $result);
    }

    function wcgs_get_linked_category_id_vs_id() {
    
        global $wpdb;
        
        $qry = "SELECT term_id, meta_value from {$wpdb->prefix}termmeta where meta_key = 'careers_category_id';";
        
        $result = $wpdb->get_results($qry, ARRAY_N);
        // $result = array_map(function($c){
        //     return $c[0];
        // }, $result);

        $keys = array_column($result, '0');
        $values = array_column($result, '1');

        $key_val = array_combine($values, $keys);

        // $this->pa($key_val);
        
        return apply_filters('wcgs_get_linked_category_id_vs_id', $key_val);
    }


    function wcgs_get_linked_subcategory_id_vs_id() {
    
        global $wpdb;
        
        $qry = "SELECT term_id, meta_value from {$wpdb->prefix}termmeta where meta_key = 'careers_category_id';";
        
        $result = $wpdb->get_results($qry, ARRAY_N);
        // $result = array_map(function($c){
        //     return $c[0];
        // }, $result);

        $keys = array_column($result, '0');
        $values = array_column($result, '1');

        $key_val = array_combine($values, $keys);

        // $this->pa($key_val);
        
        return apply_filters('wcgs_get_linked_subcategory_id_vs_id', $key_val);
    }

    // set status to draft of all posts
    function wcgs_set_job_status_draft() {
    
        global $wpdb;
        
        $qry = "UPDATE {$wpdb->prefix}posts SET post_status='draft' WHERE post_type='careers';";
        
        $result = $wpdb->query($qry);
    }

    // get post_id by meta (job_id)
    function wcgs_get_post_id_by_job_id($job_id){

        global $wpdb;

        $qry = "SELECT post_id from {$wpdb->prefix}postmeta where meta_key = 'careers_job_id' and meta_value='{$job_id}'";
        $post_id = $wpdb->get_col($qry );
        // $this->log($qry);
        // $this->log($post_id);
        
        return isset($post_id[0]) ? $post_id[0] : null;
    }
    
}

Comblack_Jobs();

function Comblack_Jobs() {
    return Comblack_Jobs::get_instance();
}

register_activation_hook( __FILE__, array('Comblack_Jobs', 'activate_plugin'));
register_deactivation_hook( __FILE__, array('Comblack_Jobs', 'deactivate_plugin'));
