<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */

get_header();

global $shisan_site_width;
?>

<div id="main-content" class="main-content row">
	<div id="primary" class="content-area <?php echo $shisan_site_width; ?>">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					get_template_part( 'content', get_post_format() );

					?><div class="clearfix"></div>
                        <footer class="entry-meta">
                        <?php
                        if ( is_single() && (!(has_tag('zhuanzai') || has_category('zhaichaohedaolian'))) ) {
                                get_template_part( 'meta', 'license' );
                                }
					           the_tags( '<span class="glyphicon glyphicon-tags"></span><span class="tag-links">', '', '</span>' );
                        ?>
                        </footer>
                        <?php
					// More posts like this
					 shisan_the_related_posts();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();
