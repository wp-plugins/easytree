<?php
/**
 * Plugin Name: EasyTree
 * Plugin URI: http://easytree.damlys.pl/
 * Description: Complete dropdown tree navigation that contain pages, categories with posts, tags, authors and own menu.
 * Version: 1.01
 * Author: Damian Lysiak
 * Author URI: http://damlys.pl/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */


define( 'EASYTREE_DIR', plugin_dir_path(__FILE__) );
define( 'EASYTREE_URI', plugin_dir_url (__FILE__) );


function easytree_load_textdomain() {
    load_plugin_textdomain( 'easytree', false, dirname(plugin_basename(__FILE__)).'/languages/' );
}
add_action( 'plugins_loaded', 'easytree_load_textdomain' );


require_once( EASYTREE_DIR . 'class/class.wpeasytreecategorywalker.php' );
require_once( EASYTREE_DIR . 'class/class.wpeasytreetagswalker.php' );
require_once( EASYTREE_DIR . 'functions/easytree_list_authors.php' );
require_once( EASYTREE_DIR . 'functions/get_easytree_html.php' );
require_once( EASYTREE_DIR . 'dashboard.php' );
require_once( EASYTREE_DIR . 'class/class.easytreewidget.php' );


function easytree_init() {
    
    register_nav_menu( 'easytree-nav', 'EasyTree' );
    
    // dashboard.php
    add_action( 'admin_menu', 'easytree_register_options_page' );
    add_action( 'admin_init', 'easytree_register_setting' );
}
add_action( 'init', 'easytree_init' );


function easytree_setup_theme() {
    
    add_action( 'wp_enqueue_scripts', 'easytree_load_scripts' );
}
add_action( 'after_setup_theme', 'easytree_setup_theme' );



function easytree_load_scripts() {
    
    $option_skin = get_option('easytree_option_skin');
    
    if( !is_admin() ){
            
        // EasyTree (http://www.easyjstree.com/)
        wp_enqueue_style(  'easytree', EASYTREE_URI.'css/skin-'.$option_skin.'/ui.easytree.css', array(), '1.0.1', 'all' );
        wp_enqueue_script( 'easytree', EASYTREE_URI.'js/jquery.easytree.min.js', array('jquery'), '1.0.1', false );
        /* jquery.easytree.min.js
        POJEDYNCZE KLIKNIECIE OTWIERA FOLDER:
                $($this.selector + " .easytree-title").on("dblclick", nodes, toggleNodeEvt);
        ZMIENIAM NA
                $($this.selector + " .easytree-title").on("click", nodes, toggleNodeEvt);
        */
    }
}


function easytree_shortcode( $atts ){
    return get_easytree_html();
}
add_shortcode( 'easytree', 'easytree_shortcode' );

