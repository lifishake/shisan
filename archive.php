<?php
/**
 * 用于显示"归档"页面.包括tag，date，category。
 * 因为本模板不支持author和taxonomy，所以不包括author与taxonomy的归档格式。
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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
    <section id="primary" class="content-area <?php echo $longform_site_width; ?>">
        <div id="content" class="site-content" role="main">

            <?php if ( have_posts() ) : ?>

            <header class="page-header">
                shisan_archive_title();
            </header><!-- .page-header -->

            <?php
                    // Start the Loop.
                    while ( have_posts() ) : the_post();
                        get_template_part( 'content', get_post_format() );
                    endwhile;
                    // Previous/next page navigation.
                    the_posts_pagination( array(
                        'mid_size '=>10,
        				'prev_text' => '&larr;',
        				'next_text' => '&rarr;',
        			) );
                else :
                    // If no content, include the "No posts found" template.
                    get_template_part( 'content', 'none' );

                endif;
            ?>
        </div><!-- #content -->
    </section><!-- #primary -->
    <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_footer();
