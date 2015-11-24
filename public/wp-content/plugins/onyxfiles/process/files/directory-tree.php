<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/8/2015
 * Time: 6:10 PM
 */

function jkof_dir_filetree(){
    if(!isset($_POST['dir'])){
        die();
    }

    global $current_user;
    $dir                =   urldecode($_POST['dir']);
    $current_user       =   wp_get_current_user();
    $role               =   empty($current_user->roles) ? "Guests" : ucfirst($current_user->roles[0]);

    if($role === "Administrator"){
        $root           =   get_home_path();
    }else{
        $root           =   OF_DIR;
    }
    echo $root;

    if( file_exists($root . $dir) ) {
        $files          =   scandir($root . $dir);
        natcasesort($files);

        if( count($files) > 2 ) { /* The 2 accounts for . and .. */
            echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
            // All dirs
            foreach( $files as $file ) {
                if( file_exists($root . $dir . $file) && $file != '.' && $file != '..' && is_dir($root . $dir . $file) ) {
                    echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($dir . $file) . "/\">" . htmlentities($file) . "</a></li>";
                }
            }
            echo "</ul>";
        }
    }
    die();
}