<?php
/**Abrège le getImage afin de pouvoir utiliser celui-ci plutot que celui d'ACF pour éviter le plus de query possible à la BD
 *
 * @param $attachment_id
 * @param string $size
 * @param bool $icon
 * @param string $attr
 * @return mixed
 */
function getImage($attachment_id, $size = 'thumbnail', $icon = false, $attr = ''){
    return wp_get_attachment_image($attachment_id, $size, $icon, $attr);
}

/**Abrège le getImage afin de pouvoir utiliser celui-ci plutot que celui d'ACF pour éviter le plus de query possible à la BD
 *
 * @param $postId
 * @param $size : string
 * @param $attr : array
 * @return mixed
 */
function getThumbnail($postId = null, $size = 'thumbnail', $attr = ''){
    return get_the_post_thumbnail($postId, $size, $attr);
}

/**
 * Retourne tous les formats de l'image
 * @return array
 */
function getSizes(){
    return (get_intermediate_image_sizes());
}


/**
 * Récupère les meta-box (ACF)
 *
 * @param $post_id
 * @param string $key
 * @param bool $single
 * @return mixed
 */
function getData( $post_id, $key = '', $single = false ){
    return get_post_meta( $post_id, $key, $single );
}


/**
 * Récupère les information du fichier.
 *
 * @param $file_ID
 * @return array
 */
function getFile($file_ID){
    $file = get_attached_file( $file_ID );
    return [
        'filesize'  => size_format( filesize( $file ) ),
        'filetype'  => wp_check_filetype( $file )['ext'],
        'url'       => wp_get_attachment_url( $file_ID ),
        'title'     => get_the_title( $file_ID )
    ];
}

/**
 * Modifie les dimensions des images
 */
function changeImageSize($size = 'thumbnail', $size_w, $size_h, $crop = true){
    update_option( $size . '_size_w', $size_w );
    update_option( $size . '_size_h', $size_h );
    update_option( $size . '_crop', $crop);
}


/**
 * Permet de récupérer le fils d'ariane
 *
 * @return string html value
 */

function getBreadcrumb($separator_before='|', $separator_after='', $home ='<i class="fa fa-home" aria-hidden="true"></i>')
{
    global $post;
    ?>
    <div class="row breadcrumb">
        <div class="col-lg-12">
            <?php // Breadcrumb navigation
            if (is_page() && !is_front_page() || is_single() || is_category() || is_archive()) {
                echo '<ul>';
                echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="breadcrumb-home">
            <a title="Accueil" rel="nofollow" href="' . get_option('siteurl') . '"  itemprop="url">
            ' . $home . '<span itemprop="title" class="sr-only">Accueil</span></a></li>';

                if (is_page()) {
                    $ancestors = get_post_ancestors($post);

                    if ($ancestors) {
                        $ancestors = array_reverse($ancestors);

                        foreach ($ancestors as $crumb) {
                            echo '<li class="separator">' . $separator_before . '</li><li><a href="' . get_permalink($crumb) . '" itemprop="url"><span itemprop="title">' . get_the_title($crumb) . '</span></a></li><li class="separator">' . $separator_after . '</li>';
                        }
                    }
                }
                if (is_archive()) {

                    $post_type = get_post_type_object( get_post_type($post) );

                    if($post_type->name!='post'){
                        echo '<li class="separator">' . $separator_before . '</li><li><a href="' . get_category_link($category[0]->cat_ID) . '" itemprop="url"><span itemprop="title">' . $post_type->label . '</span></a></li><li class="separator">' . $separator_after . '</li>';
                    }
                    else{
                        //vérifie s'il y a une page blogue de configurer.
                        if ( locate_template( 'template-parts/blogue.php' ) != '' ) {

                            $args = array(
                                'post_type' => 'page',
                                'posts_per_page'=> 1,
                                'fields' => 'ids',
                                'meta_key' => '_wp_page_template',
                                'meta_value' => 'template-parts/blogue.php'
                            );
                            $page = get_posts( $args );

                            if($page){
                                $page_title = get_the_title($page[0]);
                                $page_link = get_permalink($page[0]);
                                echo '<li class="separator">' . $separator_before . '</li><li><a href="' . $page_link . '" itemprop="url"><span itemprop="title">' . $page_title . '</span></a></li><li class="separator">' . $separator_after . '</li>';
                            }
                        }
                    }


                }

                if (is_single()) {

                    $post_type = get_post_type_object( get_post_type($post) );
                    $archive_link = '';
                    $archive_title = '';
                    if($post_type->name!='post') {
                        $archive_link = get_post_type_archive_link(get_post_type($post));
                        $archive_title = $post_type->label;
                    }
                    else{
                        //vérifie s'il y a une page blogue de configurer.
                        if ( locate_template( 'template-parts/blogue.php' ) != '' ) {

                            $args = array(
                                'post_type' => 'page',
                                'posts_per_page'=> 1,
                                'fields' => 'ids',
                                'meta_key' => '_wp_page_template',
                                'meta_value' => 'template-parts/blogue.php'
                            );
                            $page = get_posts( $args );

                            if($page){
                                $archive_title = get_the_title($page[0]);
                                $archive_link = get_permalink($page[0]);
                            }
                        }
                    }


                    //vérifie s'il y a une archive.
                    if(!empty($archive_title) && !empty($archive_link)){
                        echo '<li class="separator">' . $separator_before . '</li><li><a href="' . $archive_link . '" itemprop="url"><span itemprop="title">' . $archive_title . '</span></a></li><li class="separator">' . $separator_after . '</li>';
                    }

                    $category = get_the_category();
                    if($category){
                        echo '<li class="separator">' . $separator_before . '</li><li><a href="' . get_category_link($category[0]->cat_ID) . '" itemprop="url"><span itemprop="title">' . $category[0]->cat_name . '</span></a></li><li class="separator">' . $separator_after . '</li>';
                    }




                }

                if (is_category()) {
                    $category = get_the_category();
                    echo '<li class="separator">' . $separator_before . '</li><li><span itemprop="title">' . $category[0]->cat_name . '</span></li><li class="separator">' . $separator_after . '</li>';
                }

                // Current page
                if (is_page() || is_single()) {
                    echo '<li class="separator">' . $separator_before . '</li><li><span itemprop="title">' . get_the_title() . '</span></li><li class="separator">' . $separator_after . '</li>';
                }
                echo '</ul>';
            } elseif (is_front_page()) {
                // Front page
                echo '<ul>';
                echo '<li><a title="Accueil" rel="nofollow" href="' . get_option('siteurl') . '"  itemprop="url"><span itemprop="title">Accueil</span></a></li><li class="separator">' . $separator_after . '</li>';
                echo '</ul>';
            }
            ?>
        </div>
    </div>
    <?php
}