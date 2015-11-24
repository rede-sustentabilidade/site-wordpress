<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/7/2015
 * Time: 10:54 PM
 */

function jkof_upload(){
    $file                       =   $_FILES['file'];
    $output                     =   array( 'status' => 1 );
    $jkof_settings              =   get_option( 'jkof_settings' );

    if($file['error'] !== 0){
        $output['file']         =   $file;
        $output['err']          =   'Error uploading file';
        jkof_dj($output);
    }

    $size                       =   $file['size'];
    $new_name                   =   str_replace('"', '', $file['name']);
    $new_name                   =   str_replace("'", '', $new_name);
    $disallowed_files           =   array(".htaccess","php.ini",".htpasswd");
    $max_size                   =   ($jkof_settings['general']['max_upl_size'] * 1024) * 1024;

    if($size > $max_size){
        $output['err']          =   'Upload size is too big.';
        jkof_dj($output);
    }

    if(in_array($new_name, $disallowed_files)){
        $output['err']          =   'Invalid file.';
        jkof_dj($output);
    }

    $upl_dir                    =   is_user_logged_in() ? get_user_meta(get_current_user_id(), 'of_upl_dir', true)  : 'guests' ;

    if(empty($upl_dir)){
        $upl_dir                =   jkof_create_upl_dir();
    }

    if( file_exists( OF_DIR . $upl_dir . '/' . $new_name ) ){
        $new_name               =   get_random_string( mt_rand( 6, 16 ) ) . "_" . $new_name;
    }

    if( !move_uploaded_file( $file['tmp_name'], OF_DIR . $upl_dir . '/' . $new_name ) ){
        $output['err']          =   'Unable to move file.';
        jkof_dj($output);
    }

    $output['status']           =   2;
    $output['upl_dir']          =   $upl_dir;
    $output['name']             =   $new_name;
    $output['type']             =   $file['type'];
    $output['size']             =   $file['size'];
    jkof_dj($output);
}