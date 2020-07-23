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
  $enh_percentage = round( $enh / $max * 100 );
  $mis_percentage = round( $mis / $max * 100 );
  $ant_percentage = round( $ant / $max * 100 );
  $ada_percentage = round( $ada / $max * 100 );

  // Transform percentage into color
  $enh_color = ColorHSLToRGB( 288, 75, $enh_percentage );
  $mis_color = ColorHSLToRGB( 288, 75, $mis_percentage );
  $ant_color = ColorHSLToRGB( 288, 75, $ant_percentage );
  $ada_color = ColorHSLToRGB( 288, 75, $ada_percentage );

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
      <li class="nav-share-item"><a href="#"><span>Share icon</span></a></li>
      <li class="nav-start-again-item"><a href="#">Start again</a></li>
    </ul>
  ';

?>
	<div class="row">
		<div class="col-sm-12">
			<article id="post-<?php the_ID(); ?>" <?php post_class('pat-results'); ?>>

        <div class="entry-content">

          <div class="col-md-12 pat-results-hero">
          	<div class="pat-form-title-wrapper screen-reader-text">
              <h1>Portfolio Exploration Tool Results</h1>
          	</div>
          	<div class="single_img_wrap pat-form-banner">
          		<img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/images/pat-results-hero.jpg" class="attachment-blog size-blog wp-post-image" alt="Portfolio Exploration Results">
          	</div>
          </div>

          <div class="pat-results-top-nav"><?php echo $nav_menu ?></div>

          <div class="col-md-12">

            <main class="pat-results-main-content">

              <aside class="pat-results-side"><?php echo $nav_menu ?></aside>

              <section id="introduction">

                <div class="pat-results-content">

                  <div class="pat-results-main-title">
                    <h2>Innovation portfolio balance of <?php echo $organisation ?></h2>
                    <p class="subtitle">Based on exploration by <?php echo $name ?> on <?php echo $submission_date ?></p>
                  </div>

                  <div class="disclaimer"><?php echo get_field( 'disclaimer_text', 'option' ) ?></div>

                  <!-- Diamond 1 -->
                  <div class="diamond diamond-1">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="803" height="445" viewBox="0 0 803 445"><defs><style>.a{fill:none;stroke:#fff;stroke-width:3px;}.b{fill:<?php echo $enh_color ?>;}.c{fill:<?php echo $mis_color ?>;}.d{fill:<?php echo $ada_color ?>;}.e{fill:<?php echo $ant_color ?>;}.f{fill:#605f5f;font-size:12px;}.f,.g{font-family:Roboto-Medium, Roboto;font-weight:500;}.g{fill:#fff;font-size:33px;}.h{filter:url(#i);}.i{filter:url(#g);}.j{filter:url(#e);}.k{filter:url(#c);}.l{filter:url(#a);}</style><filter id="a" x="125.265" y="25.211" width="572.267" height="381.245" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="3" result="b"/><feFlood flood-opacity="0.161"/><feComposite operator="in" in2="b"/><feComposite in="SourceGraphic"/></filter><filter id="c" x="186.614" y="149.628" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="d"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="d"/><feComposite in="SourceGraphic"/></filter><filter id="e" x="305.324" y="71.092" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="f"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="f"/><feComposite in="SourceGraphic"/></filter><filter id="g" x="305.324" y="227.27" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="h"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="h"/><feComposite in="SourceGraphic"/></filter><filter id="i" x="424.927" y="149.628" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="j"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="j"/><feComposite in="SourceGraphic"/></filter></defs><g transform="translate(-490 -1096.295)"><g class="l" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="a" d="M2580.007,3511.292l274.127-178.347L3128.8,3511.292,2854.135,3692.6Z" transform="translate(-2443.01 -3299.95)"/></g><g class="k" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-352.13 -1209.87)"/></g><g transform="translate(799.824 1168.887)"><g class="j" transform="matrix(1, 0, 0, 1, -309.82, -72.59)"><path class="c" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-355.42 -1211.41)"/></g></g><g class="i" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="d" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-355.42 -1208.23)"/></g><g class="h" transform="matrix(1, 0, 0, 1, 490, 1096.29)"><path class="e" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-358.81 -1209.87)"/></g><text class="f" transform="translate(1245 1308.295)"><tspan x="-39.574" y="0">UNCERTAINTY</tspan><tspan x="-47.317" y="14">Exploring/Radical</tspan></text><text class="f" transform="translate(897.224 1524.295)"><tspan x="-35.707" y="0">UNDIRECTED</tspan><tspan x="-62.745" y="14">Responding/Bottom Up</tspan></text><text class="f" transform="translate(907.224 1107.295)"><tspan x="-27.536" y="0">DIRECTED</tspan><tspan x="-53.484" y="14">Shaping / Top Down</tspan></text><text class="f" transform="translate(553 1301.295)"><tspan x="-31.403" y="0">CERTAINTY</tspan><tspan x="-62.396" y="14">Exploiting/ Incremental</tspan></text><text class="g" transform="translate(902.528 1240)"><tspan x="-30.873" y="0"><?php echo $mis_percentage ?>%</tspan></text><text class="g" transform="translate(902.528 1399)"><tspan x="-30.873" y="0"><?php echo $ada_percentage ?>%</tspan></text><text class="g" transform="translate(1021.528 1322)"><tspan x="-30.873" y="0"><?php echo $ant_percentage ?>%</tspan></text><text class="g" transform="translate(783.528 1316)"><tspan x="-30.873" y="0"><?php echo $enh_percentage ?>%</tspan></text></g></svg>
                  </div>

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

                  <h2 class="section-title">Innovation portfolio balance of <strong><?php echo $organisation ?></strong></h2>

                  <?php
                  echo '<p>Enhancement: ' . $enh_percentage . '%</p>';
                  echo '<p>Mission: ' . $mis_percentage . '%</p>';
                  echo '<p>Anticipatory: ' . $ant_percentage . '%</p>';
                  echo '<p>Adaptive: ' . $ada_percentage. '%</p>';
                   ?>

                  <div class="enhancement-inno-section">
                    <!-- diamond with enhancement percentage   -->
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="548.793" height="343.681" viewBox="0 0 548.793 343.681"><defs><style>.a{fill:#e6e8f0;}.b{fill:<?php echo $enh_color ?>;}.c,.e,.f{opacity:0.201;}.d{fill:<?php echo $mis_color ?>;}.e{fill:<?php echo $ada_color ?>;}.f{fill:<?php echo $ant_color ?>;}.g,.h{fill:#fff;font-family:Roboto-Medium, Roboto;font-weight:500;}.g{font-size:20px;}.h{font-size:33px;}.i{filter:url(#g);}.j{filter:url(#e);}.k{filter:url(#c);}.l{filter:url(#a);}</style><filter id="a" x="49.614" y="105.65" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="b"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="b"/><feComposite in="SourceGraphic"/></filter><filter id="c" x="168.324" y="27.115" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="d"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="d"/><feComposite in="SourceGraphic"/></filter><filter id="e" x="168.324" y="183.293" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="f"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="f"/><feComposite in="SourceGraphic"/></filter><filter id="g" x="287.927" y="105.65" width="214.802" height="135.775" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="1.5" result="h"/><feFlood flood-opacity="0.349"/><feComposite operator="in" in2="h"/><feComposite in="SourceGraphic"/></filter></defs><g transform="translate(-627 -1980.272)"><path class="a" d="M2580.007,3503.369l274.127-170.424L3128.8,3503.369l-274.666,173.257Z" transform="translate(-1953.007 -1352.673)"/><g class="l" transform="matrix(1, 0, 0, 1, 627, 1980.27)"><path class="b" d="M749.043,1424.834l-102.9,62.941-102.9-62.941L646.142,1361Z" transform="translate(-489.13 -1253.85)"/></g><g class="c" transform="translate(799.824 2008.887)"><g class="k" transform="matrix(1, 0, 0, 1, -172.82, -28.62)"><path class="d" d="M871.043,1347.834l-102.9,62.941-102.9-62.941L768.142,1284Z" transform="translate(-492.42 -1255.38)"/></g></g><g class="j" transform="matrix(1, 0, 0, 1, 627, 1980.27)"><path class="e" d="M871.043,1500.834l-102.9,62.941-102.9-62.941L768.142,1437Z" transform="translate(-492.42 -1252.21)"/></g><g class="i" transform="matrix(1, 0, 0, 1, 627, 1980.27)"><path class="f" d="M994.043,1424.834l-102.9,62.941-102.9-62.941L891.142,1361Z" transform="translate(-495.81 -1253.85)"/></g><text class="g" transform="translate(902.528 2080)"><tspan x="-40.474" y="0">MISSION</tspan></text><text class="g" transform="translate(898.528 2235)"><tspan x="-47.148" y="0">ADAPTIVE</tspan></text><text class="g" transform="translate(1022.528 2155)"><tspan x="-68.384" y="0">ANTICIPATORY</tspan></text><text class="h" transform="translate(790 2162)"><tspan x="-30.873" y="0"><?php echo $enh_percentage ?>%</tspan></text></g></svg>
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

          </div>

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
