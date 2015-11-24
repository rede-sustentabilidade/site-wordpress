<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/26/2015
 * Time: 10:22 PM
 */

function jkof_check_password(){
    global $wpdb;
    $output                 =   array( 'status' => 1 );
    $password               =   secure($_POST['password']);
    $fid                    =   intval($_POST['fid']);
    $file_settings          =   get_post_meta( $fid, 'jkof_dl_settings', true );
    $jkof_settings          =   get_option( 'jkof_settings' );

    if(empty($file_settings)){
        $output['err']      =   $jkof_settings['message']['denied_dl'];
        jkof_dj($output);
    }

    if($password !== $file_settings['lock_password']){
        $output['err']      =   'Incorrect password.';
        jkof_dj($output);
    }

    $wpdb->insert(
        $wpdb->prefix . 'of_verified_downloads',
        array(
            "fid"           =>  $fid,
            "ip"            =>  jkof_get_ip(),
            "time_verified" =>  time()
        ),
        array( '%d', '%s', '%d' )
    );

    $output['status']       =   2;
    jkof_dj($output);
}