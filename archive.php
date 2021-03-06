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

global $shisan_site_width;
?>
<div id="main-content" class="main-content row">
    <section id="primary" class="content-area <?php echo $shisan_site_width; ?>">
        <div id="content" class="site-content" role="main">

            <?php if ( have_posts() ) : ?>
            <header class="page-header">
                <?php shisan_archive_title(); ?>
            </header><!-- .page-header -->
            <?php
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
