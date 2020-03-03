<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package base
 */

get_header();
?>

<main id="page" class="page">

    <?php if ( have_posts() ) : ?>

        <header class="page__header">
            <h1 class="page__title">
                <?php
                /* translators: %s: search query. */
                printf( esc_html__( 'Search Results for: %s', ThemeName ), '<span>' . get_search_query() . '</span>' );
                ?>
            </h1>
        </header><!-- .page-header -->

        <?php
        while ( have_posts() ) :
            the_post();

            get_template_part( 'template-parts/content', 'search' );

        endwhile;

        the_posts_navigation();

    else :

        get_template_part( 'template-parts/content', 'none' );

    endif; ?>

</main><!-- #main -->

<?php
get_footer();
