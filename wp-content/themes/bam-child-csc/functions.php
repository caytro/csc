<?php



/* insertion du theme parent */

	
	// enqueue parent theme stylesheet
	
	add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
	
function my_theme_enqueue_styles() {
    $parenthandle = 'bam'; 
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'csc', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}