<?php
/**
 * Plugin Name:     Comblack Dedicated General Plugin
 * Plugin URI:      https://jax.co.il
 * Description:     For general functionality and logic.
 * Author:          Oded Shimoni
 * Author URI:      https://jax.co.il
 * Text Domain:     jax-comblack-general
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package Jax_Comblack_General
 */

require __DIR__ .'/vendor/autoload.php';

define('CLIENT_ID', '2148');
define('CLIENT_USERNAME', 'comblackadmin');
define('CLIENT_PASSWORD', 'Comblack3iX5WVZACLKqww9XN');
define('CATEGORIES_PAGE_SLUG', 'job-category');
define('BASE_PLUGIN_DIR', __DIR__);
define('DEBUG', true);

$jobCategories = [];
/**
 * $jobCategories is a global variable of this plugin storing all job categories.
 * Used when calling for a category query.
 * If there isn't any data stored,
 * the API will be called and the data will be stored.
 */

add_action(
    'wp_enqueue_scripts', function () {
        wp_enqueue_script(
            'my_custom_script', plugin_dir_url(__FILE__) . 'assets/js/accordion.js'
        );
        wp_enqueue_style(
            'style-name', plugin_dir_url(__FILE__) . 'assets/css/accordion.css'
        );
    }
);

add_action(
    'wp_enqueue_scripts', function () {
        wp_enqueue_script(
            'form-manipulation', plugin_dir_url(__FILE__) . 'assets/js/elementorFormManipulation.js'
        );
    }
);

require_once __DIR__ . '/public/shortcodes/print_jobs.php';
require_once __DIR__ . '/public/shortcodes/print_jobs_by_category.php';
require_once __DIR__ . '/public/shortcodes/print_jobs_by_search.php';
require_once __DIR__ . '/public/shortcodes/job_categories.php';
require_once __DIR__ . '/public/partials/search_field.php';
require_once __DIR__ . '/api.php';



/* Manual ajax attempt */
add_action("wp_ajax_cb_user_apply", "cb_user_apply");
add_action("wp_ajax_nopriv_cb_user_apply", "cb_user_apply");

function cb_user_apply() {
    $app_content = '';
    $app_content .= 'מספר המשרה: '.intval($_REQUEST['job']);
    $insert = wp_insert_post([
        'post_title' => $_REQUEST['email'],
        'post_type' => 'job-applications',
        'meta_input' => [
            'cv' => 'test'
        ],
        'post_status' => 'pending',
        'post_content' => $app_content
    ]);
    header("Content-Type: application/json");

    $result = [
        'success' => (!$insert ? false : true)
    ];
    echo json_encode($result);
    die();

}

add_action( 'init', 'my_script_enqueuer' );

function my_script_enqueuer() {
   wp_register_script( "my_user_apply", plugin_dir_url(__FILE__) . 'assets/js/makeJobApplication.js', array('jquery') );
   wp_localize_script( 'my_user_apply', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'my_user_apply' );

}

/**
 * Class Elementor_Form_Email_Attachments
 *
 * Send Elementor Form upload field as attachments to email
 */
class Elementor_Form_Email_Attachments {
	// Set to true if you want the files to be removed from
	// the server after they are sent by email
	const DELETE_ATTACHMENT_FROM_SERVER = false;
	public $attachments_array = [];

	public function __construct() {
		add_action( 'elementor_pro/forms/process', [ $this, 'init_form_email_attachments' ], 11, 2 );
	}

	/**
	 * @param \ElementorPro\Modules\Forms\Classes\Form_Record $record
	 * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
	 */
	public function init_form_email_attachments( $record, $ajax_handler ) {
		// check if we have attachments
		$files = $record->get( 'files' );
		if ( empty( $files ) ) {
			return;
		}
		// Store attachment in local var
		foreach ( $files as $id => $files_array ) {
			$this->attachments_array[] = $files_array['path'][0];
		}

		// if local var has attachments setup filter hook
		if ( 0 < count( $this->attachments_array ) ) {
			add_filter( 'wp_mail', [ $this, 'wp_mail' ] );
			add_action( 'elementor_pro/forms/new_record', [ $this, 'remove_wp_mail_filter' ], 5 );
		}
	}

	public function remove_wp_mail_filter() {
		if ( self::DELETE_ATTACHMENT_FROM_SERVER ) {
			foreach ( $this->attachments_array as $uploaded_file ) {
				unlink( $uploaded_file );
			}
		}

		$this->attachments_array = [];
		remove_filter( 'wp_mail', [ $this, 'wp_mail' ] );
	}

	public function wp_mail( $args ) {
		$args['attachments'] = $this->attachments_array;
		return $args;
	}
}
new Elementor_Form_Email_Attachments();


// delete - temp
add_shortcode('tests_new_api', function() {
    $res = wp_remote_post('https://services.adamtotal.co.il/api/Career/GetOrdersDetails', [
        'headers'     => array('Content-Type' => 'application/json'),
        'body'        => [
            'token' => json_encode('26718e14-53e8-483c-a95f-f1a3d3b5be8f')
        ],
    ]);
    return print_r($res, true);
});


