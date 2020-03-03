<?php
/**
 * Permet de lister les pages archives dans les menus
 * Class el_archive_pages_menu
 */
class el_archive_pages_menu{

    public function __construct(){
        add_action('admin_init', array($this, 'add_meta_box'));
    }
    //add metabox to the navmenu builder
    public function add_meta_box(){
        add_meta_box(
            'el_archive_page_menu_metabox',
            __('Archive Pages', 'archive-pages-to-menu'),
            array($this, 'display_meta_box'),
            'nav-menus',
            'side',
            'low'
        );
    }
    //output for the metabox
    public function display_meta_box(){

        ?>
        <div id="posttype-archive-pages" class="posttypediv">
            <div id="tabs-panel-archive-pages" class="tabs-panel tabs-panel-active">
                <p>Affiche toutes les pages archives, que votre site vous permet</p>
                <ul id="archive-pages" class="categorychecklist form-no-clear">
                    <!--Custom -->
                    <?php
                    //loop through all registered content types that have 'has-archive' enabled
                    $post_types = get_post_types(array('has_archive' => true));
                    if($post_types){
                        $counter = -1;
                        foreach($post_types as $post_type){
                            $post_type_obj = get_post_type_object($post_type);
                            $post_type_archive_url = get_post_type_archive_link($post_type);
                            $post_type_name = $post_type_obj->labels->singular_name;
                            ?>
                            <li>
                                <label class="menu-item-title">
                                    <input type="checkbox" class="menu-item-checkbox" name="menu-item[<?php echo $counter; ?>][menu-item-object-id]" value="-1"/>Archive Page: <?php echo $post_type_name; ?>
                                </label>
                                <input type="hidden" class="menu-item-type" name="menu-item[<?php echo $counter; ?>][menu-item-type]" value="custom"/>
                                <input type="hidden" class="menu-item-title" name="menu-item[<?php echo $counter; ?>][menu-item-title]" value="<?php echo $post_type_name; ?>"/>
                                <input type="hidden" class="menu-item-url" name="menu-item[<?php echo $counter; ?>][menu-item-url]" value="<?php echo $post_type_archive_url; ?>"/>
                                <input type="hidden" class="menu-item-classes" name="menu-item[<?php echo $counter; ?>][menu-item-classes]"/>
                            </li>
                            <?php
                            $counter--;
                        }
                    }?>
                </ul>
            </div>
            <p class="button-controls">
            <span class="list-controls">
                <a href="<?php echo admin_url('nav-menus.php?page-tab=all&selectall=1#posttype-archive-pages'); ?>" class="select-all"> <?php _e('Select All', 'archive-pages-to-menu' ); ?></a>
            </span>
                <span class="add-to-menu">
                <input type="submit" class="button-secondary submit-add-to-menu right" value="<?php _e('Add to Menu', 'archive-pages-to-menu') ?>" name="add-post-type-menu-item" id="submit-posttype-archive-pages">
                <span class="spinner"></span>
            </span>
            </p>
        </div>
        <?php
    }

}
$el_archive_pages_menu = new el_archive_pages_menu();