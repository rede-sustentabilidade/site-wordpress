<?php

require_once get_stylesheet_directory().'/utilidades/ApiRede.php';

require_once get_stylesheet_directory().'/utilidades/RsProvider.php';

require_once get_stylesheet_directory().'/includes/regionalization.php';

require_once get_stylesheet_directory().'/includes/payment.php';

require_once get_stylesheet_directory().'/includes/redesign.php';

require_once get_stylesheet_directory().'/includes/usuario.php';

function wpr_remove_custom_actions() {
    remove_action( 'after_setup_theme', 'pinbin_options_init' );
    /* remove_action( 'admin_init', 'pinbin_options_setup' ); */
    remove_action('admin_menu', 'pinbin_menu_options');
    remove_action('admin_print_styles-appearance_page_pinbin-settings', 'pinbin_options_enqueue_scripts');
    /* remove_action( 'admin_init', 'pinbin_options_settings_init' ); */
    remove_theme_support( 'custom-background' );

    if (!is_admin()) {
		remove_action( 'wp_enqueue_scripts', 'pinbin_scripts' );
	}
}

// post thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size('summary-image', 300, 9999);
add_image_size('detail-image', 675, 9999);

add_action('init','wpr_remove_custom_actions');

add_filter('show_admin_bar', '__return_false');

function frontend_scripts_method() {
	wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '20140526' );
	wp_register_style('rs_rrssb', get_stylesheet_directory_uri() . '/css/rrssb.min.css');
    //	wp_enqueue_style('rs_rrssb');

	wp_enqueue_script( 'require', get_stylesheet_directory_uri() . '/assets/bower_components/requirejs/require.js', array( 'jquery' ), '20130609', true );
	wp_enqueue_script( 'site-main', get_stylesheet_directory_uri() . '/assets/js/source/Site/main.js', array( 'require' ), '20130609', true );

	load_theme_textdomain( 'rede-sustentabilidade', get_template_directory() . '/languages' );
}

add_action( 'wp_enqueue_scripts', 'frontend_scripts_method' ); // wp_enqueue_scripts action hook to link only on the front-end

// Register Custom Post Type
function conheca_post_type() {

	$labels = array(
		'name'                  => _x( 'Conheça', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Conheça', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Conheça', 'text_domain' ),
		'name_admin_bar'        => __( 'Conheça', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Listar todos', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Adicionar novo', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Conheça', 'text_domain' ),
		'description'           => __( 'Tópicos da página conheça', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-welcome-view-site',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'conheca', $args );

}
add_action( 'init', 'conheca_post_type', 0 );

// Register Custom Taxonomy
function conheca_categoria_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Categorias', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Categoria', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Categoria Conheça', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'conheca_categorias', array( 'conheca' ), $args );

}
add_action( 'init', 'conheca_categoria_taxonomy', 0 );

add_action( 'rest_api_init', 'slug_register_starship' );
function slug_register_starship() {
    register_rest_field( 'conheca',
        'list_categories',
        array(
            'get_callback'    => 'slug_get_categorias',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'conheca',
        'url_featured_media',
        array(
            'get_callback'    => 'slug_get_imagem',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function slug_get_categorias( $object, $field_name, $request ) {
    return get_the_terms( $object[ 'id' ], 'conheca_categorias' );
}

function slug_get_imagem( $object, $field_name, $request ) {
    return wp_get_attachment_image_url( $object[ 'featured_media'] );
}

if (isset($_COOKIE['usuario'])) {
	$usuario = json_decode(stripslashes($_COOKIE['usuario']));
}

////////////////////
function new_wp_login_url() {
    return home_url();
}
add_filter('login_headerurl', 'new_wp_login_url');

/**
 * Sort by custom fields.
 * mt1 refers to meta_1, mt2 to meta_2 and mt3 to meta_3
 *
 * @param $orderby original order by string
 * @return custom order by string
 */
function double_meta_posts_orderby($orderby) {
  global $wpdb;
  return " {$wpdb->postmeta}.meta_value+0 DESC";
}

function remove_category_consulta( $wp_query ) {

    // Add the category to an array of excluded categories. In this case, though,
    // it's really just one.
    $excluded = array( '-59' );

    // Note that this is a cleaner way to write: $wp_query->set('category__not_in', $excluded);
    if (is_home()) {
    	set_query_var( 'category__not_in', $excluded );
    }
}
add_action( 'pre_get_posts', 'remove_category_consulta' );

// wp-login inside iframe
remove_action( 'login_init', 'send_frame_options_header' );
remove_action( 'admin_init', 'send_frame_options_header' );

/// comentario duplicado
add_filter( 'wp_die_handler', 'my_wp_die_handler_function', 9 ); //9 means you can unhook the default before it fires

function my_wp_die_handler_function($function) {
    return 'my_skip_dupes_function'; //use our "die" handler instead (where we won't die)
}

//check to make sure we're only filtering out die requests for the "Duplicate" error we care about
function my_skip_dupes_function( $message, $title, $args ) {
    if (strpos( $message, 'Duplicate comment detected' ) === 0 ) { //make sure we only prevent death on the $dupe check
        remove_filter( 'wp_die_handler', '_default_wp_die_handler' ); //don't die
    }
    return; //nothing will happen
}

add_action('wp_logout','go_home');
function go_home(){
    wp_redirect( home_url() );
    exit();
}

function rs_login_logo() {
    echo '
        <style type="text/css">
        body.login div#login h1 {
        display: none !important;
        }
        </style>
    ';
}

add_action('login_enqueue_scripts', 'rs_login_logo');

function rs_login_redirect($redirect_to, $request, $user) {
    if (!empty($user->roles) && is_array($user->roles)
            && count(array_intersect(array('filiado', 'subscriber'), $user->roles))
            && strpos($redirect_to, 'wp-admin') !== false) {
        return home_url();
    }
    return $redirect_to;
}

add_filter('login_redirect', 'rs_login_redirect', 10, 3);

/*
Plugin Name: Disable Emojis
Plugin URI: https://geek.hellyer.kiwi/plugins/disable-emojis/
Description: Disable Emojis
Version: 1.5.1
Author: Ryan Hellyer
Author URI: https://geek.hellyer.kiwi/
License: GPL2

------------------------------------------------------------------------
Copyright Ryan Hellyer

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

*/


/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param    array  $plugins
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}