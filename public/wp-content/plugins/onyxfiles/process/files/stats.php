<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/31/2015
 * Time: 6:01 PM
 */

function jkof_get_file_stats(){
    global $wpdb;
    $file_id                =   intval($_POST['fid']);
    $day_time               =   strtotime("today");
    $midnight               =   strtotime("yesterday");
    $output                 =   array( 'downloads' => array(), 'labels' => array() );

    for($i = 0; $i < 7; $i++){
        $start              =   $day_time - (86400 * $i);
        $end                =   $midnight - (86400 * $i);

        $download_count     =   $wpdb->get_var( "
          SELECT COUNT(*) FROM `" . $wpdb->prefix . "of_downloads`
          WHERE time_downloaded<'" . $start ."' AND time_downloaded>'" . $end . "'
          AND fid='" . $file_id . "'
        ");

        array_push( $output['downloads'], $download_count );
        array_push( $output['labels'], @date( "n/j/Y", $start) );
    }

    jkof_dj($output);
}