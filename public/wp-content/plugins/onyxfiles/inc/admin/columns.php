<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/31/2015
 * Time: 4:18 PM
 */
function add_new_of_columns($gallery_columns) {
    $new_columns['cb']          =   '<input type="checkbox" />';
    $new_columns['title']       =   __('Download Name', 'column name');
    $new_columns['shortcode']   =   __('Shortcode', 'onyxfiles');
    $new_columns['downloads']   =   __('Downloads', 'onyxfiles');
    $new_columns['views']       =   __('Views', 'onyxfiles');
    $new_columns['earnings']    =   __('Earnings', 'onyxfiles');
    $new_columns['daily_stats'] =   __('Daily Stats', 'onyxfiles');
    $new_columns['date']        =   __('Date', 'onyxfiles');
    return $new_columns;
}

function manage_of_columns($column_name, $id) {
    switch ($column_name) {
        case 'shortcode':
            echo "<div class='form-group'><input type='text' class='form-control' readonly value='[onyxfile id=" . $id . "]'></div>";
            break;
        case 'downloads':
            $file_settings    =    get_post_meta( $id, 'jkof_dl_settings', true );
            echo $file_settings['dl_count'];
            break;
        case 'views':
            $file_settings    =    get_post_meta( $id, 'jkof_dl_settings', true );
            echo $file_settings['view_count'];
            break;
        case 'earnings':
            $file_settings    =    get_post_meta( $id, 'jkof_dl_settings', true );
            echo "$";
            echo (isset($file_settings['earnings'])) ? $file_settings['earnings'] : "0.00";
            break;
        case 'daily_stats':
            echo '<a href="#" class="jkof_dailyStatsBtn" data-fid="' . $id . '">' . __( 'View Daily Stats', 'onyxfiles' ) . '</a>';
            break;
        default:
            break;
    } // end switch
}