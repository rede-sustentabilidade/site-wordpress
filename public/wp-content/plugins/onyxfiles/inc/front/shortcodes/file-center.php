<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/7/2015
 * Time: 12:55 PM
 */

function jkof_front_file_center(){
    $file_center_html   =   file_get_contents( 'file-center.tpl.php', true );

    // Translations
    $file_center_html       =   str_replace("FILE_CENTER_TRANSLATION", __('File Center', 'onyxfiles'), $file_center_html);
    $file_center_html       =   str_replace("SHARE_TEXT_TRANSLATION", __('The following files have been shared with you.', 'onyxfiles'), $file_center_html);

    return $file_center_html;
}