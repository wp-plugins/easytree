<?php


function easytree_register_options_page() {
    add_options_page( 'EasyTree', 'EasyTree', 'administrator', 'easytree', 'easytree_options_page');
}


function easytree_register_setting() {
    register_setting( 'easytree_options', 'easytree_option_exclude_from_pages', 'easytree_validate_id_list' );
    register_setting( 'easytree_options', 'easytree_option_display_authors', 'easytree_validate_bool' ); // yes/no
    register_setting( 'easytree_options', 'easytree_option_exclude_from_authors', 'easytree_validate_id_list' );
    register_setting( 'easytree_options', 'easytree_option_show_empty_taxs', 'easytree_validate_bool' );
    
    register_setting( 'easytree_options', 'easytree_option_skin', 'easytree_validate_skin' );
}


function easytree_validate_id_list( $input ) {
    
    $output = array();
    $input = explode( ',', strip_tags( stripslashes( $input ) ) );
    
    foreach( $input as $id ) {
        $id = (int)trim( $id );
        if($id) $output[] = $id;
    }
    sort($output);
    
    return implode( ',', $output );
}
function easytree_validate_bool( $input ) {
    
    return (bool)$input;
}
function easytree_validate_skin( $input ) {
    
    $available_skins = array('lion', 'win7', 'win8', 'xp');
    if( !in_array( $input, $available_skins )) $input = 'lion';
    
    return $input;
}


