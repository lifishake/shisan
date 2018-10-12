<?php
/**
 * Shisan 1.0 functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */

if ( ! function_exists( 'shisan_setup' ) ) :
	/**
	 * Shisan 1.0 setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 * @since Shisan 1.0
	 */
	function shisan_setup() {

		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails, and declare two sizes.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 672, 372, true );
		add_image_size( 'shisan-full-width', 1170, 600, true );
		add_image_size( 'shisan-huge-width', 1800, 1200, true );
		add_image_size( 'shisan-thumbnail', 490, 318, true );
		add_image_size( 'shisan-thumbnail-large', 490, 318, true );//与普通一样大小

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'   =>  'Top primary menu',
			'footer'    => 'Footer menu',
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list',
		) );
            add_theme_support( 'title-tag' );
		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'audio', 'quote', 'link'
		) );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', apply_filters( 'shisan_custom_background_args', array(
			'default-color' => 'f5f5f5',
		) ) );

		// Add support for featured content.
		add_theme_support( 'featured-content', array(
			'featured_content_filter' => 'shisan_get_featured_posts',
			'max_posts' => 6,
		) );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );
	}
endif; // shisan_setup
add_action( 'after_setup_theme', 'shisan_setup' );

/**
 * Prevent page scroll when clicking the More link
 *
 * @since Shisan 1.0
 *
 * @return void
 */
function remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Shisan 1.0
 *
 * @return array An array of WP_Post objects.
 */
function shisan_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Shisan 1.0.
	 *
	 * @since Shisan 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'shisan_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Shisan 1.0
 *
 * @return bool Whether there are featured posts.
 */
function shisan_has_featured_posts() {
	return ! is_paged() && (bool) shisan_get_featured_posts();
}

/**
 * Register three Shisan 1.0 widget areas.
 *
 * @since Shisan 1.0
 *
 * @return void
 */
function shisan_widgets_init() {

	register_sidebar( array(
		'name'          => 'Footer Widget Area 1',
		'id'            => 'sidebar-3',
		'description'   =>  'Appears in the footer section of the site.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => 'Footer Widget Area 2',
		'id'            => 'sidebar-4',
		'description'   => 'Appears in the footer section of the site.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => 'Footer Widget Area 3',
		'id'            => 'sidebar-5',
		'description'   => 'Appears in the footer section of the site.' ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
}
add_action( 'widgets_init', 'shisan_widgets_init' );

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Shisan 1.0
 *
 * @return void
 */
function shisan_scripts() {

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array() );

	// Load our main stylesheet.
	wp_enqueue_style( 'shisan-style', get_stylesheet_uri(), array(),'20181009');

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'shisan-ie', get_template_directory_uri() . '/css/ie.css', array( 'shisan-style' ), '20181009' );
	wp_style_add_data( 'shisan-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	wp_enqueue_script( 'shisan-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20181009', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '20181009', true );

	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array() );
    if (is_singular() && comments_open()){
            wp_enqueue_script( 'shisan-ajax-comment', get_template_directory_uri() . '/js/ajax-comment.js', array( 'jquery' ), '1.0' ,true);
            wp_localize_script( 'shisan-ajax-comment', 'ajaxcomment', array( 'ajax_url'   => admin_url('admin-ajax.php')));
    }
}
add_action( 'wp_enqueue_scripts', 'shisan_scripts' );

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Shisan 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function shisan_body_classes( $classes ) {
    $classes[] = 'sidebar-no';
	if ( is_single() ) {
		$classes[] = 'intro-effect-fadeout';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}
	if ( is_front_page()  ) {
		$classes[] = 'slider';
	}

	return $classes;
}
add_filter( 'body_class', 'shisan_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since Shisan 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function shisan_post_classes( $classes ) {
	if ( ! post_password_required() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}
	return $classes;
}
add_filter( 'post_class', 'shisan_post_classes' );


/* Related posts */
function shisan_the_related_posts() {
	global $post;
	$tags = wp_get_post_tags($post->ID);

	if ($tags) {
		$tag_ids = array();

		foreach($tags as $individual_tag) {
			$tag_ids[] = $individual_tag->term_id;
		}

		$args = array(
			'tag__in'             => $tag_ids,
			'post__not_in'        => array($post->ID),
			'posts_per_page'      => 8, // Number of related posts to display.
			'ignore_sticky_posts' => 1
		);

		$my_query = new wp_query( $args ); ?>

		<h2 class="related-articles-title">Related articles</h2>
		<div class="related-articles">
			<?php
			while( $my_query->have_posts() ) {
				$my_query->the_post(); ?>

				<div class="related-thumb col-sm-3 col-md-3 col-lg-3">
					<a rel="external" href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail(array(500,350)); ?>
						<div class="related-content">
							<h2><?php the_title(); ?></h2>
						</div>
					</a>
				</div>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
    <?php
	}
	wp_reset_postdata();
	wp_reset_query();
}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Shisan 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function shisan_wp_title( $title ) {
	global $paged, $page;

    if ( ! $title ) {
        return $title;
    }

	if ( is_feed() ) {
		return $title;
	}

    if ( !empty($title['page']) ) {
        $title['page'] = str_replace('Page', '页', $title['page']);
    }

    if ( is_404() ) {
		$title['title'] = '页面未找到';
	} elseif ( is_search() ) {
		$title['title'] = sprintf( '查找结果 &#8220;%s&#8221; ' , get_search_query() );
	} elseif ( is_year() ) {
		$title['title'] =sprintf( '%s 年' , get_the_date('Y') );
	} elseif ( is_month() ) {
		$title['title'] = sprintf( '%s 月' , get_the_date('Y/m') );
	} elseif ( is_day() ) {
		$title['title'] = sprintf( '%s 日' , get_the_date(get_option('date_format') ));
	}

	return $title;
}
add_filter( 'document_title_parts', 'shisan_wp_title' );

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

require get_template_directory(). '/inc/ajax-comment.php' ;
/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content.php';
}

