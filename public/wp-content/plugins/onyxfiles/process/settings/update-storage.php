<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/22/2015
 * Time: 9:40 PM
 */
function jkof_save_storage_settings(){
    $output                                         =   array( 'status' => 1 );

    if ( !current_user_can( 'manage_options' ) ){
        jkof_dj($output);
    }

    $jkof_settings                                  =    get_option( 'jkof_settings' );
    $jkof_settings['storage']['dropbox_app_key']    =    sanitize_text_field( $_POST['dropbox_app_key'] );
    $jkof_settings['storage']['aws_access_key']     =    sanitize_text_field( $_POST['aws_access_key'] );
    $jkof_settings['storage']['aws_secret_key']     =    sanitize_text_field( $_POST['aws_secret_key'] );
    $jkof_settings['storage']['aws_bucket_name']    =    sanitize_text_field( $_POST['aws_bucket_name'] );
    $output['status']                               =   2;

    update_option( 'jkof_settings', $jkof_settings );
    jkof_dj($output);
}