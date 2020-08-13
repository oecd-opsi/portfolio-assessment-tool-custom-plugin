<?php
/*
Template Name: Portfolio Assessment Tool form
Template Post Type: page
*/

acf_form_head();
get_header();

global $post, $bp;

// Hide Module field based on status
$post_status = get_post_status_object( get_post_status( $_GET['edit'] ) );
$status_slug = $post_status->name;
if( $status_slug == 'draft_module2' ) {
	// Hide module 1
	function bs_pat_form_hide_module_1($field) {
	  return;
	}
	add_filter('acf/prepare_field/key=field_5f18466d9460b', 'bs_pat_form_hide_module_1', 20);
	add_filter('acf/prepare_field/key=field_5ef5dc662a113', 'bs_pat_form_hide_module_1', 20);
	add_filter('acf/prepare_field/key=field_5f0dc4946fd8f', 'bs_pat_form_hide_module_1', 20);
	add_filter('acf/prepare_field/key=field_5f1319b50547d', 'bs_pat_form_hide_module_1', 20);
	add_filter('acf/prepare_field/key=field_5ef5dd3b010b3', 'bs_pat_form_hide_module_1', 20);
	add_filter('acf/prepare_field/key=field_5f0e299dcf875', 'bs_pat_form_hide_module_1', 20);
	add_filter('acf/prepare_field/key=field_5f0e2a35f9ad8', 'bs_pat_form_hide_module_1', 20);
	add_filter('acf/prepare_field/key=field_5f0e2a89b8f93', 'bs_pat_form_hide_module_1', 20);
	add_filter('acf/prepare_field/key=field_5ef9c00aaab62', 'bs_pat_form_hide_module_1', 20);
} else {
	// Hide module 2
	function bs_pat_form_hide_module_2($field) {
	  return;
	}
	add_filter('acf/prepare_field/key=field_5f34dab33fac9', 'bs_pat_form_hide_module_2', 20);
	add_filter('acf/prepare_field/key=field_5f2ba081cdbe3', 'bs_pat_form_hide_module_2', 20);
}

// Check edit parameter in URL
if ( isset( $_GET['edit'] ) && intval( $_GET['edit'] ) > 0 && !can_edit_pat_form( intval( $_GET['edit'] ) ) ) {
	?>
	<div class="col-sm-12">
		<div class="alert alert-warning text-center">
			<h3><?php echo __( 'Sorry, you cannot edit a questionnaire that was submitted by someone else or a questionnaire that has already been published. If you need to make changes to a published questionnaire, please contact the OPSI team at', 'opsi' ); ?> <a href="mailto:opsi@oecd.org">opsi@oecd.org</a></h3>
		</div>
		<?php // TODO: edit this message, probably no need to say that user can edit contacting the staff, but more useful to say that user can submit a new questionnaire ?>

		<br />
		<a href="<?php echo $bp->loggedin_user->domain . 'pat/'; ?>" title="<?php echo __( 'Back', 'opsi' ); ?>" class="button btn btn-default flipicon">
          <i class="fa fa-chevron-left" aria-hidden="true"></i>  <?php echo __( 'Back', 'opsi' ); ?>
		</a>

	</div>
	<?php
	get_footer();
	return;
}

// If user is trying to edit a draft of module 2, redirect to #pat-step-10
if( isset( $_GET['edit'] ) && intval( $_GET['edit'] ) > 0 && $status_slug == 'draft_module2' ) {
	?>
	<script type="text/javascript">
		location.href = "#pat-step-10";
	</script>
	<?php
}

$has_sidebar = 0;

?>

<div class="col-md-12">
	<div class="pat-form-title-wrapper screen-reader-text">
		<h1>Portfolio Assessment Tool Form</h1>
	</div>
	<div class="single_img_wrap pat-form-banner">
		<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/pat-form-hero.jpg" class="attachment-blog size-blog wp-post-image" alt="Portfolio Exploration Tool">
	</div>
</div>

<div id="pat-form-sidebar" class="col-sm-3 dont-col-sm-push--9">
	<ul id="acf_pat_steps">
	</ul>


	<?php
	// Post status
	$status = $post_status->label;
	// Last modified
	$last_save = get_the_modified_date( get_option( 'date_format' ) . ', ' . get_option( 'time_format' ) . ' a', $_GET['edit'] );
	 ?>

	<div class="pat-status-widget">
		<h2>Status</h2>
		<div class="pat-status-meta pat-status-label"><?php echo $status ?></div>
		<div class="pat-status-meta pat-status-last-save"><?php echo $last_save ?></div>
	</div>

	<div class="save-submit-wrapper">
		<button class="button saveform" title="Save">Save</button>
		<button class="button submitform" id="submitcasestudy" title="Submit">Submit</button>
		<span class="acf-spinner"></span>
	</div>

	<?php
	// if ( is_active_sidebar( 'sidebar_covid_response_form' ) ) {
	// 	dynamic_sidebar( 'sidebar_covid_response_form' );
	// }
	?>
</div>

<div class="col-sm-9 dont-col-sm-pull--3 pat-form-main">

	<?php while ( have_posts() ) : the_post();
		$postid = get_the_ID(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div id="formtop"></div>
			<div id="pat-form" class="stepform">
				<?php

				$group = get_page_by_title( 'Portfolio Assessment Tool', OBJECT, 'acf-field-group' );

				$form_params = array(
					'id'                 => 'portfolio-assessment-tool-form',
					'field_groups'       => array( 'group_5f084469b45f2' ),
					'new_post'           => array(
						'post_type'    => 'pat_submission',
						'post_status'  => 'draft',
						'post_author'  => get_current_user_id(),
						'post_content' => true,
						'post_title'   => true,
					),
					'submit_value'       => __( 'Create a new Portfolio Exploration submission', 'opsi' ),
					'post_id'            => 'new_post',
					'form'               => true,
					'uploader'           => 'basic',
					'updated_message'    => '<span class="alert alert-success updatedalert" role="alert">' . __( "Portfolio Assessment Tool submission saved on", 'acf' ) . ' ' . date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) . '</span>',
					//'return' => '',
					'html_before_fields' => '<input type="hidden" id="csf_action" name="csf_action" value="" style="display:none;">',
				);



				if ( isset( $_GET['edit'] ) && intval( $_GET['edit'] ) > 0 ) {

					$form_params['post_id'] 		= $_GET['edit'];
					$form_params['new_post'] 		= false;
					$form_params['submit_value'] 	= __( 'Save your Portfolio Exploration questionnaire', 'opsi' );

				}

				acf_form( $form_params );

				?>
			</div>
		</article>
	<?php endwhile; ?>

	<?php // echo get_options_acf_fields_by_group_key( 'group_597ebdb66a7e1', 'pat_form_example' ); ?>

</div>

<?php wp_reset_query(); ?>

<?php get_footer(); ?>
