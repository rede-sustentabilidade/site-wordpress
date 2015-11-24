<?php

function jkof_front_enqueue() {
    /********************** STYLES **********************/
    wp_register_style( 'jkof_fa', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
    wp_register_style( 'jkof_bootstrap', plugins_url( '/components/front-bs/css/bootstrap.min.css', OF_PLUGIN_URL ) );
    wp_register_style( 'jkof_roboto', plugins_url( '/components/bootstrap-material-design/dist/css/roboto.min.css', OF_PLUGIN_URL ) );
    wp_register_style( 'jkof_flatton_buttons', plugins_url( '/components/flatton/css/web-buttons.min.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_flatton_colors', plugins_url( '/components/flatton/css/color-variations.min.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_flatton_social', plugins_url( '/components/flatton/css/social-colors.min.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_sm', plugins_url( '/components/soundmanager/demo/bar-ui/css/bar-ui.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_download', plugins_url( '/components/core/download.css', OF_PLUGIN_URL  ) );
    wp_register_style( 'jkof_main', plugins_url( '/components/core/main.css', OF_PLUGIN_URL  ) );

    wp_enqueue_style( 'jkof_fa' );
    wp_enqueue_style( 'jkof_bootstrap' );
    wp_enqueue_style( 'jkof_flatton_buttons' );
    wp_enqueue_style( 'jkof_roboto' );
    wp_enqueue_style( 'jkof_flatton_colors' );
    wp_enqueue_style( 'jkof_flatton_social' );
    wp_enqueue_style( 'jkof_sm' );
    wp_enqueue_style( 'jkof_download' );
    wp_enqueue_style( 'jkof_main' );

    /************************* SCRIPTS ********************************/
    wp_register_script( 'jkof_bootstrap', plugins_url( '/components/front-bs/js/bootstrap.min.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_sm', plugins_url( '/components/soundmanager/script/soundmanager2-jsmin.js', OF_PLUGIN_URL ), array('jquery'), '1.0.0', true );
    wp_register_script( 'jkof_download', plugins_url( '/components/core/download.js', OF_PLUGIN_URL ), array(), '1.0.0', true );
    wp_register_script( 'jkof_main', plugins_url( '/components/core/main.js', OF_PLUGIN_URL ), array(), '1.0.0', true );

    // Localize
    wp_localize_script( 'jkof_download', 'jkof_dl_i18n', array(
        'wait'                          =>  __('Please wait!', 'onyxfiles'),
        'checking_password'             =>  __('We are checking this password.', 'onyxfiles'),
        'error'                         =>  __('Error!', 'onyxfiles'),
        'success'                       =>  __('Success!', 'onyxfiles'),
        'denied'                        =>  __('Access Denied!', 'onyxfiles'),
        'try_later'                     =>  __('Try again later.', 'onyxfiles'),
        'getting_download'              =>  __('We will retrieve your download.', 'onyxfiles'),
        'unable'                        =>  __('Unable to download file.', 'onyxfiles'),
        'adding_email'                  =>  __('We are adding your e-mail.', 'onyxfiles'),
        'emailing_download'             =>  __('Your download will be e-mailed to you.', 'onyxfiles'),
        'linkedin'                      =>  __('We are adding this message to your wall.', 'onyxfiles'),
        'downloading_all_files'         =>  __('Download All Files', 'onyxfiles'),
        'download_file'                 =>  __('Download File', 'onyxfiles'),
        'linkedin_fail'                 =>  __('Unable to share on your profile.', 'onyxfiles')
    ));

    wp_enqueue_script( 'jkof_bootstrap' );
    wp_enqueue_script( 'jkof_sm' );
    wp_enqueue_script( 'jkof_download' );
    wp_enqueue_script( 'jkof_main' );
}