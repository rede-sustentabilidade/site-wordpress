<?php

function jkof_delete_emails(){
    if(!current_user_can("manage_options")){
        die("ACTION_DENIED");
    }
    
    global $wpdb;

    foreach($_POST['emails'] as $eid){
        $wpdb->delete( $wpdb->prefix . 'of_emails', array( 'id' => $eid ), array( '%d' ) );
    }

    die();
}

function jkof_export_selected_emails(){
    global $wpdb;
    $email_list             =   array();

    foreach($_POST['emails'] as $eid){
        $row             =   $wpdb->get_row("SELECT `form_fields` FROM " . $wpdb->prefix . "of_emails WHERE id=" . intval($eid));
        $fields             =   json_decode($row->form_fields);
        $field_text             =   '';

        foreach($fields as $fv){
            foreach($fv as $field_value){
                $field_text .=  $field_value . ',';
            }
        }

        $field_text         =   rtrim($field_text, ",");
        array_push($email_list, $field_text);
    }

    $handle = fopen("emails.csv", "w");
    fwrite($handle, implode("\r\n", $email_list));
    fclose($handle);

    die();
}

function jkof_export_all_emails(){
    global $wpdb;
    $email_list             =   array();
    $of_emails              =   $wpdb->get_results("SELECT `form_fields` FROM " . $wpdb->prefix . "of_emails");

    foreach($of_emails as $of_email){
        $fields                 =   json_decode($of_email->form_fields);
        $field_text             =   '';

        foreach($fields as $fv){
            foreach($fv as $field_value){
                $field_text .=  $field_value . ',';
            }
        }

        $field_text         =   rtrim($field_text, ",");
        array_push($email_list, $field_text);
    }

    $handle = fopen("emails.csv", "w");
    fwrite($handle, implode("\r\n", $email_list));
    fclose($handle);

    die();
}

function jkof_export_unique_emails(){
    global $wpdb;
    $email_list             =   array();
    $of_emails              =   $wpdb->get_results("SELECT `form_fields` FROM " . $wpdb->prefix . "of_emails");
    $used_emails            =   array();


    foreach($of_emails as $of_email){
        $fields                 =   json_decode($of_email->form_fields);
        $field_text             =   '';

        if(in_array($fields[0]->email, $used_emails)){
            continue;
        }
        array_push($used_emails, $fields[0]->email);

        foreach($fields as $fv){
            foreach($fv as $field_key => $field_value){
                $field_text .=  $field_value . ',';
            }
        }

        $field_text         =   rtrim($field_text, ",");
        array_push($email_list, $field_text);
    }

    $handle = fopen("emails.csv", "w");
    fwrite($handle, implode("\r\n", $email_list));
    fclose($handle);

    die();
}