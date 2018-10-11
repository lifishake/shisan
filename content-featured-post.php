<?php
/**
 * The template for displaying featured posts on the front page
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */

global $shisan_featured_post_class, $shisan_featured_post_thumbnail;

if ( empty($shisan_featured_post_class) ) {
	$shisan_featured_post_class     = 'col-sm-3 col-md-3 col-lg-3';
	$shisan_featured_post_thumbnail = 'shisan-thumbnail';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($shisan_featured_post_class); ?>>
	<div class="slide-inner">
		<a class="post-thumbnail" href="<?php the_permalink(); ?>">
			<?php
				// Output the featured image.
				if ( has_post_thumbnail() ) :
					echo wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), $shisan_featured_post_thumbnail );
				endif;
			?>

			<div class="slider-content">
				<header class="entry-header">
					<?php the_title( '<h2 class="entry-title">','</h2>' ); ?>
				</header><!-- .entry-header -->
				<?php the_excerpt(); ?>
			</div>
		</a>
	</div>
</article><!-- #post-## -->
