<?php

/**
 * This file registers the Testimonials custom post type
 *
 * @package    	Ishop_Toolbox
 * @link        http://ishop.com
 * Author:      ishop
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


// Register the Testimonials custom post type
function ishop_toolbox_register_testimonials() {

	$slug = apply_filters( 'ishop_testimonials_rewrite_slug', 'testimonials' );	

	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post Type General Name', 'ishop_toolbox' ),
		'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'ishop_toolbox' ),
		'menu_name'             => __( 'Testimonials', 'ishop_toolbox' ),
		'name_admin_bar'        => __( 'Testimonials', 'ishop_toolbox' ),
		'archives'              => __( 'Item Archives', 'ishop_toolbox' ),
		'parent_item_colon'     => __( 'Parent Item:', 'ishop_toolbox' ),
		'all_items'             => __( 'All Testimonials', 'ishop_toolbox' ),
		'add_new_item'          => __( 'Add New Testimonial', 'ishop_toolbox' ),
		'add_new'               => __( 'Add New Testimonial', 'ishop_toolbox' ),
		'new_item'              => __( 'New Testimonial', 'ishop_toolbox' ),
		'edit_item'             => __( 'Edit Testimonial', 'ishop_toolbox' ),
		'update_item'           => __( 'Update Testimonial', 'ishop_toolbox' ),
		'view_item'             => __( 'View Testimonial', 'ishop_toolbox' ),
		'search_items'          => __( 'Search Testimonial', 'ishop_toolbox' ),
		'not_found'             => __( 'Not found', 'ishop_toolbox' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'ishop_toolbox' ),
		'featured_image'        => __( 'Featured Image', 'ishop_toolbox' ),
		'set_featured_image'    => __( 'Set featured image', 'ishop_toolbox' ),
		'remove_featured_image' => __( 'Remove featured image', 'ishop_toolbox' ),
		'use_featured_image'    => __( 'Use as featured image', 'ishop_toolbox' ),
		'insert_into_item'      => __( 'Insert into item', 'ishop_toolbox' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'ishop_toolbox' ),
		'items_list'            => __( 'Items list', 'ishop_toolbox' ),
		'items_list_navigation' => __( 'Items list navigation', 'ishop_toolbox' ),
		'filter_items_list'     => __( 'Filter items list', 'ishop_toolbox' ),
	);
	$args = array(
		'label'                 => __( 'Testimonial', 'ishop_toolbox' ),
		'description'           => __( 'A post type for your testimonials', 'ishop_toolbox' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'taxonomies'            => array( 'category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 26,
		'menu_icon'             => 'dashicons-heart',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite' 				=> array( 'slug' => $slug ),
	);
	register_post_type( 'testimonials', $args );

}
add_action( 'init', 'ishop_toolbox_register_testimonials', 0 );