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
defined( 'ABSPATH' ) or die( 'Hey, this script is expected to be run as part of Wordpress!' );

/**
    * Remove rewrite rules and then recreate rewrite rules.
    * @link https://developer.wordpress.org/reference/functions/flush_rewrite_rules/
    * Should be removed before pushing to live.
 */
flush_rewrite_rules();
add_action( 'after_switch_theme', 'flush_rewrite_rules' );


function alter_query_so_15250127($qry) {
    global $wp;
    $segments = explode('/', $wp->request);
    $category = $segments[1];
    $area = $segments[2];
    if ( $qry->is_main_query() && $segments[0] === 'categories' && $category ) {
        $taxonomies = array();
        if ($category === 'all') {
            $categories = get_terms('categories', [
                        'hide_empty' => false,
                        'fields' => 'ids'
            ]);
            $taxonomies[] = array(
                'taxonomy' => 'categories',
                'field' => 'term_id',
                'terms' => array_merge(array(131), $categories),
            );
            $qry->set('tax_query', $taxonomies);
            $qry->set('categories', null);
            return;
        } else {
            $taxonomies[] = array(
                'taxonomy' => 'categories',
                'field' => 'slug',
                'terms' => $category,
            );
        }
        if ($area) {
            $taxonomies[] =  array(
                'taxonomy' => 'area',
                'field' => 'slug',
                'terms' => $area,
            );
        }
        $qry->set('tax_query', $taxonomies);
    }
}
add_action('pre_get_posts','alter_query_so_15250127');

function category_area_template( $templates = '' ) { 
    global $wp;
    $segments = explode('/', $wp->request);
    $category = get_queried_object(); 
    $current_url = home_url(add_query_arg(array(), $wp->request));
    if ($segments[0] == 'area') $templates =  locate_template('taxonomy-area.php', false);
    if ($segments[0] == 'categories') $templates =  locate_template('taxonomy-categories.php', false);
    return $templates; 
} 
add_filter( 'taxonomy_template', 'category_area_template' );

function wpd_parse_request( $request ){
    $id = get_the_ID();
    Logger::warning('REQUEST ' . $id, [$request]);
}
add_action( 'parse_request', 'wpd_parse_request' );

// add_filter('post_rewrite_rules', '__return_empty_array');
// add_filter('date_rewrite_rules', '__return_empty_array');
// add_filter('comments_rewrite_rules', '__return_empty_array');
// add_filter('search_rewrite_rules', '__return_empty_array');
// add_filter('author_rewrite_rules', '__return_empty_array');
// add_filter('page_rewrite_rules', '__return_empty_array');

function when_rewrite_rules( $wp_rewrite ) {
    $new_rules = array();
    $new_rules['categories/([^/]{2,})/([^/]{2,})/?$'] = '/categories?category=$matches[1]&area=$matches[2]';
    $wp_rewrite->rules = array_merge($wp_rewrite->rules, $new_rules);
}
add_filter('generate_rewrite_rules','when_rewrite_rules');


function redirect_page() { 
     if (isset($_SERVER['HTTPS']) && 
        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || 
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && 
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') { 
        $protocol = 'https://'; 
        } 
        else { 
        $protocol = 'http://'; 
    } 
 
    $currenturl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
    $currenturl_relative = wp_make_link_relative($currenturl); 

    $parts = explode('/', substr($currenturl_relative, 1));
    if ($parts[0] === 'area' && $parts[1] && $parts[2]) {
        $area = $parts[1];
        $category = $parts[2];
        $urlto = home_url("/categories/{$category}/{$area}/"); 
         
        if ($currenturl != $urlto) 
            exit( wp_redirect( $urlto ) ); 
    }
} 
add_action( 'template_redirect', 'redirect_page' ); 


$App = require __DIR__ . '/bootstrap/start.php';

register_activation_hook( __FILE__, array($App['Plugin'], 'activate') );
register_deactivation_hook( __FILE__, array($App['Plugin'], 'deactivate') );

SyncJobController::register();

if (Bench::duration() > 3) {
  Bench::dump2file(Path::logs() . '/slow.log');
}

