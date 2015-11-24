<?php

function jkof_activate_plugin()
{
    if ( version_compare( get_bloginfo( 'version' ), '3.8', '<' ) ){
        wp_die( "You must update WordPress to use this plugin!" );
    }
    // Create Tables
    // do NOT forget this global
    global $wpdb;
    $createSQL1         =   "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "of_downloads` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `username` varchar(255) DEFAULT NULL,
      `ip` varchar(255) NOT NULL,
      `time_downloaded` varchar(16) NOT NULL,
      `fid` bigint(20) unsigned NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
    $createSQL2         =   "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "of_verified_downloads` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `fid` bigint(20) unsigned NOT NULL,
      `ip` varchar(32) NOT NULL,
      `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
      `time_verified` int(11) unsigned NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
    $createSQL3         =   "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "of_emails` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `form_fields` text NOT NULL,
      `fid` bigint(20) unsigned NOT NULL,
      `time_sent` varchar(16) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
    $createSQL4         =   "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "of_payments` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `payer_id` varchar(255) NOT NULL,
      `name` varchar(255) NOT NULL,
      `amount` double(11,2) unsigned NOT NULL,
      `fid` bigint(20) unsigned NOT NULL,
      `buyer_email` varchar(255) NOT NULL,
      `verify_sign` varchar(255) NOT NULL,
      `txn_id` varchar(255) NOT NULL,
      `post_title` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";
    $createSQL5         =   "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "of_files` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `ofid` bigint(20) unsigned NOT NULL,
      `thumbnail` varchar(255) NOT NULL,
      `title` varchar(255) NOT NULL,
      `file_size` int(20) unsigned NOT NULL,
      `downloads` int(11) unsigned NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
    $createSQL6         =   "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "of_file_shares` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `ofid` bigint(20) unsigned NOT NULL,
      `username` varchar(255) NOT NULL,
      `share_type` tinyint(1) unsigned NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($createSQL1);
    dbDelta($createSQL2);
    dbDelta($createSQL3);
    dbDelta($createSQL4);
    dbDelta($createSQL5);
    dbDelta($createSQL6);

    // Create Options
    if( get_option( 'jkof_settings' ) === false ){
        // Create Options
        $jkof_settings          =   array(
            'version'           =>  3,
            'general'           =>  array(
                'unlocked_dl_exp'   =>  24,
                'max_upl_size'  =>  15
            ),
            "social"            =>     array(
                "fb_app_id"     =>    "",
                "li_api_key"    =>    "",
                "twitter_u"     =>    ""
            ),
            "paypal"            =>     array(
                "email"         =>    "",
                "currency"      =>      "USD",
                "earnings"      =>    0
            ),
            "blocked"           =>     array(
                "domains"       =>    array(),
                "emails"        =>    array()
            ),
            "message"           =>     array(
                "denied_dl"     =>    'You are not allowed to download this file.'
            )
        ,
            "storage"           =>     array(
                "dropbox_app_key"      =>    "",
                "aws_access_key"    =>  '',
                "aws_secret_key"    =>  '',
                "aws_bucket_name"   =>  ''
            ),
            "email_fields"      =>      array()
        );
        update_option( 'jkof_settings', $jkof_settings);
    }

    // Create Folders
    wp_mkdir_p( OF_DIR . "raw" );
    wp_mkdir_p( OF_DIR . "zip" );

    chmod( OF_DIR, 0777 );
    chmod( OF_DIR . "raw", 0777 );
    chmod( OF_DIR . "zip", 0777 );
}