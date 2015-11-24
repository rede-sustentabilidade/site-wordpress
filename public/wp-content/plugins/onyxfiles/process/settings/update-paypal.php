<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/22/2015
 * Time: 7:25 PM
 */
function jkof_save_paypal_settings(){
    $output                                     =   array( 'status' => 1 );

    if ( !current_user_can( 'manage_options' ) ){
        jkof_dj($output);
    }

    $jkof_settings                              =   get_option( 'jkof_settings' );
    $jkof_settings['paypal']['email']           =   sanitize_email( $_POST['email'] );
    $jkof_settings['paypal']['currency']        =   sanitize_email( $_POST['currency'] );
    $output['status']                           =   2;

    update_option( 'jkof_settings', $jkof_settings );
    jkof_dj($output);
}