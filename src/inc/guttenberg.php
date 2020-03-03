<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function editor_setup() {
    // Add support for editor styles.
    add_theme_support( 'editor-styles' );
    $cssEditor = TemplateUrl . '/css/wp-editor.css';
    if(url_exists($cssEditor)) //enqueue les styles si existant
        add_editor_style($cssEditor);
}
add_action( 'after_setup_theme', 'editor_setup' );


/**
 * Permet d'afficher seulement les blocks désiré de l'éditeur
 * @param $allowed_blocks
 * @return array
 */
function misha_allowed_block_types( $allowed_blocks ) {
    return array(
        //commons blocks category
        'core/paragraph',
        'core/image',
        'core/heading',
        'core/gallery',
        'core/list',
        'core/quote',
//        'core/audio',
//        'core/cover', //banner
//        'core/file',
        'core/video',
//
//        //Formatting category
        'core/table',
//        'core/verse',
//        'core/code',
        'core/freeform',
        'core/html',
//        'core/preformatted',
//        'core/pullquote',
//
//        //Layout Elements category
        'core/button',
        'core/text-columns',
        'core/columns',
        'core/media-text',
        'core/more',
//        'core/nextpage',
        'core/separator',
        'core/spacer',
        'core/group',

//
//        //Widget category
        'core/shortcode',
//        'core/archives',
//        'core/categories',
//        'core/latest-comments',
//        'core/latest-posts',
//        'core/calendar',
//        'core/rss',
//        'core/search',
//        'core/tag-cloud',
//
//        //Embeds category
        'core/embed',
        'core-embed/twitter',
        'core-embed/youtube',
        'core-embed/facebook',
        'core-embed/instagram',
//        'core-embed/wordpress',
//        'core-embed/soundcloud',
//        'core-embed/spotify',
//        'core-embed/flickr',
        'core-embed/vimeo',
//        'core-embed/animoto',
//        'core-embed/cloudup',
//        'core-embed/collegehumor',
//        'core-embed/dailymotion',
//        'core-embed/funnyordie',
//        'core-embed/hulu',
//        'core-embed/imgur',
//        'core-embed/issuu',
//        'core-embed/kickstarter',
//        'core-embed/meetup-com',
//        'core-embed/mixcloud',
//        'core-embed/photobucket',
//        'core-embed/polldaddy',
//        'core-embed/reddit',
//        'core-embed/reverbnation',
//        'core-embed/screencast',
//        'core-embed/scribd',
//        'core-embed/slideshare',
//        'core-embed/smugmug',
//        'core-embed/speaker',
//        'core-embed/ted',
//        'core-embed/tumblr',
//        'core-embed/videopress',
//        'core-embed/wordpress-tv'
    );
}
add_filter( 'allowed_block_types', 'misha_allowed_block_types' );


/**
 * Affiche les couleurs de la template
 */
function addPalette($colors = array()){

    if($colors){
        $palette = array();

        //rempli le tableau de palette
        foreach ($colors as $color){
            $singleColor = array(
                'name' => $color,
                'color'	=> $color,
            );
            array_push($palette, $singleColor);
        }

        //ajoute la palete à l'éditeur
        add_theme_support( 'editor-color-palette', $palette);
    }

}