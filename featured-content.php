<?php
/**
 * The template for displaying featured content
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */
?>

<div class="featured-slider">
	<div id="featured-content" class="featured-content">
		<?php
			$featured_posts = shisan_get_featured_posts();
			foreach ( (array) $featured_posts as $order => $post ) :
				setup_postdata( $post );

				 // Include the featured content template.
				get_template_part( 'content', 'featured-post' );
			endforeach;

			wp_reset_postdata();
		?>
		<div class="clearfix"></div>
	</div><!-- #featured-content .featured-content -->
</div><!-- .featured-slider -->
