<?php
/*
Plugin Name:	Black Studio for OECD OPSI Portfolio Assessment Tool
Plugin URI:		https://oecd-opsi.org
Description:	Custom functions.
Version:		1.0.0
Author:			Black Studio
Author URI:		https://www.blackstudio.it
License:		GPL-2.0+
License URI:	http://www.gnu.org/licenses/gpl-2.0.txt

This plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with This plugin. If not, see {URI to Plugin License}.
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'wp_enqueue_scripts', 'bs_enqueue_files' );
function bs_enqueue_files() {

	// Loads jQuery UI sortable
	wp_enqueue_script( 'jquery-ui-sortable' );

	// loads a CSS file in the head.
	wp_enqueue_style( 'bs-style', plugin_dir_url( __FILE__ ) . 'assets/css/bs-style.css' );

	// loads JS files in the footer.
	wp_enqueue_script( 'bs-script', plugin_dir_url( __FILE__ ) . 'assets/js/bs-script.js', array( 'jquery', 'jquery-ui-sortable'), filemtime(get_stylesheet_directory() . '/bs/bs-style.css'), true );

}

// Register Portfolio Assessment Tool submission CPT
function pat_submission_post_type() {

	$labels = array(
		'name'                  => _x( 'Portfolio Assessment Tool submissions', 'Post Type General Name', 'opsi' ),
		'singular_name'         => _x( 'Portfolio Assessment Tool submission', 'Post Type Singular Name', 'opsi' ),
		'menu_name'             => __( 'PAT submissions', 'opsi' ),
		'name_admin_bar'        => __( 'PAT submissions', 'opsi' ),
		'archives'              => __( 'PAT submissions', 'opsi' ),
		'attributes'            => __( 'Item Attributes', 'opsi' ),
		'parent_item_colon'     => __( 'Parent Item:', 'opsi' ),
		'all_items'             => __( 'All Items', 'opsi' ),
		'add_new_item'          => __( 'Add New Item', 'opsi' ),
		'add_new'               => __( 'Add New', 'opsi' ),
		'new_item'              => __( 'New Item', 'opsi' ),
		'edit_item'             => __( 'Edit Item', 'opsi' ),
		'update_item'           => __( 'Update Item', 'opsi' ),
		'view_item'             => __( 'View Item', 'opsi' ),
		'view_items'            => __( 'View Items', 'opsi' ),
		'search_items'          => __( 'Search Item', 'opsi' ),
		'not_found'             => __( 'Not found', 'opsi' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'opsi' ),
		'featured_image'        => __( 'Featured Image', 'opsi' ),
		'set_featured_image'    => __( 'Set featured image', 'opsi' ),
		'remove_featured_image' => __( 'Remove featured image', 'opsi' ),
		'use_featured_image'    => __( 'Use as featured image', 'opsi' ),
		'insert_into_item'      => __( 'Insert into item', 'opsi' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'opsi' ),
		'items_list'            => __( 'Items list', 'opsi' ),
		'items_list_navigation' => __( 'Items list navigation', 'opsi' ),
		'filter_items_list'     => __( 'Filter items list', 'opsi' ),
	);
	$args = array(
		'label'                 => __( 'Portfolio Assessment Tool submission', 'opsi' ),
		'description'           => __( 'Portfolio Assessment Tool submission', 'opsi' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'author' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'pat_submission', $args );

}
add_action( 'init', 'pat_submission_post_type', 0 );

// Call ACF fields registration
require_once('pat-acf-fields.php');

// Add PAT form page template
// ref: https://www.wpexplorer.com/wordpress-page-templates-plugin/
function bs_add_page_template ($templates) {
  $templates['template-pat-form.php'] = 'Portfolio Assessment Tool form';
  return $templates;
}
add_filter ('theme_page_templates', 'bs_add_page_template');
function bs_register_project_templates( $atts ) {

	$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

	$templates = wp_get_theme()->get_page_templates();
	if ( empty( $templates ) ) {
		$templates = array();
	}

	wp_cache_delete( $cache_key , 'themes');

	$templates['template-pat-form.php'] = 'Portfolio Assessment Tool form';

	wp_cache_add( $cache_key, $templates, 'themes', 1800 );

	return $atts;

}
add_filter( 'wp_insert_post_data', 'bs_register_project_templates' ) ;
function bs_view_project_template( $template ) {

	global $post;

	if ( ! $post ) {
		return $template;
	}

	$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
	$file = plugin_dir_path( __FILE__ ) . $page_template;

	if ( file_exists( $file ) && $page_template ) {
		return $file;
	}

	return $template;

}
add_filter( 'template_include', 'bs_view_project_template' );

// manipulate the PAT submission AFTER it has been saved
function opsi_acf_save_post_pat( $post_id ) {

	if ( get_post_type( $post_id ) != 'pat_submission' ) {
		return;
	}

	$content = array(
		'ID' => $post_id,
		'post_title' => 'Submission of ' . date("Y-m-d") ,
		'post_content' => ''
	);

	if ( isset( $_POST['csf_action'] ) && $_POST['csf_action'] == 'submit' ) {
		$content['post_status'] = 'publish';
	}

	wp_update_post($content);

}
add_action('acf/save_post', 'opsi_acf_save_post_pat', 11);

// Redirect to the proper page after PAT form submission
function pat_redirect_acf_submit_form( $form, $post_id ) {

	if ( 'portfolio-assessment-tool-form' !== $form['id'] ) {
		return;
	}

	if( $_POST['csf_action'] == 'submit' ) {

		// TODO: redirect to the new created post
		// $thankyou_page = get_field( 'case_study_form_thankyou_page_submit', 'option' );
		//
		// wp_safe_redirect( get_the_permalink( $thankyou_page ) );
		// die;
	}

	if( $_POST['csf_action'] == 'save' ) {

		$pat_form_page = $_SERVER['REQUEST_URI'];

		wp_safe_redirect( get_the_permalink( $pat_form_page ).'?edit='.$post_id.'&updated=true' );
		die;
	}

}
add_action('acf/submit_form', 'pat_redirect_acf_submit_form', 10, 2);


// Add a custom template for pat_submission single post
function bs_pat_submission_single_template( $single ) {

  global $post;

  if ( $post->post_type === 'pat_submission' ) {
    if ( file_exists( dirname( __FILE__ ) . '/single-pat_submission.php' ) ) {
      $single = dirname( __FILE__ ) . '/single-pat_submission.php';
    }
  }

  return $single;

}
add_filter( 'single_template', 'bs_pat_submission_single_template', 99 );
