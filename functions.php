<?php
//
// Recommended way to include parent theme styles.
//  (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
//  
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'parent-style' ]
	);
}

//
// Your code goes below
//

/**
 * Adding ACF options page
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page();
}


add_action( 'wp_enqueue_scripts', 'load_scripts' );

function load_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'flex_js', '/wp-content/themes/correctcoder-child/inc/jquery.flexslider.js', [ 'jquery' ] );
	wp_enqueue_script( 'flex_min_js', '/wp-content/themes/correctcoder-child/inc/jquery.flexslider-min.js', [ 'jquery' ] );
	wp_enqueue_style( 'flex_css', '/wp-content/themes/correctcoder-child/inc/flexslider.css' );
}


add_shortcode( 'tagline_slider', 'build_slider' );

function build_slider() {

	$slides = [];

	if ( have_rows( 'slides', 'options' ) ) {
		while ( have_rows( 'slides', 'options' ) ) :
			the_row();
			// Your loop code
			$text = get_sub_field( 'text' );
			array_push( $slides, $text );
		endwhile;
	}

	if ( $slides ) {
		//$slides = array_reverse($slides);
		$slide_text = "";
		foreach ( $slides as $slid ) {
			# code...
			$t          = '' . $slid;
			$slide_text .= '<li>' . sanitize_text_field( $slid ) . '</li>';
		}
	}

	if ( get_field( 'styles', 'options' ) ) {
		$styles = get_field( 'styles', 'options' );
	}
	return '<style>' . $styles . '</style>' .

	       '<script>
		jQuery(document).ready(function ($) {
			$(".flexslider").flexslider({
				controlNav: false,
				directionNav: false
			});

		});
    </script>' .
	       '<div class="main flexslider">' .
	       '<ul class="slides">' .
	       '' . $slide_text . '' .
	       '</ul>' .
	       '</div>';
}
