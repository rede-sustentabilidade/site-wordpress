<?php

function jkof_process_pp_payment(){
    if(!isset($_POST['custom']) || $_POST['custom'] != "jkof_pp"){
        return;
    }

    global $wpdb;
    include('PayPal.php');
    $paypal                     =   new Paypal();
    $result                     =   $paypal->confirmIpn($_POST);

    //If a Paypal transaction ID was returned
    if(!is_string($result)) {
        die();
    }

    $payer_id                   =   secure($_POST['payer_id']);
    $name                       =   secure($_POST['address_name']);
    $payment_amount             =   secure($_POST['mc_gross']);
    $fid                        =   secure($_POST['item_number']);
    $buyer_email                =   secure($_POST['payer_email']);
    $verify_sign                =   secure($_POST['verify_sign']);
    $txn_id                     =   secure($_POST['txn_id']);
    $post_title                 =   secure($_POST['item_name']);
    $file_settings              =   get_post_meta( $fid, 'jkof_dl_settings', true );
    $jkof_settings              =   get_option( 'jkof_settings' );

    if(floatval($file_settings['lock_pp_amount']) != floatval($payment_amount)){
        return;
    }

    $wpdb->insert(
        $wpdb->prefix . 'of_payments',
        array(
            'payer_id'         =>    $payer_id,
            'name'             =>    $name,
            "amount"           =>    $payment_amount,
            "fid"              =>    $fid,
            'buyer_email'      =>    $buyer_email,
            'verify_sign'      =>    $verify_sign,
            "txn_id"           =>    $txn_id,
            "post_title"       =>    $post_title
        ),
        array( '%s', '%s', '%f', '%d', '%s', '%s', '%s', '%s')
    );

    $file_settings['earnings']              =    isset($file_settings['earnings']) ? $file_settings['earnings'] + $payment_amount: $payment_amount;
    $jkof_settings["paypal"]["earnings"]    =    (isset($jkof_settings["pp_settings"]["earnings"])) ? $jkof_settings["pp_settings"]["earnings"] + $payment_amount: $payment_amount;

    update_post_meta( $fid, 'jkof_dl_settings', $file_settings );
    update_option( "jkof_settings", $jkof_settings );

    $message            =   '
        <div style="font-family: arial, sans-serif;">
            <div style="width: 100%; background-color: #49BF85; padding: 25px;">
                <h1 style="text-align: center;color: #fff;">Download Files</h1>
            </div>
            <div style="margin-top: 10px; margni-bottom: 10px;">DOWNLOAD_LINK_INSERTION</div>
            <p style="text-align: center; color: #424242;">Download provided by ' . get_bloginfo('name') . '.</p>
        </div>
    ';

    // Set up Message
    if($file_settings['indiv_dls'] == 2){
        $downloads        =    '
            <a href="' . get_site_url() . '?ofdl=' . $fid . '&access_key=' . $txn_id . '"
                style="display:block; padding: 10px; width: 100%; margin-bottom: 5px; background-color: #1abc9c; color: #fff; text-align: center; text-decoration: none;">
                Download All Files
            </a>
        ';

        $file_list      =    json_decode($file_settings['files']);

        foreach( $file_list as $file_key => $file_value ){
            $fileTitle  =    $file_value->isDirect == 1 ? "Download " . $file_value->name : "Go to File";
            $fileURL    =    $file_value->isDirect == 1 ? "?ofdl=" . $fid . "&idl=" . $file_key . '&access_key=' . $txn_id : $file_value->direct_url;
            $downloads    .=    '
            <a href="' . get_site_url() . $fileURL  . '"
                style="display:block; padding: 10px; width: 100%; margin-bottom: 5px; background-color: #34495e; color: #fff; text-align: center; text-decoration: none;">
                ' . $fileTitle. '
            </a>
            ';
        }
    }else{
        $downloads      =    '
        <a href="' . get_site_url() . '?ofdl=' . $fid . '&access_key=' . $txn_id . '"
            style="display:block; padding: 10px; width: 100%; margin-bottom: 5px; background-color: #1abc9c; color: #fff; text-align: center; text-decoration: none;">
            Click here to download this file!
        </a>
      ';
    }

    $message        =   str_replace("DOWNLOAD_LINK_INSERTION", $downloads, $message);

    wp_mail( $buyer_email, "Here's your file download!", $message, array('Content-Type: text/html; charset=UTF-8') );
    die();

}
