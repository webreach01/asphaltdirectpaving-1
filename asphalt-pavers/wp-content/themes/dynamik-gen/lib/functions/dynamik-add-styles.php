<?php
/**
 * Enqueue/Echo the Dynamik stylesheets/CSS.
 *
 * @package Dynamik
 */

remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'genesis_meta', 'dynamik_load_stylesheets' );
/**
 * Enqueue appropriate stylesheets.
 *
 * @since 1.6.2
 */
function dynamik_load_stylesheets()
{
	add_action( 'wp_enqueue_scripts', 'dynamik_add_stylesheets', 5 );
}
/**
 * Determine which stylesheet should be displayed and where
 * based on the Dynamik options.
 *
 * @since 1.0
 */
function dynamik_add_stylesheets()
{
	global $dynamik_css_builder_popup;
	
    if( !dynamik_get_design( 'minify_css' ) || $dynamik_css_builder_popup )
	{
		if( file_exists( dynamik_get_design_stylesheet_path() ) )
		{
			wp_enqueue_style( 'dynamik_design_stylesheet', dynamik_get_design_stylesheet_url(), array(), filemtime( dynamik_get_design_stylesheet_path() ) );
		}
		else
		{
			wp_enqueue_style( 'dynamik_genesis_stylesheet', PARENT_URL . '/style.css', array(), PARENT_THEME_VERSION );
		}
		if( file_exists( dynamik_get_active_skin_folder_path() . '/style.css' ) && !dynamik_get_design( 'minify_css' ) )
		{
			wp_enqueue_style( 'dynamik_skin_stylesheet', dynamik_get_active_skin_folder_url() . '/style.css', array(), filemtime( dynamik_get_active_skin_folder_path() . '/style.css' ) );
		}
		if( file_exists( dynamik_get_custom_stylesheet_path() ) && !$dynamik_css_builder_popup )
		{
			wp_enqueue_style( 'dynamik_custom_stylesheet', dynamik_get_custom_stylesheet_url(), array(), filemtime( dynamik_get_custom_stylesheet_path() ) );
		}
    }
    elseif( dynamik_get_design( 'minify_css' ) )
	{
		if( file_exists( dynamik_get_minified_stylesheet_path() ) )
		{
			wp_enqueue_style( 'dynamik_minified_stylesheet', dynamik_get_minified_stylesheet_url(), array(), filemtime( dynamik_get_minified_stylesheet_path() ) );
		}
		else
		{
			wp_enqueue_style( 'dynamik_genesis_stylesheet', PARENT_URL . '/style.css', array(), PARENT_THEME_VERSION );
		}
    }
    if( dynamik_get_design( 'font_awesome_css' ) )
	{
		wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/' . DYN_FONT_AWESOME_VERSION . '/css/font-awesome.min.css', array(), DYN_FONT_AWESOME_VERSION );
	}
}

add_action( 'wp_head', 'dynamik_css_builder_css_echo', 15 );
/**
 * If the Front-end CSS Builder is active then echo the Custom CSS
 * and Dynamik Design media query content into the <head>.
 *
 * @since 1.0
 */
function dynamik_css_builder_css_echo()
{
	global $dynamik_css_builder_popup;
	
	if( !$dynamik_css_builder_popup )
		return;
	
	$output = '';
    $custom_css = dynamik_get_custom_css( 'custom_css' );

	if( $custom_css != '' )
	{
		$output .= $custom_css . "\n";
	}
	
	$output = "\n\n<!-- Begin Dynamik Custom CSS -->\n<style id=\"custom-css-echo\" type=\"text/css\">\n" . dynamik_preserve_backslashes( $output ) . "</style>\n<!-- End Dynamik Custom CSS -->\n";

	if( dynamik_get_settings( 'responsive_enabled' ) )
	{
		$media_query_css = '
@media only screen and (max-width: ' . dynamik_get_responsive( 'media_query_large_cascading_width' ) . 'px) {
' . dynamik_get_responsive( 'media_query_large_cascading_content' ) . '
}
@media only screen and (min-width: ' . dynamik_get_responsive( 'dynamik_media_query_large_min_width' ) . 'px) and (max-width: ' . dynamik_get_responsive( 'dynamik_media_query_large_max_width' ) . 'px) {
' . dynamik_get_responsive( 'media_query_large_content' ) . '
}
@media only screen and (min-width: ' . dynamik_get_responsive( 'dynamik_media_query_medium_large_min_width' ) . 'px) and (max-width: ' . dynamik_get_responsive( 'dynamik_media_query_medium_large_max_width' ) . 'px) {
' . dynamik_get_responsive( 'media_query_medium_large_content' ) . '
}
@media only screen and (max-width: ' . dynamik_get_responsive( 'media_query_medium_cascading_width' ) . 'px) {
' . dynamik_get_responsive( 'media_query_medium_cascading_content' ) . '
}
@media only screen and (min-width: ' . dynamik_get_responsive( 'dynamik_media_query_medium_min_width' ) . 'px) and (max-width: ' . dynamik_get_responsive( 'dynamik_media_query_medium_max_width' ) . 'px) {
' . dynamik_get_responsive( 'media_query_medium_content' ) . '
}
@media only screen and (max-width: ' . dynamik_get_responsive( 'media_query_small_width' ) . 'px) {
' . dynamik_get_responsive( 'media_query_small_content' ) . '
}';

		$media_query_css = "\n<!-- Begin Media Query Custom CSS -->\n<style id=\"media-query-custom-css-echo\" type=\"text/css\">" . dynamik_preserve_backslashes( $media_query_css ) . "\n</style>\n<!-- End Media Query Custom CSS -->\n\n";
	}
	else
	{
		$media_query_css = '';
	}
	
	echo stripslashes( $output . $media_query_css );
}
