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
function shisan_posted_on() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		echo '<span class="sticky-featured-post"><span class="glyphicon glyphicon-pushpin"></span></span>';
	}
	printf( '<span class="postdate"><span class="glyphicon glyphicon-calendar"></span><time class="entry-date published updated" datetime="%1$s">%2$s</time></span>',
    get_the_date( DATE_W3C ),
    shisan_rel_post_date() );
}
endif;

if ( ! function_exists( 'shisan_weather' ) ) :
function shisan_weather( $param='notext' ) {
    if (!function_exists('apip_get_heweather'))
        return;
    $weather = apip_get_heweather($param);
    if ( ''===$weather ) {
        return;
    }
    printf('<span class="postweather">%s</span>', $weather);
}
endif;

if ( ! function_exists( 'shisan_cat' ) ) :
function shisan_cat() {
    printf('<span class="cat-links"><span class="glyphicon glyphicon-folder-open"></span> %s</span>',shisan_get_categories_trace());
}
endif;

if ( ! function_exists( 'shisan_comment' ) ) :
function shisan_comment() {
    if ( post_password_required() || ( !comments_open() ) )
        return;
    echo '<span class="comments-link"><span class="glyphicon glyphicon-comment"></span>';
    comments_popup_link('0','1','%');
    echo '</span>';
}
endif;

function shisan_get_categories_trace(){
      $category = get_the_category();
      if ( empty( $category) )  {
          return '';
      }
      $catID = $category[0]->cat_ID;
      $return = get_category_parents($catID, true, ' &raquo; ', false);
      $pos = strrpos($return,"&raquo;");
      if ( $pos !== false ) {
            $return = substr_replace($return, "", -8,8);
        }
        return $return;
}

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
  $from_int = strtotime($from) ;
  $to_int = strtotime($to) ;
  $diff_time = abs($to_int - $from_int) ;
  if ( $diff_time > 60 * 60 * 24 * 365 ){//年
  $num = round($diff_time / (60 * 60 * 24 * 365));
  $uni = '年';
  }
  else if ( $diff_time > 60 * 60 * 24 * 31 ) {//月
  $num = round($diff_time / (60 * 60 * 24 * 30));
  $uni = '月';
  }
  else if ( $diff_time > 60 * 60 * 24 ) {//天
  $num = round($diff_time / (60 * 60 * 24));
  $uni = '天';
  }
  else if ( $diff_time > 60 * 60 ) { //小时
  $num = round($diff_time / 3600);
  $uni = '时';
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
  $date_today_time =  gmdate('j-n-Y H:i:s', $current_time);
  return shisan_timediff( $post_date_time, $date_today_time ,'','前' ) ;
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
  return shisan_timediff( $post_date_time, $comment_date_time ,'','后' ) ;
}

if ( ! function_exists( 'shisan_the_related_posts' ) ) :
function shisan_the_related_posts($limit = 4) {
    if ( !function_exists('apip_random_post') )
        return;
	global  $wpdb;
    $object_ids = array();
    $post_id = get_the_ID() ;
    $tags = get_the_terms( $post_id, 'post_tag') ;
    $cats = get_the_terms( $post_id, 'category') ;
    if( $tags && count($tags) != 0 )
    {
        if (  count($tags) > 1 )
        {
            $tags = array_merge( $tags, $cats ) ;
        }
        $term_taxonomy_ids = wp_list_pluck( $tags, 'term_taxonomy_id' );
        $term_taxonomy_ids_str = implode( ",", $term_taxonomy_ids  );
        $query = "SELECT rel.`object_id`, SUM(v.`term_weight`) AS `evaluate`
                FROM {$wpdb->term_relationships} rel, `{$wpdb->prefix}v_taxonomy_summary` v
                WHERE rel.`term_taxonomy_id` IN ({$term_taxonomy_ids_str})
                AND rel.`term_taxonomy_id` = v.`term_taxonomy_id`
                AND rel.`object_id` != '$post_id'
                GROUP BY rel.`object_id`
                ORDER BY `evaluate` DESC,
                rel.`object_id` DESC";
        $weights = $wpdb->get_results($query,OBJECT_K);
        $object_ids = wp_list_pluck( $weights, 'object_id','object_id' );
    }

    if ( count( $object_ids )< $limit )
    {
        $random_posts = apip_random_post( get_the_ID(), $limit - count( $object_ids ) + 1 ) ;
        if ( count($random_posts) > 0 )
        {
            $random_ids = wp_list_pluck( $random_posts, 'ID','ID' );
            $object_ids = array_merge( $object_ids, $random_ids ) ;
        }
    }
    while( count($object_ids) > $limit )
    {
        array_pop($object_ids) ;
    }
    ?>
    <h2 class="related-articles-title">关联文章</h2>
        <div class="related-articles">
            <?php
            $default = sprintf('<img src="%1$s" class="attachment-shisan-related size-shisan-related wp-post-image" alt="" sizes="(max-width: 333px) 100vw, 333px" data-src="%1$s" data-unveil="true" style="opacity: 1;" width="333" height="250">',
                get_template_directory_uri()."/images/default.jpg" );
            foreach ( $object_ids as $id ) :
                if (has_post_thumbnail($id)) {
                    $thumbnail = get_the_post_thumbnail($id,'shisan-related');
                }
                else {
                    $thumbnail = $default;
                }
                printf('<div class="related-thumb col-sm-3 col-md-3 col-lg-3"><a rel="external" href="%1$s">%2$s</a><div class="related-content"><h2>%3$s</h2></div></div>',
                get_permalink( $id ),
                $thumbnail,
                get_the_title( $id )  );/*printf*/
            endforeach;
            ?>
    <div class="clearfix"></div>
    </div>
    <?php
}
endif;
