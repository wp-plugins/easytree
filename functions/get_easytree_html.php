<?php
function get_easytree_html() {

// funkcja może zostać użyta tylko raz
if($GLOBALS["get_easytree_html_only_once"]) return;
$GLOBALS["get_easytree_html_only_once"] = true;
// ---

$option_exclude_from_pages = get_option('easytree_option_exclude_from_pages');
$option_display_authors = (bool)get_option('easytree_option_display_authors');
$option_exclude_from_authors = get_option('easytree_option_exclude_from_authors');
$option_show_empty_taxs = !((bool)get_option('easytree_option_show_empty_taxs'));

ob_start();
?>
    
    <nav id="easytree" class="easytree">
    <ul>
        <?php if( has_nav_menu('easytree-nav') ) : ?>
        <li class="easytree__menu">
            <a href="#"><?php _e('Menu'); ?></a>
            <?php
            wp_nav_menu(array(
                'theme_location'    =>'easytree-nav',
                'container'         =>null,
                'items_wrap'        =>'<ul>%3$s</ul>',
            ));
            ?>
        </li>
        <?php endif; /*has_nav_menu*/ ?>
        <li class="easytree__pages">
            <a href="#"><?php _e('Pages'); ?></a>
            <ul>
                <?php
                $post_status = 'publish';
                if(current_user_can('read_private_pages')) {
                    $post_status .= ',private';
                }

                wp_list_pages(array(
                    'exclude'       => $option_exclude_from_pages,
                    'title_li'      => null,
                    'sort_column'   => 'post_title', /*'menu_order, post_title',*/
                    'sort_order'    => 'ASC',
                    'post_status'   => $post_status,
                ));
                ?>
            </ul>
        </li>
        <li class="easytree__categories">
            <a href="#"><?php _e('Categories'); ?></a>
            <ul>
                <?php
                wp_list_categories(array(
                    'hide_empty'    => $option_show_empty_taxs,
                    'title_li'      => null,
                    'orderby'       => 'name',
                    'order'         => 'ASC',
                    'walker'        => new EasyTreeCategoryWalker(),
                ));
                ?>
            </ul>
        </li>
        <li class="easytree__tags">
            <a href="#"><?php _e('Tags'); ?></a>
            <ul>
                <?php
                wp_list_categories(array(
                    'hide_empty'    => $option_show_empty_taxs,
                    'title_li'      => null,
                    'orderby'       => 'name',
                    'order'         => 'ASC',
                    'taxonomy'      => 'post_tag',
                    'walker'        => new EasyTreeTagsWalker(),
                ));
                ?>
            </ul>
        </li>
        <?php if($option_display_authors) : ?>
        <li class="easytree__authors">
            <a href="#"><?php _e('Author'); ?></a>
            <ul>
                <?php
                easytree_list_authors(array( // get_users( array() )
                    'exclude'   => $option_exclude_from_authors,
                    'orderby'   => 'display_name', 
                    'order'     => 'ASC',
                ));
                ?>
            </ul>
        </li>
        <?php endif; ?>
    </ul>
    </nav>
    <script type="text/javascript">
    jQuery(document).ready(function() {
        
        // kategorie i elementy z menu z href="#" jako foldery
        jQuery('.easytree li.cat-item, .easytree li:has(a[href="#"])').addClass('isFolder');
        // kategorie i tagi w drzewie przestaja byc linkami, mozna je tylko rozwijac
        jQuery('.easytree li.cat-item > a, .easytree li > a[href="#"]').removeAttr('href');
        // biezaca strona
        jQuery('.easytree__pages li.current_page_item').addClass('isActive');
        jQuery('.easytree__pages li.current_page_item').parents('.easytree li').addClass('isExpanded');
        // biezaca kategoria/tag/autor
        jQuery('.easytree li.current-cat').addClass('isActive');
        jQuery('.easytree li.current-cat').parents('.easytree li').addClass('isExpanded');
        // biezacy wpis (rozwija drzewo tylko w kategoriach)
        jQuery('.easytree__categories li.current_post_item').addClass('isActive');
        jQuery('.easytree__categories li.current_post_item').parents('.easytree li').addClass('isExpanded');
        // tagi i autorzy rozwijaja sie tak, aby aktywny wpis byl widoczny po rozwinieciu "Tagi", lub "Autorzy"
        jQuery('.easytree__tags li.current_post_item, .easytree__authors li.current_post_item').parents('.easytree li li').addClass('isExpanded');
        
        // uruchomienie drzewa
        jQuery("#easytree").easytree({
            //'allowActivate': false,
            //'minOpenLevels': 1
        });
    });
    </script>

<?php
return ob_get_clean();
}
