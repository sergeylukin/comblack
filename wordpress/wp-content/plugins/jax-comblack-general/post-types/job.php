<?php

/**
 * Registers the `job` post type.
 */
function job_init() {
	register_post_type( 'job', array(
		'labels'                => array(
			'name'                  => __( 'Jobs', 'jax-comblack-general' ),
			'singular_name'         => __( 'Job', 'jax-comblack-general' ),
			'all_items'             => __( 'All Jobs', 'jax-comblack-general' ),
			'archives'              => __( 'Job Archives', 'jax-comblack-general' ),
			'attributes'            => __( 'Job Attributes', 'jax-comblack-general' ),
			'insert_into_item'      => __( 'Insert into job', 'jax-comblack-general' ),
			'uploaded_to_this_item' => __( 'Uploaded to this job', 'jax-comblack-general' ),
			'featured_image'        => _x( 'Featured Image', 'job', 'jax-comblack-general' ),
			'set_featured_image'    => _x( 'Set featured image', 'job', 'jax-comblack-general' ),
			'remove_featured_image' => _x( 'Remove featured image', 'job', 'jax-comblack-general' ),
			'use_featured_image'    => _x( 'Use as featured image', 'job', 'jax-comblack-general' ),
			'filter_items_list'     => __( 'Filter jobs list', 'jax-comblack-general' ),
			'items_list_navigation' => __( 'Jobs list navigation', 'jax-comblack-general' ),
			'items_list'            => __( 'Jobs list', 'jax-comblack-general' ),
			'new_item'              => __( 'New Job', 'jax-comblack-general' ),
			'add_new'               => __( 'Add New', 'jax-comblack-general' ),
			'add_new_item'          => __( 'Add New Job', 'jax-comblack-general' ),
			'edit_item'             => __( 'Edit Job', 'jax-comblack-general' ),
			'view_item'             => __( 'View Job', 'jax-comblack-general' ),
			'view_items'            => __( 'View Jobs', 'jax-comblack-general' ),
			'search_items'          => __( 'Search jobs', 'jax-comblack-general' ),
			'not_found'             => __( 'No jobs found', 'jax-comblack-general' ),
			'not_found_in_trash'    => __( 'No jobs found in trash', 'jax-comblack-general' ),
			'parent_item_colon'     => __( 'Parent Job:', 'jax-comblack-general' ),
			'menu_name'             => __( 'Jobs', 'jax-comblack-general' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-media-text',
		'show_in_rest'          => true,
		'rest_base'             => 'job',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'job_init' );

/**
 * Sets the post updated messages for the `job` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `job` post type.
 */
function job_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['job'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Job updated. <a target="_blank" href="%s">View job</a>', 'jax-comblack-general' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'jax-comblack-general' ),
		3  => __( 'Custom field deleted.', 'jax-comblack-general' ),
		4  => __( 'Job updated.', 'jax-comblack-general' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Job restored to revision from %s', 'jax-comblack-general' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Job published. <a href="%s">View job</a>', 'jax-comblack-general' ), esc_url( $permalink ) ),
		7  => __( 'Job saved.', 'jax-comblack-general' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Job submitted. <a target="_blank" href="%s">Preview job</a>', 'jax-comblack-general' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Job scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview job</a>', 'jax-comblack-general' ),
		date_i18n( __( 'M j, Y @ G:i', 'jax-comblack-general' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Job draft updated. <a target="_blank" href="%s">Preview job</a>', 'jax-comblack-general' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'job_updated_messages' );
