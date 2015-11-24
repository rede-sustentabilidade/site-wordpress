<?php

function jkof_save_post( $ID, $post, $update ){
    if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || !$update ){
        return $ID;
    }

    global $wpdb;
    $jkof_settings                      =   get_option( 'jkof_settings' );
    $file_size                          =   0;
    $dl_settings                        =   array();
    $dl_settings['pid']                 =   $ID;
    $dl_settings['aid']                 =   get_current_user_id();
    $dl_settings['files']               =   json_decode(stripslashes_deep($_POST['jkof_inputFilesArr']));
    $dl_settings['file_count']          =   count($dl_settings['files']);
    $dl_settings['is_multi']            =   $dl_settings['file_count'] > 1 ? true : false;

    // Basic Settings
    $dl_settings['dl_limit']            =   intval($_POST['jkof_dl_limit']);
    $dl_settings['dl_user_limit']       =   intval($_POST['jkof_dl_limit_per_user']);
    $dl_settings['dl_daily_limit']      =   intval($_POST['inputDLDailyLimit']);
    $dl_settings['view_count']          =   intval($_POST['jkof_view_count']);
    $dl_settings['dl_count']            =   intval($_POST['jkof_download_count']);
    $dl_settings['indiv_dls']           =   $_POST['jkof_idl'] == 2 ? 2 : 1;
    $dl_settings['audio_player']        =   $_POST['jkof_audio_player'] == 2 ? 2 : 1;
    $dl_settings['available']           =   !empty($_POST['jkof_dl_available']) ? strtotime($_POST['jkof_dl_available']) : '';
    $dl_settings['expires']             =   !empty($_POST['jkof_dl_expire']) ? strtotime($_POST['jkof_dl_expire']) : '';

    // User Settings
    $dl_settings['access_level']        =   json_encode($_POST['jkof_access_level']);
    $dl_settings['users_allowed']       =   secure($_POST['inputUsersAllowed']);
    $dl_settings['users_disallowed']    =   secure($_POST['inputUsersDisallowed']);

    // Lock Settings
    $dl_settings['lock_opts']           =   !empty($_POST['selectLockOpts']) ? json_encode($_POST['selectLockOpts']) : "[]";
    $dl_settings['lock_password']       =   secure($_POST['inputLockPW']);
    $dl_settings['lock_li_m']           =   secure($_POST['inputLockLinkedinShareMessage']);
    $dl_settings['lock_li_url']         =   secure($_POST['inputLockLinkedinShareURL']);
    $dl_settings['lock_fb_share_url']   =   secure($_POST['inputLockFBShareURL']);
    $dl_settings['lock_fb_like_url']    =   secure($_POST['inputLockFBLikeURL']);
    $dl_settings['lock_twitter_u']      =   secure($_POST['inputLockTwitterUsername']);
    $dl_settings['lock_tweet_m']        =   secure($_POST['inputLockTweetMessage']);
    $dl_settings['lock_gplus_url']      =   secure($_POST['inputLockGPlusURL']);
    $dl_settings['lock_email_type']     =   secure($_POST['selectLockEmailDLType']);
    $dl_settings['lock_pp_amount']      =   round(floatval($_POST['inputPPAmount']), 2);

    // Button Settings
    $dl_settings['label']               =   secure( $_POST['jkof_btn_label'] );
    $dl_settings['color']               =   secure( $_POST['jkof_btn_color'] );
    $dl_settings['size']                =   secure( $_POST['jkof_btn_size'] );
    $dl_settings['effect']              =   secure( $_POST['jkof_btn_effect'] );
    $dl_settings['enhancement']         =   secure( $_POST['jkof_btn_enhancement'] );
    $dl_settings['shape']               =   secure( $_POST['jkof_btn_shape'] );
    $dl_settings['style']               =   secure( $_POST['jkof_btn_style'] );
    $dl_settings['icon']                =   secure( $_POST['selectBtnIcons'] );
    $upl_dir                            =   is_user_logged_in() ? get_user_meta(get_current_user_id(), 'of_upl_dir', true)  : 'guests' ;

    if(empty($upl_dir)){
        $upl_dir                        =   jkof_create_upl_dir();
    }

    // Prepare File Name
    if( $dl_settings['file_count'] > 1){
        $package_name                   =   empty($post->post_title) ? time() . ".zip" : $post->post_title . ".zip";
    }else{
        $package_name                   =   $dl_settings['files'][0]->name;
    }
    $dl_settings['name']                =   $package_name;
    $dl_settings['s3_loc']              =   null;
    $dl_settings['s3_uploaded']         =   1;

    // Get Variable Count
    $fileCountQuery                     =   $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "of_files
                                                             WHERE ofid='" . $ID . "'" );
    // Zip Files
    if($dl_settings['is_multi']){
        $file_arr                       =   array();
        foreach($dl_settings['files'] as $file_key => $file_val){
            $fileObj                    =   $file_val;

            if($fileObj->isDirect == 2){
                continue;
            }

            $file_size                  +=   $fileObj->size;
            array_push( $file_arr, $fileObj->name );
        }
        $zip_file                       =   $dl_settings['name'];
        $overwrite                      =   $fileCountQuery != 0 ? true : false;

        if(!create_zip( $file_arr, OF_DIR . "zip/" . $zip_file, $upl_dir, $overwrite )){
            die('Unable to Zip File');
            return;
        }
        $dl_settings['file_location']   =   OF_DIR . 'zip/' . $package_name;
    }else{
        $fileObj                        =   $dl_settings['files'][0];
        $dl_settings['file_location']   =   OF_DIR . '/' . $upl_dir . '/' . $package_name;
        if($fileObj->isDirect != 2){
            $file_size                  +=  $fileObj->size;
        }
    }

    // Amazon Upload
    if(!empty($jkof_settings['storage']['aws_access_key'])){
        //instantiate the class
        $s3                             =    new S3($jkof_settings['storage']['aws_access_key'], $jkof_settings['storage']['aws_secret_key']);

        S3::putObject(
            $s3->inputFile($dl_settings['file_location'], false),
            $jkof_settings['storage']['aws_bucket_name'],
            $package_name,
            S3::ACL_PUBLIC_READ,
            array(),
            array()
        );
        $dl_settings['s3_loc']          =   'https://'.$jkof_settings['storage']['aws_bucket_name'].'.s3.amazonaws.com/'.$package_name;
        $dl_settings['s3_uploaded']     =   2;
    }

    if($fileCountQuery != 0){
        $wpdb->update( 
            $wpdb->prefix . 'of_files', 
            array(
                "thumbnail"        =>    get_the_post_thumbnail( $ID, array(64,64) ), 
                "title"            =>    $post->post_title,
                "file_size"        =>    $file_size,
                "downloads"        =>    0
            ),
            array( "ofid" => $ID ), 
            array( '%s', '%s', '%d', '%d' ),
            array( '%d' ) 
        );
    }else{
        $wpdb->insert( 
            $wpdb->prefix . 'of_files', 
            array(
                "ofid"             =>    $ID,
                "thumbnail"        =>    get_the_post_thumbnail( $ID, array(64,64) ), 
                "title"            =>    $post->post_title,
                "file_size"        =>    $file_size,
                "downloads"        =>    0
            ), 
            array( '%d', '%s', '%s', '%d', '%d' ) 
        );
        
    }

    $dl_settings['files']               =   json_encode($dl_settings['files']);

    // Delete File Sharing Query
    $shared_usernames                   =   explode(',', $dl_settings['users_allowed']);
    $disallowed_usernames               =   explode(',', $dl_settings['users_disallowed']);

    $wpdb->delete(
        $wpdb->prefix . 'of_file_shares',
        array( 'ofid' => $ID ),
        array( '%d' )
    );

    // Insert Shared Usernames - 1
    foreach( $shared_usernames as $uk => $uv ){
        $wpdb->insert(
            $wpdb->prefix . 'of_file_shares',
            array( 'ofid' => $ID, 'username' => $uv, 'share_type' => 1 ),
            array( '%d', '%s' )
        );
    }
    // Insert disallowed Users - 2
    foreach( $disallowed_usernames as $uk => $uv ){
        $wpdb->insert(
            $wpdb->prefix . 'of_file_shares',
            array( 'ofid' => $ID, 'username' => $uv, 'share_type' => 2),
            array( '%d', '%s', '%d' )
        );
    }

    // Save Post
    update_post_meta( $ID, 'jkof_dl_settings', $dl_settings );
    return $ID;
}