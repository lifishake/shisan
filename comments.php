<?php
/**
 * 用来显示留言的模板
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-container">

	<?php if ( have_comments() ) : ?>

	<h2 class="comments-title">
		<?php
        $comment_arg=array();
        $comment_arg['post_id']=get_the_ID();
        $comment_arg['count']='true';
        $comment_arg['user_id']=0;/*don't count for known users*/
        $comment_arg['type']='comment';
        $comment_arg['status']='approve';
    printf('已有%1$s条评论', get_comments($comment_arg) );
		?>
	</h2>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
        <?php the_comments_pagination( array(
			'prev_text' => '&larr;<span class="screen-reader-text">前一页</span>',
			'next_text' => '<span class="screen-reader-text">后一页</span>&rarr;',
		) );?>
	</nav><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>

<?php
    $args =  array(
        'style'      => 'ol',
        'short_ping' => true,
        'avatar_size'=> 64,
        'type'=>'comment',
         'callback'=>'shisan_comment_cbk',
    );
    if ( is_page() ) {
        $args = array_merge($args, array('reverse_top_level'=>true,  'max_depth'=>2,'depth'=>2));
    }
 ?>
	<ol class="commentlist">
		<?php
			wp_list_comments($args);
		?>
	</ol><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text">评论导航</h1>
		<div class="nav-previous"> '&larr; '</div>
		<div class="nav-next">‘&rarr;'</div>
	</nav><!-- #comment-nav-below -->
	<?php endif; // Check for comment navigation. ?>

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments">评论已关闭。</p>
	<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php get_template_part( 'inc/input', 'fields' ); ?>


</div><!-- #comments -->

<?php
function shisan_comment_cbk( $comment,  $args, $depth ) {
    $comment_author_url = $comment->comment_author_url;
    $avatar_img = get_avatar( $comment, $args['avatar_size'] );
    $comment_author_name = $comment->comment_author;
    $parent_comment_id = $comment->comment_parent ;
 ?>
 		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( ); ?>>
 			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
 				<footer class="comment-meta">
 					<div class="comment-author vcard">
 						<?php  if ( $comment_author_url ) {
                            printf('<a class="url" href="%1$s" target="_blank" rel="external nofollow" title="%2$s">%3$s</a>', $comment_author_url, $comment_author_name, $avatar_img);
                        } else {
                            echo $avatar_img;
                        }
                         ?>
 					</div><!-- .comment-author -->

 					<div class="comment-metadata">
                             <?php if (''===$comment_author_url || $parent_comment_id > 0) {
                                        printf( '<b class="fn author-url">%s</b>', get_comment_author_link( $comment ) );
                                    }
                                       if ( $parent_comment_id > 0 ) {
                                         printf( '<span class="mention"> @%1s </span>', get_comment_author($parent_comment_id) );
                                     } ?>
 							<time datetime="<?php comment_time( 'c' ); ?>">
 								<?php
 									echo shisan_rel_comment_date();
 								?>
 							</time>
                                    <?php
                                    comment_reply_link( array_merge( $args, array(
                     					'add_below' => 'div-comment',
                     					'depth'     => $depth,
                     					'max_depth' => $args['max_depth'],
                                             'reply_text'=> '@TA'
                     				) ) );
                                     ?>
 					</div><!-- .comment-metadata -->

 					<?php if ( '0' == $comment->comment_approved ) : ?>
 					<p class="comment-awaiting-moderation">评论审核中…</p>
 					<?php endif; ?>
 				</footer><!-- .comment-meta -->

 				<div class="comment-content">
 					<?php comment_text(); ?>
 				</div><!-- .comment-content -->

 				<?php

 				?>
 			</article><!-- .comment-body -->
 <?php
}
