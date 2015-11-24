<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/27/2015
 * Time: 6:34 PM
 */

function jkof_get_downloads(){
    global $wpdb;
    $output                 =   array( 'status' => 1 );
    $fid                    =   intval($_POST['fid']);
    $file_settings          =   get_post_meta( $fid, 'jkof_dl_settings', true );
    $jkof_settings          =   get_option( 'jkof_settings' );
    $time_exp               =   time() - ($jkof_settings['general']['unlocked_dl_exp'] * 3600);
    $current_user           =   wp_get_current_user();
    $username               =   empty($current_user) ? null : $current_user->user_login;
    $locks                  =   json_decode($file_settings['lock_opts']);
    $ip                     =   jkof_get_ip();

    if(empty($file_settings)){
        jkof_dj($output);
    }

    $download_count         =   $wpdb->get_var("
      SELECT COUNT(*) FROM `" . $wpdb->prefix . "of_verified_downloads`
      WHERE fid='" . $fid . "' AND time_verified>'" . $time_exp . "' AND ip='" . $ip . "'
    ");


    $share_count            =   is_user_logged_in() ? $wpdb->get_var("
      SELECT COUNT(*) FROM `" . $wpdb->prefix . "of_file_shares`
      WHERE ofid='" . $fid . "' AND username='" . $username . "' AND share_type='1'
    ") : 0;

    if(!$download_count  && !empty($locks) && !$share_count ){
        jkof_dj($output);
    }

    $output['files']        =   array();

    if($file_settings['indiv_dls'] === 2){
        $file_list              =    json_decode($file_settings['files']);
        foreach( $file_list as $file_key => $file_value ){
            $fileTitle          =    $file_value->isDirect == 1 ? "Download " . $file_value->name: "Go To File";
            $fileURL            =    $file_value->isDirect == 1 ? "?ofdl=" . $fid . "&idl=" . $file_key: $file_value->direct_url;
            array_push($output['files'], array(
                "title"         =>  $fileTitle,
                "url"           =>  $fileURL
            ));
        }
    }
    $output['a']            =   $share_count . " " . $download_count . " ip:" . $ip;
    $output['indiv_dls']    =   $file_settings['indiv_dls'];
    $output['status']       =   2;
    jkof_dj($output);
}