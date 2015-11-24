<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/22/2015
 * Time: 5:37 PM
 */

function jkof_save_social_settings(){
    $output                                     =   array( 'status' => 1 );

    if ( !current_user_can( 'manage_options' ) ){
        jkof_dj($output);
    }

    $jkof_settings                              =    get_option( 'jkof_settings' );
    $jkof_settings['social']['fb_app_id']       =    sanitize_text_field( $_POST['fb_app_id'] );
    $jkof_settings['social']['li_api_key']      =    sanitize_text_field( $_POST['li_api_key'] );
    $jkof_settings['social']['twitter_u']       =    sanitize_text_field( $_POST['twitter_u'] );
    $output['status']                           =   2;

    update_option( 'jkof_settings', $jkof_settings );
    jkof_dj($output);
}