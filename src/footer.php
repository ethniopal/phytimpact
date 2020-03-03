<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package base
 */

?>

<footer class="footer">
    <div class="footer__author">
        <a href="<?= esc_url( __( ThemeAuthorUrl , ThemeAuthorUrl ) )?>">
            <?php
            printf( esc_html__( 'Créer par %s', ThemeName ), ThemeAuthor );
            ?>
        </a>
    </div><!-- .site-info -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
