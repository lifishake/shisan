<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Page thumbnail and title.
		longform_post_thumbnail();
		the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' );
	?>

	<div class="entry-content">
		<div id="entry-content-wrapper">
			<?php the_content(); ?>
		</div>
		<?php
			edit_post_link(  '编辑', '<span class="edit-link">', '</span>' );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
