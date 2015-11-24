<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/13/2015
 * Time: 7:46 PM
 */

function jkof_admin_head(){
    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "jkof_add_tinymce_plugin");
        add_filter('mce_buttons', 'jkof_register_tmce_btn');
    }
}