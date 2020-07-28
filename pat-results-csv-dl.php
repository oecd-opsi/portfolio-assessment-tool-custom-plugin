<?php
$absPath = dirname(__FILE__);
$realPath = realpath($absPath . '/./');
$fPath = explode("wp-content",$realPath);
define('WP_USE_THEMES', false);
require(''.$fPath[0].'/wp-blog-header.php');

// declare array
$array = array();

// WP_Query arguments
$args = array(
	'post_type'              => array( 'pat_submission' ),
	'post_status'            => array( 'publish' ),
	'author'                 => get_current_user_id(),
	'nopaging'               => true,
	'posts_per_page'         => '-1',
);

// The Query
$query = new WP_Query( $args );

// The Loop
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();

    // get all the fields
    $fields = get_field_objects( get_the_ID() );

    // Fields list: submission ID
                //  first name
                //  last name
                //  date submitted
                //  Organisation
                //  Country
                //  Answers
                //  Group
                //  Group text
                //  Portfolio management %
                //  Portfolio management level (H/M/L)
                //  Link to results page

    $general_questions = get_field('general_questions');

    $post_array = array {
      get_the_ID(),
      get_the_author_meta('first_name'),
      get_the_author_meta('last_name'),
      get_the_date(),
      $general_questions['organisation'],
      $general_questions['country']['name'],
      
    }

	}
}

// Restore original Post Data
wp_reset_postdata();
