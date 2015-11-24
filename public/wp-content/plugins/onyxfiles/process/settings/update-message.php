<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/22/2015
 * Time: 7:48 PM
 */
function jkof_save_message_settings(){
    $output                                     =   array( 'status' => 1 );

    if ( !current_user_can( 'manage_options' ) ){
        jkof_dj($output);
    }

    $jkof_settings                              =   get_option( 'jkof_settings' );
    $jkof_settings['message']['denied_dl']      =   $_POST['denied_dl'];
    $output['status']                           =   2;

    update_option( 'jkof_settings', $jkof_settings );
    jkof_dj($output);
}