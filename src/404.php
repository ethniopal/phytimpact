<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package base
 */

get_header();
?>

<main id="main" class="site-main">

    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title">
                <?= esc_html__( 'Oups! Cette page est introuvable.', ThemeName ) ?>
            </h1>
        </header><!-- .page-header -->

        <div class="page-content">
            <p><?= esc_html__( "Il semble que rien n'ait été trouvé à cet endroit. Essayez peut-être l'un des liens ci-dessous ou une recherche?", ThemeName ) ?></p>

            <?= get_search_form() ?>
            <?= do_shortcode('[sitemap]') ?>

        </div><!-- .page-content -->
    </section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();
