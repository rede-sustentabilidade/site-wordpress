<?php

function jkof_download_shortcode( $atts ){
    $file_settings    =    get_post_meta( $atts['id'], 'jkof_dl_settings', true );

    // Check if File exists
    if(empty($file_settings)){
        return null;
    }

    // Check if availability or expiration is set
    if( $file_settings['available'] > 1000 ){
        $dl_available    =    $file_settings['available'];
        if($dl_available > time()){
            return null;
        }
    }

    if( $file_settings['expires'] > 1000 ){
        $dl_expires    =    $file_settings['expires'];
        if($dl_expires < time()){
            return null;
        }
    }

    // Update file
    $file_settings['view_count']++;
    update_post_meta( $atts['id'], 'jkof_dl_settings', $file_settings );

    // Button Settings
    $dl_btn                             =   new JKOF_Download_Btn($file_settings);
    $dl_btn->build(false, $atts['id']);
    return $dl_btn->display_btn();
}