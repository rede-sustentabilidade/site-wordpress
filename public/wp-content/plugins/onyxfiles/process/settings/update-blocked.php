<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/22/2015
 * Time: 7:36 PM
 */
function jkof_save_blocked_settings(){
    $output                                     =   array( 'status' => 1 );

    if ( !current_user_can( 'manage_options' ) ){
        jkof_dj($output);
    }

    $jkof_settings                              =   get_option( 'jkof_settings' );
    $jkof_settings['blocked']['domains']        =   explode( ",", sanitize_text_field( $_POST['domains'] ));;
    $jkof_settings['blocked']['emails']         =   explode( ",", sanitize_text_field( $_POST['emails'] ));;
    $output['status']                           =   2;

    update_option( 'jkof_settings', $jkof_settings );
    jkof_dj($output);
}