<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */
?>

		</div><!-- #main -->

		<div class="site-footer-wrapper">
			<div class="site-footer-container container">
				<footer id="colophon" class="site-footer row" role="contentinfo">
					<?php get_sidebar( 'footer' ); ?>
				</footer><!-- #colophon -->
			</div>
			<div class="site-info col-sm-12 col-md-12 col-lg-12">
				<div class="site-info-content">
					<div class="copyright">
						<?php echo (' &copy; 2005-'.date('Y').' 破袜子&nbsp;&nbsp;主题&nbsp;'); ?><a href="https://github.com/lifishake/shisan" target="_blank">十三&nbsp;</a>修改自&nbsp;<a href="https://cohhe.com/project-view/longform/" target = "_blank">longform</a>.
					</div>
					<div class="footer-menu">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'footer',
									'menu_class'     => 'footer-menu',
									'depth'          => 1,
                                             'link_before'    => '<span class="screen-reader-text">',
								     'link_after'     => '</span>' . shisan_get_svg(  'chain' ),
								)
							);
						?>
					</div>
				</div>
                        <?php 
                        if ( is_single() ) {
                            $args = array(
                                    'prev_text' => '<span class="glyphicon glyphicon-arrow-left"></span><span class="post-left">%title</span>',
                                    'next_text' => '<span class="post-right">%title</span><span class="glyphicon glyphicon-arrow-right">',
                                    'screen_reader_text'=>'文章导航'
                                );
                             if ( function_exists('apip_get_post_navagation') ){
                                apip_get_post_navagation( $args );
                            }
                            else {
                                the_post_navigation( $args );
                            }
                        }
                        ?>
					<a class="scroll-to-top" href="#"><span class="glyphicon glyphicon-arrow-up"></span></a>
				<div class="clearfix"></div>
			</div><!-- .site-info -->
			<div class="clearfix"></div>
		</div>
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
