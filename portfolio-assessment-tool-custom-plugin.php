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

	// Loads Waypoints
	wp_enqueue_script( 'waypoint-js', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.waypoints.min.js', array( 'jquery' ), '', true );
	// Loads Waypoints
	wp_enqueue_script( 'waypoint-inview', plugin_dir_url( __FILE__ ) . 'assets/js/inview.min.js', array( 'jquery', 'waypoint-js' ), '', true );

	// loads a CSS file in the head.
	wp_enqueue_style( 'bs-style', plugin_dir_url( __FILE__ ) . 'assets/css/bs-style.css', array(), filemtime(plugin_dir_path( __FILE__ ) . 'assets/css/bs-style.css') );

	// loads JS files in the footer.
	wp_enqueue_script( 'bs-script', plugin_dir_url( __FILE__ ) . 'assets/js/bs-script.js', array( 'jquery', 'jquery-ui-sortable', 'waypoint-js', 'waypoint-inview'), filemtime(plugin_dir_path( __FILE__ ) . 'assets/js/bs-script.js'), true );

	if( is_singular('pat_submission') ) {
		// loads JS files in the footer.
		wp_enqueue_script( 'bs-ajax', plugin_dir_url( __FILE__ ) . 'assets/js/bs-results-ajax.js', array( 'jquery', 'bs-script' ), filemtime(plugin_dir_path( __FILE__ ) . 'assets/js/bs-results-ajax.js'), true );
		wp_localize_script('bs-ajax', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	}

}

// Register Portfolio Assessment Tool submission CPT
function pat_submission_post_type() {

	$labels = array(
		'name'                  => _x( 'Portfolio Assessment Tool submissions', 'Post Type General Name', 'opsi' ),
		'singular_name'         => _x( 'Portfolio Assessment Tool submission', 'Post Type Singular Name', 'opsi' ),
		'menu_name'             => __( 'PET submissions', 'opsi' ),
		'name_admin_bar'        => __( 'PET submissions', 'opsi' ),
		'archives'              => __( 'PET submissions', 'opsi' ),
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
		'rewrite'								=> array( 'slug' => 'pet_submission'),
	);
	register_post_type( 'pat_submission', $args );

	// Register custom status for PAT_submission cpt
	// Draft and Publish are used for module 1
	// Following custom status are created to manage module 2 stati

	register_post_status( 'draft_module2', array(
		'label'                     => _x( 'Draft of Module 2', 'opsi' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Draft of Module 2 <span class="count">(%s)</span>', 'Draft of Module 2 <span class="count">(%s)</span>' ),
	) );

	register_post_status( 'publish_module2', array(
		'label'                     => _x( 'Published with Module 2', 'opsi' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Published with Module 2 <span class="count">(%s)</span>', 'Published with Module 2 <span class="count">(%s)</span>' ),
	) );

}
add_action( 'init', 'pat_submission_post_type', 0 );

add_action( 'admin_footer-post-new.php', 'opsi_pat_append_post_status_list' );
add_action( 'admin_footer-post.php', 'opsi_pat_append_post_status_list' );
function opsi_pat_append_post_status_list() {
	global $post;
	$complete = '';
	$label    = '';
	if ( $post->post_type == 'pat_submission' ) {

		$complete = '';
		if ( $post->post_status == 'draft_module2' ) {
			$complete = ' selected=\'selected\'';
			$label    = '<span id="post-status-display"> ' . __( 'Draft of Module 2', 'opsi' ) . '</span>';
		}
		echo '
		  <script>
		  jQuery(document).ready(function($){
			   $("select#post_status").append("<option value=\'draft_module2\' ' . $complete . '>' . __( 'Draft of Module 2', 'opsi' ) . '</option>");
			   $(".misc-pub-section label").append("' . $label . '");
		  });
		  </script>
		  ';

		$complete = '';
		if ( $post->post_status == 'publish_module2' ) {
			$complete = ' selected=\'selected\'';
			$label    = '<span id="post-status-display"> ' . __( 'Published with Module 2', 'opsi' ) . '</span>';
		}
		echo '
		  <script>
		  jQuery(document).ready(function($){
			   $("select#post_status").append("<option value=\'publish_module2\' ' . $complete . '>' . __( 'Published with Module 2', 'opsi' ) . '</option>");
			   $(".misc-pub-section label").append("' . $label . '");
		  });
		  </script>
		  ';

	}
}

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
		'post_title' => 'Portfolio Snapshot on ' . date("Y-m-d") ,
		'post_content' => ''
	);

	$post_status = get_post_status_object( get_post_status( $post_id ) );
	$status_slug = $post_status->name;
	if( $status_slug == 'draft_module2' || $status_slug == 'publish' ) {
		$content['post_status'] = 'draft_module2';
	}

	if ( isset( $_POST['csf_action'] ) && $_POST['csf_action'] == 'submit' ) {
		if( $status_slug == 'draft_module2' ) {
			$content['post_status'] = 'publish_module2';
		} else {
			$content['post_status'] = 'publish';
		}
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

// Add Portfolio Exploration profile tab
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
    'name' => __( 'Portfolio Explorations', 'opsi' ).$results_n,
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
					<th><?php echo __( 'Organisation', 'opsi' ); ?></th>
					<th><?php echo __( 'Status', 'opsi' ); ?></th>
					<th class="text-center" colspan="4"><?php echo __( 'Actions', 'opsi' ); ?></th>
				</thead>
				<tbody>

		<?php

		while ( $query->have_posts() ) {
			$query->the_post();

			// get assigned users
			$post_status_obj = get_post_status_object( get_post_status( get_the_ID() ) );

			$edit_url = site_url( '/portfolio-exploration/?edit=' . get_the_ID() );
			$post_url = get_permalink();
			$organisation_name = get_field('general_questions')['organisation'];
			?>

			<tr>
				<td>
					<?php
						if ( get_post_status( get_the_ID() ) == 'draft' ) {
							?>
							<a href="<?php echo $edit_url ?>" title="<?php echo __( 'view', 'opsi' ); ?>"><?php the_title(); ?></a>
							<?php
						} else {
							?>
							<a href="<?php echo $post_url ?>" title="<?php echo __( 'view', 'opsi' ); ?>"><?php the_title(); ?></a>
							<?php
						}
					?>
				</td>
				<td><?php echo $organisation_name ?></td>
				<td>
					<?php
					if ( $post_status_obj->label == 'Published' ) {
						echo 'Module 1 Complete';
					} elseif ( $post_status_obj->label == 'Draft' ) {
						echo 'Module 1 Draft';
					} else {
						echo $post_status_obj->label;
					}
					?>
				</td>
				<td>
					<?php
						if ( $post_status_obj->label == 'draft' ) {
							?>
							<a href="<?php echo $edit_url ?>" title="<?php echo __( 'edit', 'opsi' ); ?>">
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
							</a>
							<?php
						}	else {
							?>
							<a href="<?php echo $post_url ?>" title="<?php echo __( 'view', 'opsi' ); ?>">
								<i class="fa fa-search" aria-hidden="true"></i>
							</a>
							<?php
						}
					?>
				</td>
				<td>
					<?php
						if ( get_post_status( get_the_ID() ) != 'draft' ) { ?>
						<a href="/wp-content/plugins/portfolio-assessment-tool-custom-plugin/pat-results-csv-dl.php?pat_author=<?php echo get_the_author_meta( 'ID' ) ?>&pat_result_id=<?php echo get_the_ID() ?>" title="<?php echo __( 'csv', 'opsi' ); ?>">
							<i class="fa fa-table" aria-hidden="true"></i>
						</a>
					<?php } ?>
				</td>
				<td>
					<?php
					if ( get_post_status( get_the_ID() ) != 'draft' ) { ?>
						<a href="<?php echo $post_url ?>?output=pdf" title="<?php echo __( 'pdf', 'opsi' ); ?>" target="_blank">
							<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
						</a>
					<?php } ?>
				</td>
				<td>
					<?php
					if ( $post_status_obj->name == 'publish' || $post_status_obj->name == 'draft_module2' ) { ?>
						<a href="<?php echo $edit_url ?>#pat-step-10" title="<?php echo __( 'Continue to Module 2', 'opsi' ); ?>">
							<i class="fa fa-caret-square-o-right" aria-hidden="true"></i>
						</a>
					<?php } ?>
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

// Add PAT options page
if( function_exists('acf_add_options_page') ) {

  acf_add_options_sub_page(array(
    'page_title'     => 'PAT options',
    'menu_title'    => 'PAT options',
    'parent_slug'    => 'edit.php?post_type=pat_submission',
  ));

}

// Call PAT options ACF fields registration
require_once('pat-options-acf-fields.php');

// Landing page content
function bs_landing_page_content ( $field ) {

	$landing_page_content = get_field( 'landing_page_content', 'option' );

	if ( !is_admin() && !empty( $landing_page_content ) ) {
		$field['message'] 	= $landing_page_content;
	}

	return $field;
}
add_filter( 'acf/load_field/key=field_5f18466d9460b', 'bs_landing_page_content' );

// Navigation page content for Module 1
function bs_navigation_page_content_module_one ( $field ) {

	$navigation_page_content = get_field( 'navigation_page_content', 'option' );

	if ( !is_admin() && !empty( $navigation_page_content ) ) {
		$field['message'] 	= $navigation_page_content;
	}

	return $field;
}
add_filter( 'acf/load_field/key=field_5f0dc4946fd8f', 'bs_navigation_page_content_module_one' );

// Start page for Module 1
function bs_start_page_content_module_one ( $field ) {

	$start_page_content = get_field( 'start_module_1_text', 'option' );

	if ( !is_admin() && !empty( $start_page_content ) ) {
		$field['message'] 	= $start_page_content;
	}

	return $field;
}
add_filter( 'acf/load_field/key=field_5f1319b50547d', 'bs_start_page_content_module_one' );

// Start page for Module 2
function bs_start_page_content_module_two ( $field ) {

	$start_page_content = get_field( 'start_module_2_text', 'option' );

	if ( !is_admin() && !empty( $start_page_content ) ) {
		$field['message'] 	= $start_page_content;
	}

	return $field;
}
add_filter( 'acf/load_field/key=field_5f34dab33fac9', 'bs_start_page_content_module_two' );


// Autopopulate Submission date field on Portfolio Assessment Tool submission
add_action( 'draft_to_publish', 'bs_pat_submission_date' );
function bs_pat_submission_date( $post ) {

	// check if post is a Case Study
	if ( ! 'pat_submission' == $post->post_type ) {
		return;
	}

	// get current date and populate Submission field
	$now = date( 'd/m/Y' );
	update_field( 'submission_date', $now, $post->ID );

}

// force login for case study form
add_action( 'template_redirect', 'bs_pat_form_template_redirect' );
function bs_pat_form_template_redirect() {
	if ( is_page( 'portfolio-exploration' ) && ! is_user_logged_in() ) {
		wp_redirect( wp_login_url( get_permalink( get_page_by_path( 'portfolio-exploration' ) ) ) );
		die;
	}
}

// Helper function: transform hsl to hex color
function ColorHSLToRGB($h, $s, $l){

	$h /= 360;
  $s /= 100;
  $l /= 100;

  $r = $l;
  $g = $l;
  $b = $l;
  $v = ($l <= 0.5) ? ($l * (1.0 + $s)) : ($l + $s - $l * $s);
  if ($v > 0){
    $m;
    $sv;
    $sextant;
    $fract;
    $vsf;
    $mid1;
    $mid2;

    $m = $l + $l - $v;
    $sv = ($v - $m ) / $v;
    $h *= 6.0;
    $sextant = floor($h);
    $fract = $h - $sextant;
    $vsf = $v * $sv * $fract;
    $mid1 = $m + $vsf;
    $mid2 = $v - $vsf;

    switch ($sextant)
    {
      case 0:
        $r = $v;
        $g = $mid1;
        $b = $m;
        break;
      case 1:
        $r = $mid2;
        $g = $v;
        $b = $m;
        break;
      case 2:
        $r = $m;
        $g = $v;
        $b = $mid1;
        break;
      case 3:
        $r = $m;
        $g = $mid2;
        $b = $v;
        break;
      case 4:
        $r = $mid1;
        $g = $m;
        $b = $v;
        break;
      case 5:
        $r = $v;
        $g = $m;
        $b = $mid2;
        break;
    }
  }
  // return array('r' => $r * 255.0, 'g' => $g * 255.0, 'b' => $b * 255.0);
	$r = round($r * 255, 0);
  $g = round($g * 255, 0);
  $b = round($b * 255, 0);

  $r = ($r < 15)? '0' . dechex($r) : dechex($r);
  $g = ($g < 15)? '0' . dechex($g) : dechex($g);
  $b = ($b < 15)? '0' . dechex($b) : dechex($b);
	return "#$r$g$b";
}

// Call Calculate score helper functions
require_once('pat-calculate-score.php');

// Helper function to know if the user can edit the PAT form
function can_edit_pat_form(
	$post_id = 0,
	$user_id = 0,
	$allowed_statuses = array(
												'draft',
												'publish',
												'draft_module2'
											)
	) {

	if ( intval( $user_id ) == 0 && get_current_user_id() > 0 ) {
		$user_id = get_current_user_id();
	}

	if ( intval( $post_id ) == 0 ) {
		global $post;

		if ( ! empty( $post ) ) {
			$post_id = $post->ID;
		}
	}


	if ( intval( $post_id ) > 0 && intval( $user_id ) > 0 ) {

		$post_author = get_post_field( 'post_author', $post_id );
		$post_status = get_post_field( 'post_status', $post_id );

		if ( intval( $post_author ) == $user_id && ( in_array( $post_status, $allowed_statuses ) || $allowed_statuses[0] == 'any' ) ) {
			return true;
		}

	}

	return false;
}

// Ajax call to handle the Start again button functonality
add_action("wp_ajax_start_again", "start_again_func");
add_action("wp_ajax_nopriv_start_again", "start_again_func");
function start_again_func() {

	$post_id = $_REQUEST["post_id"];

	if( function_exists('duplicate_post_create_duplicate') ) {
		$post_obj = get_post($post_id);
		$new_post_id = duplicate_post_create_duplicate( $post_obj, 'draft' );
		if( $new_post_id > 0 ) {
			$result['type'] = "success";
      $result['new_id'] = $new_post_id;
		} else {
			$result['type'] = "error";
      $result['new_id'] = 'Something went wrong with duplication';
		}
	} else {
		$result['type'] = "error";
		$result['new_id'] = 'Something went wrong with duplication. Is Duplicate posts installed?';
	}

	$result = json_encode($result);
	echo $result;

	die();
}

// Delete images file from tempo directory after generating a PDF
function pat_pdf_remove_temp_file( $mpdf, $pdf_filename ) {
	$upload_dir = wp_upload_dir();
	$files = glob($upload_dir['basedir'].'/pat-temp/*');
	foreach($files as $file){
	  if(is_file($file)) {
			unlink($file);
		}
	}
}
add_action( 'mpdf_output', 'pat_pdf_remove_temp_file', 10, 2 );

// Set PDF format for results export
function bs_set_pdf_format_mpdf() {
	global $pdf_format;
	$pdf_format = 'A4-L';
}
add_action( 'init', 'bs_set_pdf_format_mpdf' );

// Add menu item for CSV export (all items)
function add_csv_export_menu_item() {
	global $submenu;
  // $page_title, $menu_title, $capability, $menu_slug, $callback_function
  // add_posts_page(__('CSV Export'), __('CSV Export'), 'manage_options', 'https://staging.oecd-opsi.org/wp-content/plugins/portfolio-assessment-tool-custom-plugin/pat-results-csv-dl.php');
	$submenu['edit.php?post_type=pat_submission'][] = array( 'CSV Export', 'manage_options', 'https://staging.oecd-opsi.org/wp-content/plugins/portfolio-assessment-tool-custom-plugin/pat-results-csv-dl.php');
}
add_action('admin_menu', 'add_csv_export_menu_item');
// add_submenu_page( 'edit.php?post_type=pat_submission', __('CSV Export'), __('CSV Export'), 'manage_options', 'pat_csv_export', )
