<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  Careerist
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Clear Database stored data
$books = get_posts( array( 'post_type' => 'careers', 'numberposts' => -1 ) );

foreach( $books as $book ) {
	wp_delete_post( $book->ID, true );
}

// Access the database via SQL
global $wpdb;
$wpdb->query( "DELETE FROM {$wpdb->prefix}posts WHERE post_type = 'book'" );
$wpdb->query( "DELETE FROM {$wpdb->prefix}postmeta WHERE post_id NOT IN (SELECT id FROM {$wpdb->prefix}posts)" );
$wpdb->query( "DELETE FROM {$wpdb->prefix}term_relationships WHERE object_id NOT IN (SELECT id FROM {$wpdb->prefix}posts)" );
