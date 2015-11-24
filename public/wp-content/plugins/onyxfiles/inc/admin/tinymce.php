<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/13/2015
 * Time: 7:49 PM
 */

function jkof_add_tinymce_plugin($plugin_array){
    //$plugin_array['jkof_files_btn']     =   plugins_url( '/components/core/tinymce.js', OF_PLUGIN_URL );
    return $plugin_array;
}

function jkof_register_tmce_btn($buttons){
    //array_push($buttons, "jkof_files_btn");
    return $buttons;
}