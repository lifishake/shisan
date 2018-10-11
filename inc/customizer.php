<?php
/**
 * Longform 1.0 Theme Customizer support
 *
 * @package WordPress
 * @subpackage Shisan
 * @since Shisan 1.0
 */

/**
 * Implement Theme Customizer additions and adjustments.
 *
 * @since Shisan 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shisan_customize_register( $wp_customize ) {
	// Add custom description to Colors and Background sections.
    $wp_customize->remove_section('static_front_page');
    $wp_customize->remove_section("colors");
    $wp_customize->remove_section("background_image");
    $wp_customize->remove_section("custom_css");

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = 'Site Title Color';

	// Rename the label to "Display Site Title & Tagline" in order to make this option extra clear.
	$wp_customize->get_control( 'display_header_text' )->label = 'Display Site Title &amp; Tagline';

	// Add the featured content section in case it's not already there.
	$wp_customize->add_section( 'featured_content', array(
		'title'       => '特色内容',
		'description' => sprintf(  '设定一个 <a href="%1$s">标签</a> 作为特色文章的标志。如果没有符合这个标签的文章，则显示 <a href="%2$s">置顶文章</a>', admin_url( '/edit.php?tag=featured' ), admin_url( '/edit.php?show_sticky=1' ) ),
		'priority'    => 130,
	) );

	// Add the featured content layout setting and control.
	$wp_customize->add_setting( 'featured_content_layout', array(
		'default'           => 'slider',
		'sanitize_callback' => 'shisan_sanitize_layout',
	) );

	$wp_customize->add_control( 'featured_content_layout', array(
		'label'   => '页面形式',
		'section' => 'featured_content',
		'type'    => 'select',
		'choices' => array(
			'slider' => 'Slider',
		),
	) );

	// Add General setting panel and configure settings inside it
	$wp_customize->add_panel( 'shisan_general_panel', array(
		'priority'       => 250,
		'capability'     => 'edit_theme_options',
		'title'          => '自定义',
		'description'    =>'主题所支持的自定义内容'
	) );

	// Website logo
	$wp_customize->add_section( 'shisan_general_logo', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => '暂不使用',
		'description'    => '适当的大小 262x80',
		'panel'          => 'shisan_general_panel'
	) );

	$wp_customize->add_setting( 'shisan_logo', array( 'sanitize_callback' => 'esc_url_raw' ) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'shisan_logo', array(
		'label'    =>'网站LOGO',
		'section'  => 'shisan_general_logo',
		'settings' => 'shisan_logo',
	) ) );

}
add_action( 'customize_register', 'shisan_customize_register' );

/**
 * Sanitize the Featured Content layout value.
 *
 * @since Shisan 1.0
 *
 * @param string $layout Layout type.
 * @return string Filtered layout type (grid|slider).
 */
function shisan_sanitize_layout( $layout ) {
	if ( ! in_array( $layout, array( 'slider' ) ) ) {
		$layout = 'slider';
	}

	return $layout;
}

/**
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Shisan 1.0
 */
function shisan_customize_preview_js() {
	wp_enqueue_script( 'shisan_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20131205', true );
}
add_action( 'customize_preview_init', 'shisan_customize_preview_js' );
