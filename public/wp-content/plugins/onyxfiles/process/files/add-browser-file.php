<?php

function jkof_add_browser_file(){
    $output                     =   array( 'status' => 1 );

    if(!isset($_POST['file'])){
        jkof_dj($output);
    }

    $file                       =   secure($_POST['file']);
    $root                       =   get_home_path();
    $new_name                   =   basename($root . $file);
    $new_name                   =   str_replace('"', '', $new_name);
    $new_name                   =   str_replace("'", '', $new_name);
    $disallowed_files           =   array(".htaccess","php.ini",".htpasswd","wp-config.php");
    $finfo                      =   finfo_open(FILEINFO_MIME_TYPE);
    $file_type                  =   finfo_file($finfo, $root . $file);
    finfo_close($finfo);
    $filesize                   =   filesize($root .$file);

    if(in_array($new_name, $disallowed_files)){
        $output['err']          =   "Invalid file.";
        jkof_dj($output);
    }

    $upl_dir                    =   is_user_logged_in() ? get_user_meta(get_current_user_id(), 'of_upl_dir', true)  : 'guests' ;
    if(empty($upl_dir)){
        $upl_dir                =   jkof_create_upl_dir();
    }

    if( file_exists( OF_DIR . $upl_dir . "/" . $new_name ) ){
        $new_name               =    get_random_string( mt_rand( 6, 16 ) ) . "_" . $new_name;
    }

    if( !copy( $root . $file, OF_DIR . $upl_dir . "/" . $new_name ) ){
        $output['err']          =   "Unable to move file.";
        jkof_dj($output);
    }

    $output['status']           =   2;
    $output['name']             =   $new_name;
    $output['size']             =   $filesize;
    $output['type']             =   $file_type;
    $output['upl_dir']          =   $upl_dir;
    jkof_dj($output);
}