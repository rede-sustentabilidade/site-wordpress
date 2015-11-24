<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/28/2015
 * Time: 8:12 PM
 */

function jkof_add_verified_download(){
    global $wpdb;
    $output                 =   array( 'status' => 1 );
    $fid                    =   intval($_POST['fid']);
    $file_settings          =   get_post_meta( $fid, 'jkof_dl_settings', true );

    if(empty($file_settings)){
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