<?php

function jkof_add_admin_menu(){
    add_submenu_page( 
        "edit.php?post_type=of_files" , 
        __( 'Email Subscribers - Onyx Files', 'onyxfiles' ),
        __( 'Email Subscribers', 'onyxfiles' ),
        'read' , 
        'of_email_list' , 
        'jkof_display_email_list_page'
    );
    
    add_submenu_page( 
        "edit.php?post_type=of_files" ,
        __( 'Statistics - Onyx Files', 'onyxfiles' ),
        __( 'Statistics', 'onyxfiles' ) ,
        'read' , 
        'of_stats' , 
        'jkof_display_stats_page'
    );
    
    add_submenu_page( 
        "edit.php?post_type=of_files" ,
        __( 'Configuration - Onyx Files', 'onyxfiles' ),
        __( 'Configuration', 'onyxfiles' ),
        'manage_options' , 
        'of_settings' , 
        'jkof_display_settings_page'
    );
}