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
  foreach ( $fields['facet_orientation_questions_1']['value'] as $answers ) {
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
  foreach ( $fields['facet_orientation_questions_2']['value'] as $answers ) {
    if( !empty($answers)) {
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
  foreach ( $fields['facet_orientation_questions_3']['value'] as $answers ) {
    if( !empty($answers)) {
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
  foreach ( $fields['facet_orientation_questions_4']['value'] as $answers ) {
    if( !empty($answers)) {
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

  return $scores;

}

 ?>
