<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/23/2015
 * Time: 9:19 PM
 */
function jkof_save_fields_settings(){
    $output                                         =   array( 'status' => 1 );

    if ( !current_user_can( 'manage_options' ) ){
        jkof_dj($output);
    }

    $fields                                         =   isset($_POST['email_fields']) ? $_POST['email_fields'] : array();

    foreach($fields as $key => $value){
        unset($_POST['email_fields'][$key]['$$hashKey']);
        $fields[$key]['label']                      =   sanitize_text_field($value['label']);
        $fields[$key]['placeholder']                =   sanitize_text_field($value['placeholder']);
    }

    $jkof_settings                                  =   get_option( 'jkof_settings' );
    $jkof_settings['email_fields']                  =   $fields;
    $output['status']                               =   2;

    update_option( 'jkof_settings', $jkof_settings );
    jkof_dj($output);
}