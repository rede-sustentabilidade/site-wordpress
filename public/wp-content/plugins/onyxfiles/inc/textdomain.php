<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 6/5/2015
 * Time: 12:50 PM
 */
function jkof_load_textdomain() {
    $plugin_dir = 'onyxfiles/lang';
    load_plugin_textdomain( 'onyxfiles', false, $plugin_dir );
}