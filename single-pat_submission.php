<?php get_header();

  global $post;

  $has_sidebar = 0;
	$layout = 'fullpage';

?>



<div class="col-sm-<?php echo 12 - $has_sidebar; ?> <?php echo ($has_sidebar > 0 ? 'col-sm-pull-3' : ''); ?>">

<?php while ( have_posts() ) : the_post(); $postid = get_the_ID();

  // get fields
	// echo '<pre>'.print_r(get_field_objects( $postid ), true).'</pre>';
  $fields = get_field_objects( $postid );

?>
	<div class="row">
		<div class="col-md-9">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>

				<?php if (get_field('hide_page_title') !== true) { ?>
				<h1 class="entry-title <?php echo ( !empty( $badges ) ? 'pull-left' : ''); ?>"><?php the_title(); ?></h1>
				<?php } ?>

				<div class="entry-content">

          <?php
          // Calculate Facet orientation questions score
          // Declare a variable for each facets to store the score
          $enh = 0;
          $mis = 0;
          $ant = 0;
          $ada = 0;
          $max = 64;

          // Get all sub-fields/questions and manage each one based on the type
          foreach ( $fields['facet_orientation_questions']['value'] as $answers ) {
            foreach ( $answers as $key => $value ) {
              // echo '<p>' . $key . ' : ' . $value . '</p>';
              // If the question is of type radio or input number,
              // the value is numeric and the facet reference is in the first part of the key.
              // If the question is of type checkbox, the value contain the facet reference and the value.
              // The type of the field can be deduced from the value: if the splitted value length is greater than zero, the field is a checkbox.
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

          // echo scores
          echo "<p>Enhancement: " . ( $enh / $max * 100 ) . "%</p>";
          echo "<p>Mission: " . ( $mis / $max * 100 ) . "%</p>";
          echo "<p>Anticipator: " . ( $ant / $max * 100 ) . "%</p>";
          echo "<p>Adaptive: " . ( $ada / $max * 100 ) . "%</p>";

          // Calculate Portfolio Management questions score
          // echo '<pre>'.print_r($fields['portfolio_management_questions']['value'], true).'</pre>';
          $pmq_score = 16; // Automatic 16 points added to all scores to account for possible negative answers
          $pmw_max = 108;
          foreach ( $fields['portfolio_management_questions']['value'] as $key => $value ) {
            if ( is_array($value) ) {
              foreach ( $value as $subkey => $subvalue ) {
                $pmq_score += (float)$subvalue;
              }
            } else {
              $pmq_score += $value;
            }
          }

          echo "<p>Portfolio Management Score: " . ( $pmq_score / $pmw_max * 100 ) . "</p>";
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
