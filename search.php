<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */

get_header();

global $shisan_site_width;
?>
<div id="main-content" class="main-content row">
	<section id="primary" class="content-area <?php echo $shisan_site_width; ?>">
		<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( '关键字『%s』的搜索结果', get_search_query()  );  ?></h1>
			</header><!-- .page-header -->

				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();
						get_template_part( 'content', get_post_format() );
					endwhile;
					shisan_posts_pagination();
				else :
					get_template_part( 'content', 'none' );
				endif;
			?>

		</div><!-- #content -->
	</section><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();