function easytree_options_page() {
?>

<div class="wrap">
    
    <h2>EasyTree</h2>
    
    <form method="post" action="options.php">
        <?php settings_fields( 'easytree_options' ); ?>
        <?php do_settings_sections( 'easytree_options' ); ?>

        <div id="poststuff">
            <div id="post-body" class="columns-2">
                <div id="post-body-content">
                    <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'Settings', 'easytree' ); ?></span></h3>
                            <div class="inside">
                                <table class="form-table">
                                        
                                    <tr valign="top">
                                    <th scope="row"><?php _e( 'Exclude pages', 'easytree' ); ?></th>
                                    <td>
                                        <input type="text" name="easytree_option_exclude_from_pages" value="<?php echo get_option('easytree_option_exclude_from_pages'); ?>" />
                                        <p class="description"><?php _e( 'Add the IDs, separated by comma, of pages you want to exclude', 'easytree' ); ?></p>
                                    </td>
                                    </tr>
                                    <!-- ((int)get_option('page_on_front')).','.((int)get_option('page_for_posts')); -->
                                    
                                    <tr valign="top">
                                    <th scope="row"><?php _e( 'Display authors', 'easytree' ); ?></th>
                                    <td>
                                        <label><input type="radio" name="easytree_option_display_authors" value="1" <?php if(get_option('easytree_option_display_authors')==true) echo 'checked'; ?> /> <?php _e( 'Yes', 'easytree' ); ?></label>
                                        <br/>
                                        <label><input type="radio" name="easytree_option_display_authors" value="0" <?php if(get_option('easytree_option_display_authors')==false) echo 'checked'; ?> /> <?php _e( 'No', 'easytree' ); ?></label>
                                    </td>
                                    </tr>
                                    
                                    <tr valign="top">
                                    <th scope="row"><?php _e( 'Exclude authors', 'easytree' ); ?></th>
                                    <td>
                                        <input type="text" name="easytree_option_exclude_from_authors" value="<?php echo get_option('easytree_option_exclude_from_authors'); ?>" />
                                        <p class="description"><?php _e( 'Add the IDs, separated by comma, of users you want to exclude', 'easytree' ); ?></p>
                                    </td>
                                    </tr>
                                    
                                    <tr valign="top">
                                    <th scope="row"><?php _e( 'Show empty taxonomies', 'easytree' ); ?></th>
                                    <td>
                                        <label><input type="radio" name="easytree_option_show_empty_taxs" value="1" <?php if(get_option('easytree_option_show_empty_taxs')==true) echo 'checked'; ?> /> <?php _e( 'Yes', 'easytree' ); ?></label>
                                        <br/>
                                        <label><input type="radio" name="easytree_option_show_empty_taxs" value="0" <?php if(get_option('easytree_option_show_empty_taxs')==false) echo 'checked'; ?> /> <?php _e( 'No', 'easytree' ); ?></label>
                                    </td>
                                    </tr>
                                    
                                    <tr valign="top">
                                    <th scope="row"><?php _e( 'Skin', 'easytree' ); ?></th>
                                    <td>
                                        <select name="easytree_option_skin">
                                            <option value="lion" <?php if(get_option('easytree_option_skin')=='lion') echo 'selected'; ?>>Lion</option>
                                            <option value="win8" <?php if(get_option('easytree_option_skin')=='win8') echo 'selected'; ?>>Windows 8</option>
                                            <option value="win7" <?php if(get_option('easytree_option_skin')=='win7') echo 'selected'; ?>>Windows 7</option>
                                            <option value="xp" <?php if(get_option('easytree_option_skin')=='xp') echo 'selected'; ?>>Windows XP</option>
                                        </select>
                                    </td>
                                    </tr>
                                    
                                </table>
                            </div><!-- .inside -->
                    </div><!-- .postbox -->
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Menu', 'easytree' ); ?></span></h3>
                        <div class="inside">
                            <p><?php _e( 'If you wish to add "Menu" element to your EasyTree, just create new menu and assign it to EasyTree theme location.', 'easytree' ); ?></p>
                            <p><img src="<?php echo EASYTREE_URI; ?>/img/easytree_menu.png" /></p>
                            <p><?php _e( 'Add a custom link with "#" URL to set element as folder.', 'easytree' ); ?></p>
                            <p><?php _e( 'You can also check "Open link in a new window/tab" to open link in new web browser tab.', 'easytree' ); ?></p>
                        </div><!-- .inside -->
                    </div><!-- .postbox -->
                </div>
                <div id="postbox-container-1" class="postbox-container">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Use', 'easytree' ); ?></span></h3>
                        <div class="inside">
                            <p><?php printf( __( 'To display the sitemap, just add the widget, or use %s shortcode on any page or post.', 'easytree' ), '<code>[easytree]</code>' ); ?></p>
                            <p><?php _e( 'You can use this plugin only once per page!', 'easytree' ); ?></p>
                        </div><!-- .inside -->
                    </div><!-- .postbox -->
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'About', 'easytree' ); ?></span></h3>
                        <div class="inside">
                            <p>
                                <img src="<?php echo EASYTREE_URI; ?>/img/programming2.png" style="vertical-align:middle;" />
                                <?php _e( 'Developed by', 'easytree' ); ?>
                                <a href="http://damlys.pl/" target="_blank">Damian Łysiak</a>
                            </p>
                            <p>
                                <img src="<?php echo EASYTREE_URI; ?>/img/star169.png" style="vertical-align:middle;" />
                                <a href="https://wordpress.org/" target="_blank"><?php _e( 'Rate the plugin on Wordpress.org', 'easytree' ); ?></a>
                            </p>
                            <p>
                                <img src="<?php echo EASYTREE_URI; ?>/img/jar19.png" style="vertical-align:middle;" />
                                <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=LADMQTJM3WLUG" target="_blank"><?php _e( 'Invite me for a beer :)', 'easytree' ); ?></a>
                            </p>
                            <?php /*<hr/>
                            <p>
                                <img src="<?php echo EASYTREE_URI; ?>/img/link56.png" style="vertical-align:middle;" />
                                <?php _e( 'This plugin is based on', 'easytree' ); ?>
                                <a href="http://www.easyjstree.com/" target="_blank">EasyTree</a>
                            </p>*/ ?>
                        </div><!-- .inside -->
                    </div><!-- .postbox -->
                </div>
            </div>
        </div>

        <div class="clear"></div>
        <?php submit_button(); ?>
        
    </form>
</div>

<?php
}
