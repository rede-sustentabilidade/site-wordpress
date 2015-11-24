<?php

function jkof_create_dl_page( $content ){
    global $post;

    if($post->post_type != "of_files"){
        return $content;
    }

    if( !is_single() ){
        return $content;
    }

    $file_data          =   get_post_meta( $post->ID, 'jkof_dl_settings', true );
    $file_data['files'] =   json_decode($file_data['files']);
    $dl_page_html       =   file_get_contents( 'download-page.tpl.php', true );
    $file_count         =   count($file_data['files']);
    $file_dls           =   $file_data['dl_count'];
    $file_size          =   0;
    $post_time          =   date( "M d, Y h:ia", get_post_time() );

    foreach($file_data['files'] as $file_key => $file_val){
        $file_size      +=   $file_val->size;
    }

    $file_size          =    FileSizeConvert($file_size);

    if($file_data['audio_player'] == 2){
        $music_player_html  =   file_get_contents( 'music-player.tpl.php', true );
        $dl_page_html       =   str_replace("<!-- MUSIC_PLAYER_PLACEHOLDER -->", $music_player_html, $dl_page_html);
        $mp3_files          =   array();
        $mp3_list_str       =   '';
        $upload_dir         =   wp_upload_dir();
        $user_dir           =   get_user_meta($file_data['aid'], 'of_upl_dir', true);

        foreach( $file_data['files'] as $file_key => $file_val ){
            $ext            =   get_extension($file_val->name);
            if($ext === "mp3"){
                $mp3_url    =   $upload_dir['baseurl'] . '/onyx-files/'  . $user_dir . '/' . $file_val->name;
                if($file_key === 0){
                    $mp3_list_str   .=  '
                    <li class="selected"><a href="' . $mp3_url. '"><b>' . $file_val->name . '</b></a></li>
                ';
                }else{
                    $mp3_list_str   .=  '
                    <li><a href="' . $mp3_url. '"><b>' . $file_val->name . '</b></a></li>
                ';
                }

                array_push($mp3_files, $file_val);
            }
        }

        $dl_page_html       =   str_replace("MP3_LIST_PLACEHOLDER", $mp3_list_str, $dl_page_html);
        $dl_page_html       =   str_replace("FIRST_MP3_TITLE_PLACEHOLDER", $mp3_files[0]->name, $dl_page_html);
    }

    // Translations
    $dl_page_html       =   str_replace("FILE_SIZE_TRANSLATION", __('File Size', 'onyxfiles'), $dl_page_html);
    $dl_page_html       =   str_replace("FILE_NUM_TRANSLATION", __('Number of Files', 'onyxfiles'), $dl_page_html);
    $dl_page_html       =   str_replace("DOWNLOAD_COUNT_TRANSLATION", __('Downloads', 'onyxfiles'), $dl_page_html);
    $dl_page_html       =   str_replace("POST_TIME_TRANSLATION", __('Created On', 'onyxfiles'), $dl_page_html);

    // Data
    $dl_page_html       =   str_replace("FILE_SIZE_PLACEHOLDER", $file_size, $dl_page_html);
    $dl_page_html       =   str_replace("FILE_NUM_PLACEHOLDER", $file_count, $dl_page_html);
    $dl_page_html       =   str_replace("DOWNLOAD_COUNT_PLACEHOLDER", $file_dls, $dl_page_html);
    $dl_page_html       =   str_replace("POST_TIME_PLACEHOLDER", $post_time, $dl_page_html);
    $dl_btn             =   new JKOF_Download_Btn($file_data);
    $dl_btn->build(false, $post->ID, true);
    $dl_page_html       =   str_replace("DOWNLOAD_BUTTON_PLACEHOLDER", $dl_btn->display_btn(), $dl_page_html);

    return $dl_page_html . $content;
}