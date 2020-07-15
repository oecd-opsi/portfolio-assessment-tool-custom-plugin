<?php get_header();

  global $post;

  $has_sidebar = 0;
	$layout = 'fullpage';

?>

<?php

 ?>


<div class="col-sm-<?php echo 12 - $has_sidebar; ?> <?php echo ($has_sidebar > 0 ? 'col-sm-pull-3' : ''); ?>">

<?php while ( have_posts() ) : the_post(); $postid = get_the_ID();

  //*** Get all needed data ***//
	// echo '<pre>'.print_r(get_field_objects( $postid ), true).'</pre>';
  $fields = get_field_objects( $postid );

  //* Organisation
  $general_questions = get_field('general_questions');
  $organisation = $general_questions['organisation'];

  //* Name
  $name = get_the_author_meta( 'display_name' );

  //* Date
  $submission_date = get_field( 'submission_date' );

  //* Calculate Facet orientation questions score
  // Declare a variable for each facets to store the score
  $enh = 0;
  $mis = 0;
  $ant = 0;
  $ada = 0;
  $max = 64;

  // Get all sub-fields/questions and manage each one based on the type
  // If the question is of type radio or input number,
  // the value is numeric and the facet reference is in the first part of the key.
  // If the question is of type checkbox, the value contain the facet reference and the value.
  // The type of the field can be deduced from the value: if the splitted value length is greater than zero, the field is a checkbox.
  foreach ( $fields['facet_orientation_questions_1']['value'] as $answers ) {
    foreach ( $answers as $key => $value ) {
      $splitted_value = explode( '-', $value );
      if ( count($splitted_value) > 1 ) {
        // here we have a checkbox
        $facets_ref = $splitted_value[0];
        $value = $splitted_value[1];
        $$facets_ref += (float)$value;
      } else {
        // here we have a radio input or number type
        $facets_ref = explode( '_', $key )[0];
        $$facets_ref += (float)$value;
      }
    }
  }
  foreach ( $fields['facet_orientation_questions_2']['value'] as $answers ) {
    foreach ( $answers as $key => $value ) {
      $splitted_value = explode( '-', $value );
      if ( count($splitted_value) > 1 ) {
        // here we have a checkbox
        $facets_ref = $splitted_value[0];
        $value = $splitted_value[1];
        $$facets_ref += (float)$value;
      } else {
        // here we have a radio input or number type
        $facets_ref = explode( '_', $key )[0];
        $$facets_ref += (float)$value;
      }
    }
  }
  foreach ( $fields['facet_orientation_questions_3']['value'] as $answers ) {
    foreach ( $answers as $key => $value ) {
      $splitted_value = explode( '-', $value );
      if ( count($splitted_value) > 1 ) {
        // here we have a checkbox
        $facets_ref = $splitted_value[0];
        $value = $splitted_value[1];
        $$facets_ref += (float)$value;
      } else {
        // here we have a radio input or number type
        $facets_ref = explode( '_', $key )[0];
        $$facets_ref += (float)$value;
      }
    }
  }
  foreach ( $fields['facet_orientation_questions_4']['value'] as $answers ) {
    foreach ( $answers as $key => $value ) {
      $splitted_value = explode( '-', $value );
      if ( count($splitted_value) > 1 ) {
        // here we have a checkbox
        $facets_ref = $splitted_value[0];
        $value = $splitted_value[1];
        $$facets_ref += (float)$value;
      } else {
        // here we have a radio input or number type
        $facets_ref = explode( '_', $key )[0];
        $$facets_ref += (float)$value;
      }
    }
  }
  // Calculate facets percentage
  $enh_percentage = $enh / $max * 100;
  $mis_percentage = $mis / $max * 100;
  $ant_percentage = $ant / $max * 100;
  $ada_percentage = $ada / $max * 100;

  //* Portfolio Tendency Group
  $portfolio_tendency_group = '';
  $portfolio_tendency_group_text = '';
  if ($enh_percentage >= 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage >= 50 ) {
        $portfolio_tendency_group = 'Adaptive/Anticipatory/Enhancement/Mission';
        $portfolio_tendency_group_text = get_field( 'adaptiveanticipatoryenhancementmission_content', 'option' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage < 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_group = 'Primarily Anticipatory';
        $portfolio_tendency_group_text = get_field( 'primarily_anticipatory_content', 'option' );
      }
  elseif
     ($enh_percentage => 50 &&
      $mis_percentage < 50 &&
      $ant_percentage < 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_group = 'Primarily Enhancement';
        $portfolio_tendency_group_text = get_field( 'primarily_enhancement_content', 'option' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage < 50 &&
      $ant_percentage < 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_group = 'Primarily Adaptive';
        $portfolio_tendency_group_text = get_field( 'primarily_adaptive_content', 'option' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage < 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_group = 'Primarily Mission';
        $portfolio_tendency_group_text = get_field( 'primarily_mission_content', 'option' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage < 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_group = 'Anticipatory - Enhancement';
        $portfolio_tendency_group_text = get_field( 'anticipatory_enhancement_content', 'option' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage < 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_group = 'Adaptive - Mission';
        $portfolio_tendency_group_text = get_field( 'adaptive_mission_content', 'option' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage < 50 &&
      $ant_percentage < 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_group = 'Adaptive - Enhancement';
        $portfolio_tendency_group_text = get_field( 'adaptive_enhancement_content', 'option' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_group = 'Anticipatory - Mission';
        $portfolio_tendency_group_text = get_field( 'anticipatory_mission_content', 'option' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage < 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_group = 'Adaptive - Anticipatory';
        $portfolio_tendency_group_text = get_field( 'adaptive_anticipatory_content', 'option' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage < 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_group = 'Enhancement - Mission';
        $portfolio_tendency_group_text = get_field( 'enhancement_mission_content', 'option' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_group = 'Adaptive - Anticipatory - Mission';
        $portfolio_tendency_group_text = get_field( 'adaptive_anticipatory_mission_content', 'option' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage < 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_group = 'Adaptive - Anticipatory - Enhancement';
        $portfolio_tendency_group_text = get_field( 'adaptive_anticipatory_enhancement_content', 'option' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage < 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_group = 'Adaptive - Enhancement - Mission';
        $portfolio_tendency_group_text = get_field( 'adaptive_enhancement_mission_content', 'option' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_group = 'Anticipatory - Mission - Enhancement';
        $portfolio_tendency_group_text = get_field( 'anticipatory_mission_enhancement_content', 'option' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage < 50 &&
      $ant_percentage < 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_group = 'Weak in all facets';
        $portfolio_tendency_group_text = get_field( 'weak_in_all_facets_content', 'option' );
      }
  else {
    $portfolio_tendency_group = 'The VOID';
    $portfolio_tendency_group_text = get_field( 'the_VOID_content', 'option' );
  }

  //* Calculate Portfolio Management questions score
  $pmq_score = 16; // Automatic 16 points added to all scores to account to avoid negative score
  $pmw_max = 108;
  foreach ( $fields['portfolio_management_questions_1']['value'] as $key => $value ) {
    if ( is_array($value) ) {
      foreach ( $value as $subkey => $subvalue ) {
        $pmq_score += (float)$subvalue;
      }
    } else {
      $split_value = explode( '-', $value );
      $pmq_score += $value[0];
    }
  }
  foreach ( $fields['portfolio_management_questions_2']['value'] as $key => $value ) {
    if ( is_array($value) ) {
      foreach ( $value as $subkey => $subvalue ) {
        $pmq_score += (float)$subvalue;
      }
    } else {
      $split_value = explode( '-', $value );
      $pmq_score += $value[0];
    }
  }

  $level = '';
  if ( $pmq_score < 36  ) {
    $level = 'loew';
  } elseif ( $pmq_score >= 72 ) {
    $level = 'high';
  } else {
    $level = 'medium';
  }

?>
	<div class="row">
		<div class="col-md-9">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>

				<?php if (get_field('hide_page_title') !== true) { ?>
				<h1 class="entry-title <?php echo ( !empty( $badges ) ? 'pull-left' : ''); ?>"><?php the_title(); ?></h1>
				<?php } ?>

				<div class="entry-content">

          <?php


          // echo scores
          echo "<p>Enhancement: " . $enh_percentage . "%</p>";
          echo "<p>Mission: " . $mis_percentage . "%</p>";
          echo "<p>Anticipator: " . $ant_percentage . "%</p>";
          echo "<p>Adaptive: " . $ada_percentage . "%</p>";

          echo "<p>Portfolio Management Score: " . ( $pmq_score / $pmw_max * 100 ) . "% (Level " . $level . ")</p>";
           ?>

        </div><!-- end entry-content -->

      </article>
      <?php comments_template(); ?>

		</div>

		<div class="col-md-3 case_study_sidebar">

		</div>

	</div> <!-- end row -->
	<?php endwhile; ?>

</div> <!-- end col-sm-12 -->

<?php wp_reset_query(); ?>

<?php get_footer(); ?>
