<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */

get_header();

global $longform_site_width;
?>

<div id="main-content" class="main-content row">
	<?php
		get_sidebar();
	?>
	<div id="primary" class="content-area <?php echo $longform_site_width; ?>">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					get_template_part( 'content', get_post_format() );

					?><div class="clearfix"></div><?php

					the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' );

					// More posts like this
					echo longform_the_related_posts();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
