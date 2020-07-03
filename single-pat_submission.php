<?php get_header();

  global $post;

  $has_sidebar = 0;
	$layout = 'fullpage';

?>



<div class="col-sm-<?php echo 12 - $has_sidebar; ?> <?php echo ($has_sidebar > 0 ? 'col-sm-pull-3' : ''); ?>">

<?php while ( have_posts() ) : the_post(); $postid = get_the_ID();

  // get fields
	// echo '<pre>'.print_r($fields, true).'</pre>';

?>
	<div class="row">
		<div class="col-md-9">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>

				<?php if (get_field('hide_page_title') !== true) { ?>
				<h1 class="entry-title <?php echo ( !empty( $badges ) ? 'pull-left' : ''); ?>"><?php the_title(); ?></h1>
				<?php } ?>

				<div class="entry-content"><?php the_content(); ?>CICCIOOOOO</div>

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
