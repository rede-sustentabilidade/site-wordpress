<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/8/2015
 * Time: 2:09 PM
 */

function jkof_create_upl_dir(){
    if(!is_user_logged_in()){
        return "guests";
    }

    global $current_user;
    get_currentuserinfo();

    $upl_dir            =   substr($current_user->user_login , 0, 1) . '/';
    $upl_dir            .=  mt_rand(1, 10) . '/';
    $upl_dir            .=  $current_user->user_login;

    wp_mkdir_p( OF_DIR . $upl_dir );
    update_user_meta( $current_user->ID, 'of_upl_dir', $upl_dir );

    return $upl_dir;
}