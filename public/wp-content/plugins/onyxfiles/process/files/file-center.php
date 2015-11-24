<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/25/2015
 * Time: 9:30 PM
 */

function jkof_get_file_center_files(){
    global $wpdb, $current_user;
    $output                     =   array( 'status' => 1 );

    if(!is_user_logged_in()){
        jkof_dj($output);
    }

    get_currentuserinfo();

    $shared_files               =   $wpdb->get_results("
	SELECT `ofid` FROM " . $wpdb->prefix . "of_file_shares
	WHERE username='" . $current_user->user_login . "' AND share_type='1'
	");

    $output['shared_files']     =   array();

    foreach($shared_files as $sfk => $sfv){
        $file_data              =   get_post_meta( $sfv->ofid, 'jkof_dl_settings', true );

        if(empty($file_data)){
            continue;
        }

        $post_title             =   get_the_title( $file_data['pid'] );
        $file_size              =   0;
        $files                  =   json_decode($file_data['files']);
        foreach($files as $file_key => $file_val){
            $file_size          +=  $file_val->size;
        }
        $file_size              =   FileSizeConvert($file_size);

        array_push($output['shared_files'], array(
            'id'                =>  $sfv->ofid,
            'title'             =>  $post_title,
            'size'              =>  $file_size
        ));
    }
    jkof_dj($output);
}