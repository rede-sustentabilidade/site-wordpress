<?php

function jkof_create_metaboxes(){
    add_meta_box(
        'jkof_upload_mb',
        __( 'Upload Files', 'onyxfiles' ),
        'jkof_upload_mb',
        'of_files',
        'side',
        'high'
    );
    add_meta_box(
        'jkof_file_center_mb',
        __( 'Onyx File Center', 'onyxfiles' ),
        'jkof_file_center_mb',
        'of_files',
        'normal',
        'high'
    );
}