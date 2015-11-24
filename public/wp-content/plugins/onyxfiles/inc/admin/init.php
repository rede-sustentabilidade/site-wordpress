<?php

function jkof_admin_init()
{
    // Include Files
    include( 'enqueue.php' );
    include( 'tinymce.php' );
    include( 'tinymce-modal.php' );
    include( 'create-metaboxes.php');
    include( 'upload.mb.php' );
    include( 'file-center.mb.php' );
    include( 'columns.php' );
    include( 'footer.php' );

    // Begin Admin Hooks
    add_filter('manage_edit-of_files_columns', 'add_new_of_columns');
    add_action('manage_of_files_posts_custom_column', 'manage_of_columns', 10, 2);
    add_action('admin_enqueue_scripts', 'jkof_admin_enqueue');
    add_action('add_meta_boxes_of_files', 'jkof_create_metaboxes');
    add_action('wp_ajax_jkof_get_file_stats', 'jkof_get_file_stats');
    add_action('wp_ajax_jkof_delete_emails', 'jkof_delete_emails');
    add_action('wp_ajax_jkof_export_selected_emails', 'jkof_export_selected_emails');
    add_action('wp_ajax_jkof_export_all_emails', 'jkof_export_all_emails');
    add_action('wp_ajax_jkof_export_unique_emails', 'jkof_export_unique_emails');
    add_action('wp_ajax_jkof_filetree', 'jkof_create_filetree');
    add_action('save_post_of_files', 'jkof_save_post', 10, 3);
    add_action('admin_post_jkof_save_social_settings', 'jkof_save_social_settings');
    add_action('admin_post_jkof_save_paypal_settings', 'jkof_save_paypal_settings');
    add_action('admin_post_jkof_save_blocked_settings', 'jkof_save_blocked_settings');
    add_action('admin_post_jkof_save_message_settings', 'jkof_save_message_settings');
    add_action('admin_post_jkof_save_storage_settings', 'jkof_save_storage_settings');
    add_action('admin_post_jkof_save_fields_settings', 'jkof_save_fields_settings');
    add_action('admin_post_jkof_save_general_settings', 'jkof_save_general_settings');
    add_action('admin_footer', 'jkof_tinymce_modal');
    add_action( 'admin_footer', 'jkof_admin_footer' );

    // Begin Registering Styles & Scripts
    jkof_admin_register_styles();
    jkof_admin_register_scripts();
}