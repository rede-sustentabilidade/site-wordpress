<?php

function jkof_check_email(){
    global $wpdb;
    $output                     =   array('status' => 1);
    $email                      =   secure($_POST['jkof_email']);
    $fid                        =   intval($_POST['fid']);
    $file_settings              =   get_post_meta( $fid, 'jkof_dl_settings', true );
    $jkof_settings              =   get_option( 'jkof_settings' );
    $fields                     =   array();

    if(empty($file_settings)){
        jkof_dj($output);
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        jkof_dj($output);
    }

    $domain_email        =    array_pop(explode('@', $email));
    if(in_array($domain_email, $jkof_settings['blocked']['domains'])){
        jkof_dj($output);
    }
    if(in_array($email, $jkof_settings['blocked']['emails'])){
        jkof_dj($output);
    }

    foreach( $_POST as $fk => $fv ){
        if($fk == 'jkof_email'){
            array_push($fields, array(
                'email'     =>  $email
            ));
            continue;
        }

        if(empty($fv)){
            jkof_dj($output);
        }

        if($fk == "fid" || $fk == "action"){
            continue;
        }
        array_push($fields, array(
            secure($fk)     =>  secure($fv)
        ));
    }

    $wpdb->insert( 
        $wpdb->prefix . 'of_emails', 
        array( 
            'form_fields'   =>    json_encode($fields),
            'fid'           =>    $fid,
            "time_sent"     =>    time()
        ), 
        array( '%s', '%d', '%d' ) 
    );

    $wpdb->insert(
        $wpdb->prefix . 'of_verified_downloads',
        array(
            "fid"           =>  $fid,
            "ip"            =>  jkof_get_ip(),
            "time_verified" =>  time()
        ),
        array( '%d', '%s', '%d' )
    );

    if($file_settings['lock_email_type'] == 1){
        $message            =   '
        <div style="font-family: arial, sans-serif;">
            <div style="width: 100%; background-color: #49BF85; padding: 25px;">
                <h1 style="text-align: center;color: #fff;">Download Files</h1>
            </div>
            <div style="margin-top: 10px; margni-bottom: 10px;">DOWNLOAD_LINK_INSERTION</div>
            <p style="text-align: center; color: #424242;">Download provided by ' . get_bloginfo('name') . '.</p>
        </div>
        ';

        if($file_settings['indiv_dls'] == 2){
            $downloads        =    '
                <a href="' . get_site_url() . '?ofdl=' . $fid . '"
                    style="display:block; padding: 10px; width: 100%; margin-bottom: 5px; background-color: #1abc9c; color: #fff; text-align: center; text-decoration: none;">
                    Download All File
                </a>
            ';

            $file_list      =    json_decode($file_settings['files']);

            foreach( $file_list as $file_key => $file_value ){
                $fileTitle  =    $file_value->isDirect == 1 ? "Download " . $file_value->name : "Go to File";
                $fileURL    =    $file_value->isDirect == 1 ? "?ofdl=" . $fid . "&idl=" . $file_key : $file_value->direct_url;
                $downloads    .=    '
                <a href="' . get_site_url() . $fileURL  . '"
                    style="display:block; padding: 10px; width: 100%; margin-bottom: 5px; background-color: #34495e; color: #fff; text-align: center; text-decoration: none;">
                    ' . $fileTitle. '
                </a>
                ';
            }
        }else{
            $downloads      =    '
                <a href="' . get_site_url() . '?ofdl=' . $fid . '"
                    style="display:block; padding: 10px; width: 100%; margin-bottom: 5px; background-color: #1abc9c; color: #fff; text-align: center; text-decoration: none;">
                    Download File
                </a>
            ';
        }
        $message        =   str_replace("DOWNLOAD_LINK_INSERTION", $downloads, $message);

        if(wp_mail( $email, get_bloginfo('name') . " - Here's your file download!", $message, array('Content-Type: text/html; charset=UTF-8') )){
            $output['status']   =   3;
        }
    }else{
        $output['status']   =   2;
    }

    jkof_dj($output);
}