/**
 * Create HTML list of nav menu items.
 * Replacement for the native Walker, using the description.
 *
 * @see    http://wordpress.stackexchange.com/q/14037/
 * @author toscho, http://toscho.de
 */
class Shisan_Header_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes         = empty ( $item->classes ) ? array () : (array) $item->classes;
		$has_description = '';

		$class_names = join(
			' '
		,   apply_filters(
				'nav_menu_css_class'
			,   array_filter( $classes ), $item
			)
		);

		// insert description for top level elements only
		// you may change this
		$description = ( ! empty ( $item->description ) )
			? '<small>' . esc_attr( $item->description ) . '</small>' : '';

		$has_description = ( ! empty ( $item->description ) )
			? 'has-description ' : '';

		! empty ( $class_names )
			and $class_names = ' class="' . $has_description . esc_attr( $class_names ) . '"';

		$output .= "<li id='menu-item-$item->ID' $class_names>";

		$attributes  = '';

		if ( !isset($item->target) ) {
			$item->target = '';
		}

		if ( !isset($item->attr_title) ) {
			$item->attr_title = '';
		}

		if ( !isset($item->xfn) ) {
			$item->xfn = '';
		}

		if ( !isset($item->url) ) {
			$item->url = '';
		}

		if ( !isset($item->title) ) {
			$item->title = '';
		}

		if ( !isset($item->ID) ) {
			$item->ID = '';
		}

		if ( !isset($args->link_before) ) {
			$args = new stdClass();
			$args->link_before = '';
		}

		if ( !isset($args->before) ) {
			$args->before = '';
		}

		if ( !isset($args->link_after) ) {
			$args->link_after = '';
		}

		if ( !isset($args->after) ) {
			$args->after = '';
		}

		! empty( $item->attr_title )
			and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
		! empty( $item->target )
			and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
		! empty( $item->xfn )
			and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
		! empty( $item->url )
			and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$item_output = $args->before
			. "<a $attributes>"
			. $args->link_before
			. '<span>' . $title . '</span>'
			. $description
			. '</a> '
			. $args->link_after
			. $args->after;

		// Since $output is called by reference we don't need to return anything.
		$output .= apply_filters(
			'walker_nav_menu_start_el'
		,   $item_output
		,   $item
		,   $depth
		,   $args
		);
	}
}

/**
 * 作用: 进行时间比较。
 * 参数: $from string 开始时间
 * 参数: $to string 结束时间
 * 参数: $before string 前修饰文字
 * 参数: $after string 后修饰文字
 * 返回值: string
 * 来源: 破袜子原创
 */
function shisan_timediff( $from, $to, $before, $after) {
  if ( empty($from) || empty($to) )
  return '';
  if( empty($before) )
  $before = '于';
  if( empty($after) )
  $after = '前';
  $from_int = strtotime($from) ;
  $to_int = strtotime($to) ;
  $diff_time = abs($to_int - $from_int) ;
  if ( $diff_time > 60 * 60 * 24 * 365 ){//年
  $num = round($diff_time / (60 * 60 * 24 * 365));
  $uni = '年';
  }
  else if ( $diff_time > 60 * 60 * 24 * 31 ) {//月
  $num = round($diff_time / (60 * 60 * 24 * 30));
  $uni = '个月';
  }
  else if ( $diff_time > 60 * 60 * 24 ) {//天
  $num = round($diff_time / (60 * 60 * 24));
  $uni = '天';
  }
  else if ( $diff_time > 60 * 60 ) { //小时
  $num = round($diff_time / 3600);
  $uni = '小时';
  }
  else { //分钟
  $num = round($diff_time / 60);
  $uni = '分';
  }
  $return = $before.$num.$uni.$after ;
  return $return;
}

/**
 * 作用: 取得文章发表的相对时间。
 * 返回值: string
 * 来源: 破袜子原创
 */
function shisan_rel_post_date() {
  global $post;
  $post_date_time = mysql2date('j-n-Y H:i:s', $post->post_date, false);
  $current_time = current_time('timestamp');
  $date_today_time = gmdate('j-n-Y H:i:s', $current_time);
  return shisan_timediff( $post_date_time, $date_today_time ,'&nbsp;','前' ) ;
}

/**
 * 作用: 取得评论发表的相对时间。
 * 返回值: string
 * 来源: 破袜子原创
 */
function shisan_rel_comment_date() {
  global $post , $comment;
  $post_date_time = mysql2date('j-n-Y H:i:s', $post->post_date, false);
  $comment_date_time = mysql2date('j-n-Y H:i:s', $comment->comment_date, false);
  return shisan_timediff( $post_date_time, $comment_date_time ,'&nbsp;','后' ) ;
}

/**
 * AJAX-comment
 */
require_once get_parent_theme_file_path( '/inc/ajax-comment.php' );
