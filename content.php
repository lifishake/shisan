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

			if ( !is_single() ) :
					the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
				?>

				<div class="entry-meta">
					<?php
						if ( 'post' == get_post_type() ) {
                                     shisan_weather();
                                    shisan_posted_on();
                                    shisan_cat();
                                    shisan_comment();
                              }
					?>
				</div><!-- .entry-meta -->

			<?php
			endif;
		?>
	</header><!-- .entry-header -->

    <?php if ( !is_single() ) : ?>
        <?php if ( !is_home() ) { ?>
        	<div class="entry-summary">
        		<?php the_excerpt(); ?>
        	</div><!-- .entry-summary -->
        <?php } ?>
    <?php  else : ?>
    	<div class="entry-content">
    		<div id="entry-content-wrapper">
    			<?php the_content( ); ?>
    		</div>
    	</div><!-- .entry-content -->
    	<?php endif;
        ?>


</article><!-- #post-## -->
