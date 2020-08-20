<?php
// Helper function: get flexible content for Tendency Group Text
function bs_tendency_group( $field_name ) {
	$output = '';

	if( have_rows($field_name, 'option') ):
		while( have_rows($field_name, 'option') ): the_row();
			if( get_row_layout() == 'section' ):

				$output .= '<div class="tendency-section">';
				$output .= '<h3>'. get_sub_field('title') .'</h3>';
				$output .= get_sub_field('text');
				$output .= '</div>';

			endif;
    endwhile;
 	endif;

	return $output;
}

function pat_score( $id ) {

  $fields = get_field_objects( $id );

  $scores = array();

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
	$foq_fields = array( 'facet_orientation_questions_1', 'facet_orientation_questions_2', 'facet_orientation_questions_3', 'facet_orientation_questions_4' );
	foreach ($foq_fields as $key) {
		foreach ( $fields[$key]['value'] as $answers ) {
			if( !empty($answers) ) {
				foreach ( $answers as $key => $value ) {
					if ( is_array($value) ) {
						// checkbox or radio
						$splitted_value = explode( '-', $value['value'] );
						if ( count($splitted_value) > 1 ) {
							// here we have a checkbox
							$facets_ref = $splitted_value[0];
							$value = $splitted_value[1];
							if( isset($value['value']) && !empty($facets_ref) ) {
								$$facets_ref += (float)$value['value'];
							}
						} else {
							// here we have a radio input
							$facets_ref = explode( '_', $key )[0];
							if( isset($value['value']) && !empty($facets_ref) ) {
								$$facets_ref += (float)$value['value'];
							}
						}

					} else {
						// here we have an number input (ranking field)
						// here we have a radio input
						$facets_ref = explode( '_', $key )[0];
						if( !empty($facets_ref) ) {
							$$facets_ref += (float)$value;
						}
					}
				}
			}
		}
	}
  // Calculate facets percentage
  $enh_percentage = round( $enh / $max * 100 );
  $mis_percentage = round( $mis / $max * 100 );
  $ant_percentage = round( $ant / $max * 100 );
  $ada_percentage = round( $ada / $max * 100 );

  $scores['enh_percentage'] = $enh_percentage;
  $scores['mis_percentage'] = $mis_percentage;
  $scores['ant_percentage'] = $ant_percentage;
  $scores['ada_percentage'] = $ada_percentage;

  // Transform percentage into color
  $enh_color = ColorHSLToRGB( 288, 75, $enh_percentage );
  $mis_color = ColorHSLToRGB( 288, 75, $mis_percentage );
  $ant_color = ColorHSLToRGB( 288, 75, $ant_percentage );
  $ada_color = ColorHSLToRGB( 288, 75, $ada_percentage );

  $scores['enh_color'] = $enh_color;
  $scores['mis_color'] = $mis_color;
  $scores['ant_color'] = $ant_color;
  $scores['ada_color'] = $ada_color;

  //* Portfolio Tendency Group
  $portfolio_tendency_group = '';
  $portfolio_tendency_group_text = '';
  if ($enh_percentage >= 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage >= 50 ) {
        $portfolio_tendency_statement = get_field( 'adaptive_anticipatory_enhancement_mission_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'adaptiveanticipatoryenhancementmission_content' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage < 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_statement = get_field( 'primarily_anticipatory_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'primarily_anticipatory_content' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage < 50 &&
      $ant_percentage < 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_statement = get_field( 'primarily_enhancement_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'primarily_enhancement_content' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage < 50 &&
      $ant_percentage < 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_statement = get_field( 'primarily_adaptive_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'primarily_adaptive_content' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage < 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_statement = get_field( 'primarily_mission_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'primarily_mission_content' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage < 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_statement = get_field( 'anticipatory_enhancement_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'anticipatory_enhancement_content' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage < 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_statement = get_field( 'adaptive_mission_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'adaptive_mission_content' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage < 50 &&
      $ant_percentage < 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_statement = get_field( 'adaptive_enhancement_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'adaptive_enhancement_content' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_statement = get_field( 'anticipatory_mission_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'anticipatory_mission_content' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage < 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_statement = get_field( 'adaptive_anticipatory_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'adaptive_anticipatory_content' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage < 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_statement = get_field( 'enhancement_mission_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'enhancement_mission_content' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_statement = get_field( 'adaptive_anticipatory_mission_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'adaptive_anticipatory_mission_content' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage < 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_statement = get_field( 'adaptive_anticipatory_enhancement_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'adaptive_anticipatory_enhancement_content' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage < 50 &&
      $ada_percentage >= 50) {
        $portfolio_tendency_statement = get_field( 'adaptive_enhancement_mission_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'adaptive_enhancement_mission_content' );
      }
  elseif
     ($enh_percentage >= 50 &&
      $mis_percentage >= 50 &&
      $ant_percentage >= 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_statement = get_field( 'anticipatory_mission_enhancement_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'anticipatory_mission_enhancement_content' );
      }
  elseif
     ($enh_percentage < 50 &&
      $mis_percentage < 50 &&
      $ant_percentage < 50 &&
      $ada_percentage < 50) {
        $portfolio_tendency_statement = get_field( 'weak_in_all_facets_statement', 'option' );
        $portfolio_tendency_group_text = bs_tendency_group( 'weak_in_all_facets_content' );
      }
  else {
    $portfolio_tendency_statement = get_field( 'the_void_statement', 'option' );
    $portfolio_tendency_group_text = bs_tendency_group( 'the_VOID_content' );
  }

  $scores['portfolio_tendency_statement'] = $portfolio_tendency_statement;
  $scores['portfolio_tendency_group_text'] = $portfolio_tendency_group_text;

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

  $level = '';
  if ( $pmq_score < 36  ) {
    $level = 'low';
  } elseif ( $pmq_score >= 72 ) {
    $level = 'high';
  } else {
    $level = 'medium';
  }

  $scores['pmq_score'] = $pmq_score;
  $scores['level'] = $level;

	// Module 2 calculation
	// if status is not publish_module2, skip this calculation
	$post_status = get_post_status_object( get_post_status( $id ) );
	$status_slug = $post_status->name;
	if( $status_slug == 'publish_module2' ) {

		// Zone list:
		// 1. Enhancement-oriented projects
		// 2. Mission-oriented projects
		// 3. Anticipatory-oriented projects
		// 4. Adaptive-oriented projects
		// 5. Sustaining change
    // 6. Transformative change
		// 7. Disruptive change
 		// 8. Optimising change
    // 9. Mixed or unclear
		$mod2_chart_array = array(
			'1-enh' => array(),
			'2-mis' => array(),
			'3-ant' => array(),
			'4-ada' => array(),
			'5-sus' => array(),
	    '6-tra' => array(),
			'7-dis' => array(),
			'8-opt' => array(),
	    '9-mix' => array(),
		);

		// Get the list of inserted projects, calculate their position and put each of them in the array
		$project_lists = $fields['projects']['value']['projects_list'];
		foreach ($project_lists as $project) {
			$title = $project['project_title'];
			$q1 = $project['this_project_was_primarily_created_to:'];
			$q2 = $project['the_project_has_been_mainly_pushed_forward_by:'];
			$priority = $project['what_level_of_priority_would_you_say_this_project_has_in_your_organisation'];
			$circle = 4;
			if( $priority == 'h' ) {
				$circle = 6;
			} elseif ( $priority == 'm') {
				$circle = 5;
			}
			$output = array(
				'title' => $title,
				'priority' => $priority,
				'circle'	=> $circle
			);
			if( $q1 == '0' ) {
				$mod2_chart_array['9-mix'][] = $output;
			} elseif ( $q1 == '1' ) {
				if( $q2 == 'a' ) { $mod2_chart_array['5-sus'][] = $output; }
				if( $q2 == 'b' ) { $mod2_chart_array['1-enh'][] = $output; }
				if( $q2 == 'c' ) { $mod2_chart_array['8-opt'][] = $output; }
				if( $q2 == 'd' ) { $mod2_chart_array['9-mix'][] = $output; }
			} elseif ( $q1 == '2' ) {
				if( $q2 == 'a' ) { $mod2_chart_array['2-mis'][] = $output; }
				if( $q2 == 'b' ) { $mod2_chart_array['5-sus'][] = $output; }
				if( $q2 == 'c' ) { $mod2_chart_array['9-mix'][] = $output; }
				if( $q2 == 'd' ) { $mod2_chart_array['6-tra'][] = $output; }
			} elseif ( $q1 == '3' ) {
				if( $q2 == 'a' ) { $mod2_chart_array['6-tra'][] = $output; }
				if( $q2 == 'b' ) { $mod2_chart_array['9-mix'][] = $output; }
				if( $q2 == 'c' ) { $mod2_chart_array['7-dis'][] = $output; }
				if( $q2 == 'd' ) { $mod2_chart_array['3-ant'][] = $output; }
			} elseif ( $q1 == '4' ) {
				if( $q2 == 'a' ) { $mod2_chart_array['9-mix'][] = $output; }
				if( $q2 == 'b' ) { $mod2_chart_array['8-opt'][] = $output; }
				if( $q2 == 'c' ) { $mod2_chart_array['4-ada'][] = $output; }
				if( $q2 == 'd' ) { $mod2_chart_array['7-dis'][] = $output; }
			}
		}

		// Sort project list by priority
		foreach ( $mod2_chart_array as $key => $array) {
			$order = array( 'h', 'm', 'l' );
			usort( $mod2_chart_array[$key], function($a,$b) use ($order){
				$pos_a = array_search( $a['priority'], $order);
				$pos_b = array_search( $b['priority'], $order);
				return ($pos_a < $pos_b) ? -1 : 1;
			});

		}

		$scores['m2'] = $mod2_chart_array;

	}

  return $scores;

}

 ?>
