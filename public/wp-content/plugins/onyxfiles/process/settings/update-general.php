<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/27/2015
 * Time: 5:52 PM
 */
function jkof_save_general_settings(){
    $output                                         =   array( 'status' => 1 );

    if ( !current_user_can( 'manage_options' ) ){
        jkof_dj($output);
    }

    $jkof_settings                                  =    get_option( 'jkof_settings' );
    $jkof_settings['general']['unlocked_dl_exp']    =    sanitize_text_field( $_POST['unlocked_dl_exp'] );
    $jkof_settings['general']['max_upl_size']       =    intval( $_POST['max_upl_size'] );
    $output['status']                               =   2;

    update_option( 'jkof_settings', $jkof_settings );
    jkof_dj($output);
}