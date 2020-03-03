<?php



// ACF Custom Blocks **************************************************************************************
function register_acf_block_types() {

    // register a testimonial block.
    acf_register_block_type(array(
        'name'              => 'testimonial',
        'title'             => __('Testimonial'),
        'description'       => __('A custom testimonial block.'),
        'render_template'   => 'template-parts/blocks/testimonial/testimonial.php',
        'category'          => 'components',
        'icon'              => 'admin-comments',
        'keywords'          => array( 'testimonial', 'quote' ),
    ));
    wp_enqueue_style( 'block-testimonial', get_stylesheet_directory_uri() . '/template-parts/blocks/testimonial/testimonial.css');

}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'register_acf_block_types');
}



/**
 * Custom block category
 */
function my_blocks_plugin_block_categories( $categories ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'components',
                'title' => __( 'Composante du thème', ThemeName ),
                'icon'  => 'images-alt',
            ),
        )
    );
}
add_filter( 'block_categories', 'my_blocks_plugin_block_categories', 10, 2 );