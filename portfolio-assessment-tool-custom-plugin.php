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

	// Load Lato Black font
	wp_enqueue_style( 'google-font',  'https://fonts.googleapis.com/css2?family=Lato:ital,wght@1,900&display=swap' );

	// Loads jQuery UI sortable
	wp_enqueue_script( 'jquery-ui-sortable' );

	// loads a CSS file in the head.
	wp_enqueue_style( 'bs-style', plugin_dir_url( __FILE__ ) . 'assets/css/bs-style.css', array(), filemtime(get_stylesheet_directory() . 'assets/css/bs-style.css') );

	// loads JS files in the footer.
	wp_enqueue_script( 'bs-script', plugin_dir_url( __FILE__ ) . 'assets/js/bs-script.js', array( 'jquery', 'jquery-ui-sortable', 'sticky-sidebar'), filemtime(get_stylesheet_directory() . 'assets/js/bs-script.js'), true );

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

	if ( isset( $_POST['csf_action'] ) && $_POST['csf_action'] == 'submit' ) {
		wp_redirect( get_permalink($post_id), 301);
		exit;
	}

}
add_action('acf/save_post', 'opsi_acf_save_post_pat', 11);

// Redirect to the proper page after PAT form submission
function pat_redirect_acf_submit_form( $form, $post_id ) {

	if ( 'portfolio-assessment-tool-form' !== $form['id'] ) {
		return;
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

// Add Portfolio Management Tool profile tab
function profile_tab_pat() {
  global $bp;

	$user_id = bp_displayed_user_id();
	$current_user_id = bp_loggedin_user_id();

	$count_args_owner = array(
		'post_type' => array ( 'pat_submission' ),
		'post_status' => array( 'any', 'draft', 'publish' ),
	);
	$count_args_guest = array(
		'post_type' => array ( 'pat_submission' ),
		'post_status' => array( 'publish' ),
	);

	$all_posts = nitro_get_user_posts_count( $user_id, $count_args_owner );
	$published_posts = nitro_get_user_posts_count( $user_id, $count_args_guest );

	$count_results = 0;

	if ( $user_id == $current_user_id ) {
		$count_results = $all_posts;
	} else {
		$count_results = $published_posts;
	}

	$results_n = '';

	if ( $count_results == 0 ) {
		$results_n = ' <span class="no-count">'. $count_results .'</span>';
	} else {
		$results_n = ' <span class="count">'. $count_results .'</span>';
	}

  bp_core_new_nav_item( array(
    'name' => __( 'Portfolio Management Tool', 'opsi' ).$results_n,
    'slug' => 'pat',
    'screen_function' => 'bs_pat_screen',
    'position' => 80,
    'parent_url'      => bp_loggedin_user_domain() . '/pat-results/',
    'parent_slug'     => $bp->profile->slug,
    'default_subnav_slug' => 'pat-results'
  ) );
}
add_action( 'bp_setup_nav', 'profile_tab_pat' );

function bs_pat_screen(){
    global $bp;
    add_action( 'bp_template_content', 'bp_my_pat_screen_content' );
    bp_core_load_template( array ( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) ) );
}

function bp_my_pat_screen_content() {
  global $bp;

	/**
	 * Fires before the display of the member activity post form.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_member_activity_post_form' ); ?>

	<?php
	if ( is_user_logged_in() && bp_is_my_profile() && ( !bp_current_action() || bp_is_current_action( 'just-me' ) ) ) {
		bp_get_template_part( 'activity/post-form' );
	}

	/**
	 * Fires after the display of the member activity post form.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_member_activity_post_form' );

  echo bp_get_author_pat_list();

}

function bp_get_author_pat_list( $user_id = 0 ) {

	if ($user_id == 0) {
    $user_id = bp_displayed_user_id();
  }
  if (!$user_id) {
    return false;
  }

  $current_user_id = bp_loggedin_user_id();

	return bp_pat_list();

}

function bp_pat_list() {

	// WP_Query arguments
	$args = array(
		'post_type'		=> array( 'pat_submission' ),
		'post_status'	=> array( 'any', 'draft', 'publish' ),
		'author'		=> bp_loggedin_user_id(),
		'posts_per_page'=> -1
	);

	// The Query
	$query = new WP_Query( $args );

	$output = '';

	ob_start();

	// The Loop
	if ( $query->have_posts() ) {

		?>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<th><?php echo __( 'Title', 'opsi' ); ?></th>
					<th><?php echo __( 'Status', 'opsi' ); ?></th>
					<th class="text-center"><?php echo __( 'Actions', 'opsi' ); ?></th>
				</thead>
				<tbody>

		<?php

		while ( $query->have_posts() ) {
			$query->the_post();

			// get assigned users
			$post_status_obj = get_post_status_object( get_post_status( get_the_ID() ) );
			?>

			<tr>
				<td>
					<?php
						if ( get_post_status( get_the_ID() ) == 'publish' ) {
							$post_url = get_permalink();
						} else {
							$post_url = site_url( '/portfolio-assessment-tool-form/?edit=' . get_the_ID() );
						}
					?>
					<a href="<?php echo $post_url ?>" title="<?php echo __( 'view', 'opsi' ); ?>">
						<?php the_title(); ?>
					</a>
				</td>
				<td>
					<?php
						echo $post_status_obj->label;
					?>
				</td>
				<td>
					<?php
						if ( get_post_status( get_the_ID() ) == 'publish' ) {
							?>
							<a href="<?php echo $post_url ?>" title="<?php echo __( 'view', 'opsi' ); ?>">
								<i class="fa fa-search" aria-hidden="true"></i>
							</a>
							<?php
						}	else {
							?>
							<a href="<?php echo $post_url ?>" title="<?php echo __( 'edit', 'opsi' ); ?>">
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
							</a>
							<?php
						}
					?>
				</td>

			</tr>

			<?php

		}

		?>
				</tbody>
			</table>
		</div>
		<?php

	} else {

		?>
		<div id="message" class="info">
			<p><?php echo __( 'Sorry, there was no entries found.', 'opsi' ); ?></p>
		</div>
		<?php
	}

	// Restore original Post Data
	wp_reset_postdata();

	$out = ob_get_clean();

	return $out;

}
