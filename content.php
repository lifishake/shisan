<?php
/**
 * 显示内容
 *
 *  single/index/archive/search.
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php

			if ( !is_single() ) : ?>
					<span class="cat-links"><?php the_category(', '); ?></span>
			<?php
					the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
				?>

				<div class="entry-meta">
					<?php
						if ( 'post' == get_post_type() )
							shisan_posted_on();

						if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
					?>
					<?php
						endif;
					?>
				</div><!-- .entry-meta -->

			<?php
			endif;
		?>
	</header><!-- .entry-header -->

    <?php if ( !is_single() ) : ?>
    	<div class="entry-summary">
    		<?php the_excerpt(); ?>
    	</div><!-- .entry-summary -->
    	<?php else : ?>
    	<div class="entry-content">
    		<div id="entry-content-wrapper">
    			<?php the_content( ); ?>
    		</div>
    	</div><!-- .entry-content -->
    	<?php endif;
            edit_post_link(  '编辑', '<span class="edit-link">', '</span>' );
        ?>


</article><!-- #post-## -->
