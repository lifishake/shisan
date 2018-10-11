<?php
/**
 * Custom template tags for Shisan 1.0
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */
if ( ! function_exists( 'shisan_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @since Shisan 1.0
 *
 * @return void
 */
function shisan_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link',  '<span class="meta-nav">发布于</span>%title' );
			else :
				previous_post_link( '%link',  '<span class="glyphicon glyphicon-chevron-left"></span><span class="post-left">%title</span>' );
				next_post_link( '%link', '<span class="glyphicon glyphicon-chevron-right"></span><span class="post-right">%title</span>' );
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'shisan_posted_on' ) ) :
/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since Shisan 1.0
 *
 * @return void
 */
function shisan_posted_on( $post_id = '' ) {
	global $post;

	// Check if post id given
	if ( $post_id != '' ) {
		$post = get_post( $post_id );
	}

	if ( is_sticky() && is_home() && ! is_paged() ) {
		echo '<span class="sticky-featured-post">顶置</span>';
	}

	// Set up and print post meta information.
	printf( '<span class="byline"><span class="postdate">%3$s</span></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( $post->post_author ) ),
		get_the_author_meta( 'display_name' , $post->post_author)
	);
}
endif;

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 * @since Shisan 1.0
 *
 * @return void
*/
function shisan_post_thumbnail() {
	if ( post_password_required() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_single() ) :
	?>
	<?php
		the_post_thumbnail( 'shisan-huge-width' );
	?>

	<?php else : ?>

	<a class="post-thumbnail animated bounceIn" href="<?php the_permalink(); ?>">
	<?php
		the_post_thumbnail( 'shisan-full-width' );
	?>
	</a>

	<?php endif; // End is_singular()
}

/**
 * 作用: archive标题
 * 来源: 破袜子原创
 */
function shisan_archive_title() {
  /*为了中文化,放弃wordpress自带的the_archive_title()*/
  $format = '%1$s归档方式：%2$s→%3$s%4$s';
  $before = '<h1 class="page-title">';
  $after = '</h1>';
  $part1='';
  $part2='';
  if ( is_category() ) {
  $part1 = '分类';
  $part2 = single_cat_title( '', false );
  }
  else if ( is_tag() ) {
  $part1 = '标签';
  $part2 = single_tag_title( '', false );
  }
  else if ( is_year() ) {
  $part1 = '年';
  $part2 =  get_the_date('Y') ;
  }
  else if ( is_month() ) {
  $part1 = '月';
  $part2 = get_the_date('m/Y');
  }
  else if ( is_day() ) {
  $part1 = '日';
  $part2 = get_the_date(get_option('date_format'));
  }
  else{
  $part1 = '归档';
  }
  $out = sprintf($format, $before, $part1, $part2, $after);
  echo $out ;
}

function shisan_posts_pagination() {
    the_posts_pagination( array(
        'mid_size '=>10,
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
    ) );
}
