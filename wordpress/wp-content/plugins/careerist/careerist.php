<?php
/**
 * @package  CareeristPlugin
 */
/*
Plugin Name: Careerist Plugin
Plugin URI: https://sergeylukin.com/
Description: Jobs platform management software
Version: 1.0.0
Author: Sergey Lukin
Author URI: https://sergeylukin.com/
License: private
Text Domain: careerist-plugin
*/

// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

$App = require __DIR__ . '/bootstrap/start.php';

register_activation_hook( __FILE__, array($App['Plugin'], 'activate') );
register_deactivation_hook( __FILE__, array($App['Plugin'], 'deactivate') );


add_action("wp_ajax_careerist_sync_trigger", "myFunc");

function myFunc() {
    header("Content-Type: application/json");

    $result = [
        'success' => (!$insert ? false : true)
    ];
    echo json_encode($result);
    die();
}

$App->shutdown(function($App) {
  if (Bench::duration() > 3) {
    Bench::dump2file(Path::logs() . '/slow.log');
  }
});
