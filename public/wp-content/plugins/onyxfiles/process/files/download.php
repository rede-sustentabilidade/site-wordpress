<?php

function jkof_download_file(){
    if(!isset($_GET['ofdl'])){
        return;
    }

    global $wpdb, $current_user;
    $file_id            =   intval($_GET['ofdl']);
    $file_settings      =   get_post_meta( $file_id, 'jkof_dl_settings', true );
    $jkof_settings      =   get_option( 'jkof_settings' );

    if(empty($file_settings)){
        die("File Does Not Exist");
    }

    $file_name          =   $file_settings['name'];
    $current_user       =   wp_get_current_user();
    $username           =   empty($current_user) ? null : $current_user->user_login;
    $user_ip            =   jkof_get_ip();
    $access_level       =   json_decode($file_settings['access_level']);
    $file_locks         =   json_decode($file_settings['lock_opts']);
    $user_dir           =   get_user_meta($file_settings['aid'], 'of_upl_dir', true);
    $file_loc           =   $file_settings['is_multi'] ? OF_DIR . '/zip/' . $file_name : OF_DIR . $user_dir . '/' . $file_name;
    $time_exp           =   time() - ($jkof_settings['general']['unlocked_dl_exp'] * 3600);
    $paypal_count       =   0;
    $available          =   $file_settings['available'];
    $expires            =   $file_settings['expires'];
    $role               =   empty($current_user->roles) ? "Guests" : ucfirst($current_user->roles[0]);

    // Paypal Purchase
    if(isset($_GET['access_key'])){
        $txn_id             =   secure($_GET['access_key']);
        $paypal_count       =   $wpdb->get_var("
          SELECT COUNT(*) FROM `" . $wpdb->prefix . "of_payments`
          WHERE fid='" . $file_id . "' AND txn_id='" . $txn_id . "'
        ");
    }

    if(!empty($file_locks)){
        $download_count         =   $wpdb->get_var("
          SELECT COUNT(*) FROM `" . $wpdb->prefix . "of_verified_downloads`
          WHERE fid='" . $file_id . "' AND time_verified>'" . $time_exp . "'
        ");

        if(!$download_count && !$paypal_count){
            die("You are not allowed to download this file.");
        }
    }

    // Availability & Expiration
    if(!empty($available) && $available > time()){
        die("File is not available. Please try again at a later time.");
    }
    if(!empty($expires) && $expires < time()){
        die("This file has expired.");
    }

    // Role Level Check
    if(!in_array($role, $access_level) && !$paypal_count){
        die("You are not allowed to download this file.");
    }

    if($role !== "Guests"){
        $disallowed_count       =   $wpdb->get_var("
          SELECT COUNT(*) FROM `" . $wpdb->prefix . "of_file_shares`
          WHERE ofid='" . $file_id . "' AND username='" . $username . "' AND share_type='2'
        ");

        if($disallowed_count){
            die(" You are not allowed to download this file.");
        }
    }

    // Download Limit
    $file_downloads         =   $wpdb->get_var("SELECT COUNT(*) FROM `" . $wpdb->prefix . "of_downloads` WHERE fid='" . $file_id . "'");
    if($file_settings['dl_limit'] != 0 && $file_settings['dl_limit'] < $file_downloads && !$paypal_count){
        die("Maximum Download Limit Reached");
    }
    // Download Daily Limit
    $daily_downloads        =   $wpdb->get_var("
        SELECT COUNT(*) FROM `" . $wpdb->prefix . "of_downloads`
        WHERE fid='" . $file_id . "' AND time_downloaded>'" . (time() - 86400) . "'
    ");
    if($file_settings['dl_daily_limit'] != 0 && $file_settings['dl_daily_limit'] < $daily_downloads && !$paypal_count){
        die("Maximum Download Daily Limit Reached");
    }
    // User Download Limit
    $user_downloads         =   $wpdb->get_var("
      SELECT COUNT(*) FROM `" . $wpdb->prefix . "of_downloads`
      WHERE fid='" . $file_id . "' AND (username='" . $username . "' OR ip='" . $user_ip . "')
    ");
    if($file_settings['dl_user_limit'] != 0 && $file_settings['dl_user_limit'] < $user_downloads && !$paypal_count){
        die("You have reached the maximum download limit per user.");
    }

    if(isset($_GET['idl']) && $file_settings['indiv_dls'] === 2 && $_GET['idl'] !== "all"){
        $idl            =   $_GET['idl'] === "all" ? "all" : intval($_GET['idl']);
        $file_list      =    json_decode($file_settings['files']);

        if(isset($file_list[$idl])){
            $file_loc   =   OF_DIR . $user_dir . '/' . $file_list[$idl]->name;
        }
    }

    // Insert Download into Database
    $wpdb->insert(
        $wpdb->prefix . 'of_downloads',
        array(
            'username'          =>  $username,
            'ip'                =>  $user_ip,
            'time_downloaded'   =>  time(),
            'fid'               =>  $file_id
        ),
        array( '%s', '%s', '%d', '%d' )
    );
    $wpdb->query("UPDATE `" . $wpdb->prefix . "of_files` SET downloads=downloads+1 WHERE ofid='" . $file_id . "'");

    $file_settings['dl_count'] =   $file_settings['dl_count']+1;
    update_post_meta( $file_id, 'jkof_dl_settings', $file_settings );

    if($file_settings['s3_uploaded'] == 2 && !empty($jkof_settings['storage']['aws_access_key'])){
        header("location:" . $file_settings['s3_loc']);
        die();
    }


    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file_loc).'"');
    header('Content-Length: ' . filesize($file_loc));
    readfile($file_loc);
    die();
}