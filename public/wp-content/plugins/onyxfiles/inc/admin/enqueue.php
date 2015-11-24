<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/9/2015
 * Time: 1:57 PM
 */

function jkof_admin_register_styles(){
    // Libraries
    wp_register_style( 'jkof_fa', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
    wp_register_style( 'jkof_ion_icons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css' );
    wp_register_style( 'jkof_bootstrap', plugins_url( '/components/bootstrap/dist/css/bootstrap.min.css', OF_PLUGIN_URL ) );
    wp_register_style( 'jkof_roboto', plugins_url( '/components/bootstrap-material-design/dist/css/roboto.min.css', OF_PLUGIN_URL ) );
    wp_register_style( 'jkof_material', plugins_url( '/components/bootstrap-material-design/dist/css/material.min.css', OF_PLUGIN_URL ) );
    wp_register_style( 'jkof_ripples', plugins_url( '/components/bootstrap-material-design/dist/css/ripples.min.css', OF_PLUGIN_URL ) );
    wp_register_style( 'jkof_toastr', plugins_url( '/components/toastr/toastr.min.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_filetree', plugins_url( '/components/filetree/jqueryFileTree.css', OF_PLUGIN_URL ) );
    wp_register_style( 'jkof_flatton_buttons', plugins_url( '/components/flatton/css/web-buttons.min.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_flatton_colors', plugins_url( '/components/flatton/css/color-variations.min.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_flatton_social', plugins_url( '/components/flatton/css/social-colors.min.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_select2', plugins_url( '/components/select2/dist/css/select2.min.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_datepicker', plugins_url( '/components/datepicker/css/bootstrap-datepicker.min.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_admin_lte', plugins_url( 'components/AdminLTE/dist/css/AdminLTE.min.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_admin_lte_yellow', plugins_url( 'components/AdminLTE/dist/css/skins/skin-yellow-light.min.css', OF_PLUGIN_URL  ) );

    // Custom
    wp_register_style( 'jkof_onyxfiles_admin', plugins_url( '/components/core/admin.css', OF_PLUGIN_URL ) );
}

function jkof_admin_register_scripts(){
    // Libraries
    wp_register_script( 'jkof_bootstrap', plugins_url( '/components/bootstrap/dist/js/bootstrap.min.js', OF_PLUGIN_URL ), array('jquery'), '1.0.0', true );
    wp_register_script( 'jkof_ripples', plugins_url( '/components/bootstrap-material-design/dist/js/ripples.min.js', OF_PLUGIN_URL ), array('jquery'), '1.0.0', true );
    wp_register_script( 'jkof_material', plugins_url( '/components/bootstrap-material-design/dist/js/material.min.js', OF_PLUGIN_URL ), array('jquery'), '1.0.0', true );
    wp_register_script( 'jkof_dropzone', plugins_url( '/components/dropzone/dropzone.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_filetree', plugins_url( '/components/filetree/jqueryFileTree.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_toastr', plugins_url( '/components/toastr/toastr.min.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_filesize', plugins_url( '/components/filesize/filesize.min.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_select2', plugins_url( '/components/select2/dist/js/select2.min.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_datepicker', plugins_url( '/components/datepicker/js/bootstrap-datepicker.min.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_slimscroll', plugins_url( '/components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_fastclick', plugins_url( '/components/AdminLTE/plugins/fastclick/fastclick.min.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_admin_lte', plugins_url( '/components/AdminLTE/dist/js/app.min.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_angular', plugins_url( '/components/angular/angular.min.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_ui_router', plugins_url( '/components/angular-ui-router/release/angular-ui-router.min.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_chartsjs', plugins_url( "/components/chartsjs/Chart.min.js", OF_PLUGIN_URL), array(), '1.0.0', true );

    // Custom
    wp_register_script( 'jkof_modal_file_stats', plugins_url( '/components/core/modal-file-stats.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_edit_post_type', plugins_url( '/components/core/edit-post-type.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_email_list', plugins_url( '/components/core/email-list.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_admin_app', plugins_url( '/app/admin/app.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_admin_generalCtrl', plugins_url( '/app/admin/controllers/general.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_admin_socialCtrl', plugins_url( '/app/admin/controllers/social.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_admin_paypalCtrl', plugins_url( '/app/admin/controllers/paypal.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_admin_blockedCtrl', plugins_url( '/app/admin/controllers/blocked.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_admin_messagesCtrl', plugins_url( '/app/admin/controllers/messages.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_admin_storageCtrl', plugins_url( '/app/admin/controllers/storage.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_admin_emailFieldsCtrl', plugins_url( '/app/admin/controllers/email-fields.js', OF_PLUGIN_URL ), array(), '1.0.0', true );

    // Translate Scripts
    $app_i18n           =   array(
        'wait'          =>  __('Please wait! We are updating your settings.', 'onyxfiles'),
        'success'       =>  __('Update successful!', 'onyxfiles'),
        'fail'          =>  __('Unable to update settings!', 'onyxfiles')
    );
    wp_localize_script( 'jkof_admin_generalCtrl', 'jkof_i18n', $app_i18n);
    wp_localize_script( 'jkof_admin_socialCtrl', 'jkof_i18n', $app_i18n);
    wp_localize_script( 'jkof_admin_paypalCtrl', 'jkof_i18n', $app_i18n);
    wp_localize_script( 'jkof_admin_blockedCtrl', 'jkof_i18n', $app_i18n);
    wp_localize_script( 'jkof_admin_messagesCtrl', 'jkof_i18n', $app_i18n);
    wp_localize_script( 'jkof_admin_storageCtrl', 'jkof_i18n', $app_i18n);
    wp_localize_script( 'jkof_admin_emailFieldsCtrl', 'jkof_i18n', $app_i18n);
    wp_localize_script( 'jkof_edit_post_type', 'jkof_edit_i18n', array(
        'upload_fail'           =>  __('File failed uploading!', 'onyxfiles'),
        'wait'                  =>  __('Please wait!', 'onyxfiles'),
        'success'               =>  __('Success!', 'onyxfiles'),
        'error'                 =>  __('Error!', 'onyxfiles'),
        'upload_success'        =>  __('Your file has been uploaded.', 'onyxfiles'),
        'adding_file'           =>  __('We are currently adding this file for you.', 'onyxfiles'),
        'adding_url'            =>  __('We are currently adding this URL for you.', 'onyxfiles'),
        'unable'                =>  __('We could not add this file for you!', 'onyxfiles'),
        'file_upl_success'      =>  __('We have added this file to your package.', 'onyxfiles')
    ));
}

function jkof_admin_enqueue( $hook ){
    global $typenow;

    if( $typenow !== "of_files" ){
        return;
    }
    // Styles
    wp_enqueue_style( 'jkof_fa' );
    wp_enqueue_style( 'jkof_bootstrap' );
    wp_enqueue_style( 'jkof_roboto' );
    wp_enqueue_style( 'jkof_material' );
    wp_enqueue_style( 'jkof_ripples' );
    wp_enqueue_style( 'jkof_onyxfiles_admin' );

    // Scripts
    wp_enqueue_script( 'jkof_bootstrap' );
    wp_enqueue_script( 'jkof_ripples' );
    wp_enqueue_script( 'jkof_material' );

    if($hook == "post.php" || $hook == "post-new.php"){
        // Styles
        wp_enqueue_style( 'jkof_toastr' );
        wp_enqueue_style( 'jkof_filetree' );
        wp_enqueue_style( 'jkof_flatton_buttons' );
        wp_enqueue_style( 'jkof_flatton_colors' );
        wp_enqueue_style( 'jkof_flatton_social' );
        wp_enqueue_style( 'jkof_select2' );
        wp_enqueue_style( 'jkof_datepicker' );

        // Scripts
        wp_enqueue_script( 'jkof_dropzone' );
        wp_enqueue_script( 'jkof_filesize' );
        wp_enqueue_script( 'jkof_toastr' );
        wp_enqueue_script( 'jkof_select2' );
        wp_enqueue_script( 'jkof_filetree' );
        wp_enqueue_script( 'jkof_raphael' );
        wp_enqueue_script( 'jkof_morris' );
        wp_enqueue_script( 'jkof_datepicker' );
        wp_enqueue_script( 'jkof_edit_post_type' );
    }

    if($hook == "edit.php"){
        // Scripts
        wp_enqueue_script( 'jkof_chartsjs' );
        wp_enqueue_script( 'jkof_modal_file_stats' );
    }

    if(isset($_GET['page']) && $_GET['page'] == "of_settings"){
        // Styles
        wp_enqueue_style( 'jkof_ion_icons' );
        wp_enqueue_style( 'jkof_admin_lte' );
        wp_enqueue_style( 'jkof_admin_lte_yellow' );

        // Scripts
        wp_dequeue_script("jkof_ripples");
        wp_dequeue_script("jkof_material");
        wp_enqueue_script( 'jkof_slimscroll' );
        wp_enqueue_script( 'jkof_fastclick' );
        wp_enqueue_script( 'jkof_admin_lte' );
        wp_enqueue_script( 'jkof_angular' );
        wp_enqueue_script( 'jkof_ui_router' );
        wp_enqueue_script( 'jkof_admin_app' );
        wp_enqueue_script( 'jkof_admin_generalCtrl' );
        wp_enqueue_script( 'jkof_admin_socialCtrl' );
        wp_enqueue_script( 'jkof_admin_paypalCtrl' );
        wp_enqueue_script( 'jkof_admin_blockedCtrl' );
        wp_enqueue_script( 'jkof_admin_messagesCtrl' );
        wp_enqueue_script( 'jkof_admin_storageCtrl' );
        wp_enqueue_script( 'jkof_admin_emailFieldsCtrl' );
    }

    if(isset($_GET['page']) && $_GET['page'] == "of_email_list"){
        wp_enqueue_script( 'jkof_email_list' );
    }

    if(isset($_GET['page']) && $_GET['page'] == "of_stats"){
        wp_enqueue_script( 'jkof_chartsjs' );
    }
}