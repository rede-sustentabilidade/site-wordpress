<?php

function jkof_create_post_type(){
    $labels = array(
        'name'               => __( 'Onyx Files', 'onyxfiles' ),
        'singular_name'      => __( 'Onyx File', 'onyxfiles' ),
        'add_new'            => __( 'Add New', 'onyxfiles' ),
        'add_new_item'       => __( 'Add New Onyx File', 'onyxfiles' ),
        'edit_item'          => __( 'Edit Onyx File', 'onyxfiles' ),
        'new_item'           => __( 'New Onyx File', 'onyxfiles' ),
        'all_items'          => __( 'All Onyx Files', 'onyxfiles' ),
        'view_item'          => __( 'View Onyx File', 'onyxfiles' ),
        'search_items'       => __( 'Search Onyx File', 'onyxfiles' ),
        'not_found'          => __( 'No Onyx Files found', 'onyxfiles' ),
        'not_found_in_trash' => __( 'No Onyx Files found in the Trash', 'onyxfiles' ),
        'parent_item_colon'  => '',
        'menu_name'          => __( 'Onyx Files', 'onyxfiles' )
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds the onyx files and their data.',
        'public'        => true,
        'menu_position' => 5,
        'supports'      => array( 'title', 'editor', 'comments', 'thumbnail' ),
        'has_archive'   => true,
        'show_ui'       => true,
        'taxonomies'    => array('category', 'post_tag'),
        'menu_icon'     => 'dashicons-cloud'
    );
    register_post_type( 'of_files', $args ); 
}