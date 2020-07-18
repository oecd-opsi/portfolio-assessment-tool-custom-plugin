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
     ($enh_percentage >= 50 &&
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
    $level = 'low';
  } elseif ( $pmq_score >= 72 ) {
    $level = 'high';
  } else {
    $level = 'medium';
  }

  // Navigation menu
  $nav_menu = '
    <ul class="pat-results-nav-menu">
      <li><a href="#introduction">Introduction</a></li>
      <li><a href="#organisational-portfolio-balance">Organisational Portfolio Balance</a></li>
      <li><a href="#portfolio-management-capability">Portfolio Management Capability</a></li>
      <!--<li><a href="#project-based-mapping">Project based Mapping</a></li>-->
      <!--<li><a href="#combined-results">Combined Results</a></li>-->
      <li><a href="#download-and-share">Download and Share Results</a></li>
      <li><a href="#interpretation">Interpretationn and Next Steps</a></li>
      <li><a href="#">Share icon</a></li>
      <li><a href="#">Start again</a></li>
    </ul>
  ';

?>
	<div class="row">
		<div class="col-sm-12">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="entry-content">


          <div class="pat-results-hero"><h1>Portfolio Exploration Tool Results</h1></div>

          <div class="pat-results-top-nav"><?php echo $nav_menu ?></div>

          <main class="pat-results-main-content">

            <aside class="pat-results-side"><?php echo $nav_menu ?></aside>

            <section id="introduction">

              <div class="pat-results-content">

                <h2>Innovation portfolio balance of <?php echo $organisation ?></h2>
                <p class="subtitle">Based on exploration by <?php echo $name ?> on <?php echo $submission_date ?></p>

                <p class="disclaimer"><?php echo get_field( 'disclaimer', 'option' ) ?></p>

                <h3>Your organisational portfolio tends to <?php echo $portfolio_tendency_group ?> innovation</h3>

              </div>

            </section>

            <section id="organisational-portfolio-balance" class="pat-results-fullwidth-section">

              <div class="pat-results-side">
                <p><?php echo $portfolio_tendency_group ?> innovation</p>
                <?php // TODO: diamonds with tendency highlighted, one for each facet ?>
                <?php // TODO: diamond with all percentage, showing when tendency group text ?>
              </div>

              <div class="pat-results-content">

                <h2>Innovation portfolio balance of <?php echo $organisation ?></h2>

                <?php
                echo '<p>Enhancement: ' . $enh_percentage . '%</p>';
                echo '<p>Mission: ' . $mis_percentage . '%</p>';
                echo '<p>Anticipatory: ' . $ant_percentage . '%</p>';
                echo '<p>Adaptive: ' . $ada_percentage. '%</p>';
                 ?>

                <div class="enhancement-inno-section">
                  <?php // TODO:diamond with percentage  ?>
                  <?php the_field( 'enhancemnet_oriented_innovation_text', 'option' ); ?>
                </div>

                <div class="mission-inno-section">
                  <?php // TODO:diamond with percentage  ?>
                  <?php the_field( 'mission_oriented_innovation_text', 'option' ); ?>
                </div>

                <div class="adaptive-inno-section">
                  <?php // TODO:diamond with percentage  ?>
                  <?php the_field( 'adaptive_oriented_innovation_text', 'option' ); ?>
                </div>

                <div class="anticipatory-inno-section">
                  <?php // TODO:diamond with percentage  ?>
                  <?php the_field( 'anticipatory_oriented_innovation_text_', 'option' ); ?>
                </div>

                <div class="tendency-group">

                  <p>This organisation’sportfolio tends to be strong in <?php echo $portfolio_tendency_group ?>-oriented innovation.</p>

                  <?php echo $portfolio_tendency_group_text ?>

                </div>

              </div>

            </section>

            <section id="portfolio-management-capability" class="pat-results-fullwidth-section">

              <div class="pat-results-side">
                <p>Portfolio balance</p>
                <?php // TODO: diamond with all percentage ?>
                <p>Portfolio management Capability</p>
                <?php // TODO: low/med/high graph ?>
              </div>

              <div class="pat-results-content">

                <p>This organisation’s tends to have <?php echo $level ?> portfolio management capablity</p>

                <?php // TODO: low/med/high graph ?>

                <?php the_field( 'portfolio_management_capability_text', 'option' ); ?>

              </div>

            </section>

            <section id="download-and-share">
              <div class="pat-results-content">
                <h2>Download and share results</h2>
                <?php the_field( 'download_and_share_results_text', 'option' ) ?>
                <button class="download-pdf">Download PDF</button>
                <button class="download-csv">Download CSV</button>
              </div>
            </section>

            <section id="#interpretation">
              <div class="pat-results-content">
                <h2>How you might use these results</h2>
                <?php the_field( 'how_you_might_use_these_result_text', 'option' ) ?>
                <h2>Save, share, and continue to next steps</h2>
                <?php the_field( 'save_share_and_continue_to_next_steps_text', 'option' ) ?>
                <h2>Contact OPSI for help with interpretation</h2>
                <?php the_field( ' contact_OPSI_for_help_with_interpretation_text', 'option' ) ?>
              </div>
            </section>

          </main>

        </div><!-- end entry-content -->

      </article>

		</div>

		<div class="col-md-3 case_study_sidebar">

		</div>

	</div> <!-- end row -->
	<?php endwhile; ?>

</div> <!-- end col-sm-12 -->

<?php wp_reset_query(); ?>

<?php get_footer(); ?>
