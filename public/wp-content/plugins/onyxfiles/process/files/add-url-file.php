<?php

function jkof_import_url_file(){
    $import_url                 =   secure($_POST['import_url']);
    $output                     =   array('status' => 1);
    $jkof_settings              =   get_option( 'jkof_settings' );

    if(!filter_var($import_url, FILTER_VALIDATE_URL)){
        jkof_dj($output);
    }

    $new_name                   =   basename($import_url);
    $new_name                   =   str_replace('"', '', $new_name);
    $new_name                   =   str_replace("'", '', $new_name);
    $disallowed_files           =   array(".htaccess","php.ini",".htpasswd");
    $max_size                   =   ($jkof_settings['general']['max_upl_size'] * 1024) * 1024;

    if(in_array($new_name, $disallowed_files)){
        jkof_dj($output);
    }

    $ch                         =   curl_init();
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $import_url); //specify the url
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $head                       =   curl_exec($ch);
    $size                       =   curl_getinfo($ch,CURLINFO_CONTENT_LENGTH_DOWNLOAD);

    if($size > $max_size){
        jkof_dj($output);
    }

    $upl_dir                    =   is_user_logged_in() ? get_user_meta(get_current_user_id(), 'of_upl_dir', true)  : 'guests' ;

    if(empty($upl_dir)){
        $upl_dir                =   jkof_create_upl_dir();
    }

    if( file_exists( OF_DIR . $upl_dir . '/' . $new_name ) ){
        $new_name               =   get_random_string( mt_rand( 6, 16 ) ) . "_" . $new_name;
    }

    if( !file_put_contents( OF_DIR . $upl_dir . '/' . $new_name, fopen($import_url, 'r')) ){
        jkof_dj($output);
    }

    $finfo                      =   finfo_open(FILEINFO_MIME_TYPE);
    $file_type                  =   finfo_file($finfo, OF_DIR . $upl_dir . '/' . $new_name);
    $filesize                   =   filesize(OF_DIR . $upl_dir . '/' . $new_name);
    finfo_close($finfo);

    $output['status']           =   2;
    $output['name']             =   $new_name;
    $output['type']             =   $file_type;
    $output['size']             =   $filesize;
    $output['upl_dir']          =   $upl_dir;
    jkof_dj($output);
}