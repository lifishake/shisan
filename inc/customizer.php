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
      'description' => '指定特色内容的文章编号，或者某个标签的最新内容。优先显示编号，最多显示4篇文章。',
      'priority'    => 130,
      'theme_supports' => 'featured-content',
    ) );

    // Add Featured Content settings.
    $wp_customize->add_setting( 'featured_post_ids', array(
      'default'              => '0',
      'type'                 => 'option',
      'sanitize_js_callback' => 'esc_attr',
    ) );
    $wp_customize->add_setting( 'featured_post_tag', array(
      'default'              => 'default',
      'type'                 => 'option',
      'sanitize_js_callback' => 'esc_attr',
    ) );

    // Add Featured Content controls.
    $wp_customize->add_control( 'featured_post_ids', array(
      'label'    => '特色文章号',
      'section'  => 'featured_content',
      'priority' => 20,
    ) );
    $wp_customize->add_control( 'featured_post_tag', array(
      'label'    => '特色标签',
      'section'  => 'featured_content',
      'priority' => 30,
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
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Shisan 1.0
 */
function shisan_customize_preview_js() {
	wp_enqueue_script( 'shisan_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20131205', true );
}
add_action( 'customize_preview_init', 'shisan_customize_preview_js' );
