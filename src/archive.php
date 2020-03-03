<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package base
 */

get_header();
?>

<main id="archives" class="archives">

    <?php if ( have_posts() ) : //vérifie s'il y a des posts?>

        <header class="archives__header">
            <?php
            the_archive_title( '<h1 class="page-title">', '</h1>' );
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </header><!-- .page-header -->

        <?php
        //liste des postes
        while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/content', get_post_type() );
        endwhile;

    else :

        get_template_part( 'template-parts/content', 'none' );

    endif; ?>

</main><!-- #main -->

<?php
get_footer();
