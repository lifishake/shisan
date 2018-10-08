<?php
/**
 * 用于显示 "没找到"信息
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */
?>

<header class="page-header">
	<h1 class="page-title">没找到</h1>
</header>

<div class="page-content">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

	<p><?php printf(  '来一发? <a href="%1$s">Get started here</a>.', admin_url( 'post-new.php' ) ); ?></p>

	<?php elseif ( is_search() ) : ?>

	<p>没找到，不如试试换个关键字。</p>
	<?php get_search_form(); ?>

	<?php else : ?>

	<p>您要访问的内容长腿跑了，试试把它找回来？</p>
	<?php get_search_form(); ?>

	<?php endif; ?>
</div><!-- .page-content -->
