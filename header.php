<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html lang="zh-CN" >
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<?php	echo '<link rel="shortcut icon" href="' . esc_url( get_template_directory_uri()."/favicon.ico" ) . '" />';	?>
    <![endif]-->

	<?php wp_head(); ?>
</head>
<?php
global $shisan_site_width;

$form_class    = '';
$class         = '';
$search_string = '';
$shisan_site_width    = 'col-sm-12 col-md-12 col-lg-12';
$layout_type   = 'full';
?>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<div class="search-toggle">
			<div class="search-content container">
				<form action="<?php echo home_url(); ?>" method="get" class="<?php echo $form_class; ?>">
					<input type="text" name="s" class="<?php echo $class; ?>" value="<?php echo $search_string; ?>" placeholder="<?php echo '搜索'; ?>"/>
				</form>
			</div>
		</div>
		<div class="header-content">
			<div class="header-main">
				<div class="site-title col-xs-5 col-sm-5 col-md-4">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title"><?php bloginfo( 'name' ); ?></a>
						<?php
						$description = get_bloginfo( 'description', 'display' );

						if ( ! empty ( $description ) ) { ?>
							<p class="site-description"><?php echo esc_html( $description ); ?></p>
						<?php	} ?>
				</div>
				<button type="button" class="navbar-toggle visible-xs visible-sm" data-toggle="collapse" data-target=".site-navigation">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="main-header-right-side col-xs-5 col-sm-5 col-md-8">
					<div class="header-search">
						<form action="" method="get" class="header-search-form">
							<input type="text" name="s" value="" placeholder="Search">
						</form>
						<a href="" class="search-button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
					</div>
					<nav id="primary-navigation" class="col-xs-12 col-sm-10 col-md-8 site-navigation primary-navigation navbar-collapse collapse" role="navigation">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_class'     => 'nav-menu',
									'depth'          => 3,
									'walker'         => new Shisan_Header_Menu_Walker
								)
							);
						?>
					</nav>
				</div>
				<div class="reading-header-right-side col-xs-5 col-sm-5 col-md-8">
					<div class="menu-toggle">
						<a href="javascript:void(0);">
							<span class="bg">
								<em></em>
								<em></em>
								<em></em>
							</span>
						</a>
					</div>
					<div class="hidden-on-menu">
						<?php	shisan_post_nav();	?>
					</div>
					<nav id="primary-navigation" class="col-xs-12 col-sm-10 col-md-8 site-navigation primary-navigation navbar-collapse collapse" role="navigation">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_class'     => 'nav-menu',
									'depth'          => 3,
									'walker'         => new Shisan_Header_Menu_Walker
								)
							);
						?>
					</nav>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</header><!-- #masthead -->
	<?php
     if ( is_single() && has_post_thumbnail() ) { ?>
			<div class="intro-effect-bg-img-container container">
				<div class="intro-effect-bg-img">
					<?php shisan_post_thumbnail(); ?>
				</div>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<div class="entry-meta">
					<?php
						if ( 'post' == get_post_type() )
                                    shisan_weather('text');
							 shisan_posted_on();
                                    shisan_cat();
                                    shisan_comment();
                                ?>
				</div><!-- .entry-meta -->
			</div>
		<?php
		} else if ( is_single() ) { ?>
			<div class="container without_thumbnail">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<div class="entry-meta">
					<?php
						if ( 'post' == get_post_type() )
							shisan_posted_on(); ?>
							<span class="cat-links">/<?php the_category(', '); ?></span>
					<?php
						if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
					?>
					<span class="comments-link">/<?php comments_popup_link(  '0 条评论', '1 条评论', '% 条评论' ); ?></span>
					<?php
						endif;
					?>
				</div><!-- .entry-meta -->
			</div>
		<?php } ?>
	<?php
		if ( is_front_page() && shisan_has_featured_posts()  ) {
			// Include the featured content template.
			get_template_part( 'featured-content' );
		}
	?>
	<div id="main" class="site-main container">
