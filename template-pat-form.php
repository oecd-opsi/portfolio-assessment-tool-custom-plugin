<?php
/*
Template Name: Portfolio Assessment Tool form
Template Post Type: page
*/

acf_form_head();
get_header();

global $post, $bp;

// Check edit parameter in URL
if ( isset( $_GET['edit'] ) && intval( $_GET['edit'] ) > 0 && !can_edit_acf_form( intval( $_GET['edit'] ) ) ) {
	?>
	<div class="col-sm-12">
		<div class="alert alert-warning text-center">
			<h3><?php echo __( 'Sorry, you cannot edit a questionnaire that was submitted by someone else or a questionnaire that has already been published. If you need to make changes to a published questionnaire, please contact the OPSI team at', 'opsi' ); ?> <a href="mailto:opsi@oecd.org">opsi@oecd.org</a></h3>
		</div>
		<?php // TODO: edit this message, probably no need to say that user can edit contacting the staff, but more useful to say that user can submit a new questionnaire ?>

		<br />
		<a href="<?php echo $bp->loggedin_user->domain . 'innovations/'; ?>" title="<?php echo __( 'Back', 'opsi' ); ?>" class="button btn btn-default flipicon">
          <i class="fa fa-chevron-left" aria-hidden="true"></i>  <?php echo __( 'Back', 'opsi' ); ?>
		</a>
		<?php // TODO: send user to their PAT forms list ?>

	</div>
	<?php
	get_footer();
	return;
}

$has_sidebar = 0;
$layout      = get_post_meta( $post->ID, 'layout', true );
if ( $layout != 'fullpage' && is_active_sidebar( 'sidebar' ) ) {
	$has_sidebar = 3;
}

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
	$post_status = get_post_status_object( get_post_status( $_GET['edit'] ) );
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
	</div>
	
	<?php
	// if ( is_active_sidebar( 'sidebar_covid_response_form' ) ) {
	// 	dynamic_sidebar( 'sidebar_covid_response_form' );
	// }
	?>
</div>

<div class="col-sm-9 dont-col-sm-pull--3">

	<?php while ( have_posts() ) : the_post();
		$postid = get_the_ID(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div id="formtop"></div>
			<div id="pat-form" class="stepform">
				<?php

				$group = get_page_by_title( 'Portfolio Assessment Tool', OBJECT, 'acf-field-group' );

				$form_params = array(
					'id'                 => 'portfolio-assessment-tool-form',
					'field_groups'       => array( $group->ID ),
					'new_post'           => array(
						'post_type'    => 'pat_submission',
						'post_status'  => 'draft',
						'post_author'  => get_current_user_id(),
						'post_content' => true,
						'post_title'   => true,
					),
					'submit_value'       => __( 'Create a new Portfolio Assessment Tool submission', 'opsi' ),
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
					$form_params['submit_value'] 	= __( 'Save your Portfolio Assessment Tool questionnaire', 'opsi' );

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
