<?php
/*
Plugin Name: Plugin to create Testimonial Custom Post Type
Description: Create Testimonial Custom Post Type And Meta Boxes
Version: 0.1
Author: Angie Vale
Author URI: http://www.purplebabyhippo.co.uk
License: GPL v2 or higher
License URI: License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

//* Create testimonial custom post type
add_action( 'init', 'minimum_testimonial_post_type' );
function minimum_testimonial_post_type() {

	register_post_type( 'testimonials',
		array(
			'labels' => array(
				'name'          => __( 'Testimonials', 'minimum' ),
				'singular_name' => __( 'Testimonial', 'minimum' ),
				'new_item' => __( 'New Testimonial', 'minimum' ),
				'add_new_item' => __( 'Add New Testimonial', 'minimum' ),
			),
			
			'exclude_from_search' => true,
			'has_archive'         => true,
			'hierarchical'        => true,
			'menu_icon'           => 'dashicons-admin-page',
			'public'              => true,
			'rewrite'             => array( 'slug' => 'testimonials', 'with_front' => false ),
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo','genesis-cpt-archives-settings'  ),
		)
	);
	
}


// Register Custom Taxonomies
function my_taxonomies_testimonial() {
	$labels = array(
		'name'              => _x( 'Testimonal Types', 'taxonomy general name' ),
		'singular_name'     => _x( 'Testimonal Type', 'taxonomy singular name' ),
		'add_new_item'      => __( 'Add New Testimonial Type' ),
		'new_item_name'     => __( 'New Testimonial Type' ),
		'menu_name'         => __( 'Testimonal Types' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'testimonial_category', 'testimonials', $args );
}
add_action( 'init', 'my_taxonomies_testimonial', 0 );




//Initialize the metabox class

function pds_initialize_cmb_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once(plugin_dir_path( __FILE__ ) . 'init.php');
}

add_action( 'init', 'pds_initialize_cmb_meta_boxes', 9999 );

//Add Meta Boxes

function pds_custom_metaboxes( $meta_boxes ) {
	$prefix = '_pds_'; // Prefix for all fields

	$meta_boxes[] = array(
		'id' => 'client_metabox',
		'title' => 'Client Details',
		'pages' => array('testimonials'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Client Name',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'client_name',
				'type' => 'text'
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'pds_custom_metaboxes' );

//Customise custom post columns

add_filter('manage_testimonials_posts_columns', 'pds_testimonial_table_head');
function pds_testimonial_table_head( $defaults ) {
    $defaults['title']  = _x('Testimonal Title', 'column name');
    $defaults['description']    = 'Description';
    $defaults['client_name']   = 'Client Name';
    return $defaults;
}


add_action('manage_testimonials_posts_custom_column', 'manage_testimonial_columns', 10, 2);
 
function manage_testimonial_columns($column_name, $id) {
    global $wpdb;
    switch ($column_name) {
    case 'description':
    $description = get_the_excerpt();
        echo $description;
            break;
 
    case 'client_name':
	$name = genesis_get_custom_field('_pds_client_name');
	echo $name;
        break;
    	default:
        break;
    } // end switch
}   


function remove_testimonial_post_columns($columns) {
  // Remove the author column
  	unset($columns['author'] );
	return $columns;
}
add_action( 'manage_testimonials_posts_columns', 'remove_testimonial_post_columns' );