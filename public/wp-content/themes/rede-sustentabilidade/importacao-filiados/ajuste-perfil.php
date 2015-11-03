<?php
set_time_limit(0);
require_once("../../../../wp-config.php");

// get contents of a file into a string
//dirname(__FILE__)
$filename = './resultados/filiados.cvs.afl.new';
$i=0;
$handle = fopen($filename, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $i++;
        // process the line read.
        //
		$pattern = '/user_id=.{0,9}/';
		preg_match($pattern, $line, $matches); //, PREG_OFFSET_CAPTURE, 3);
		$user_id = substr($matches[0], 8, -1);
		//echo $user_id."\n";
        //if(count(get_userdata($user_id)) > 0) {
        	$update_user = wp_update_user(array('ID'=>$user_id, 'role'=>'filiado'));

        	if ( (is_object($update_user)) && (get_class($update_user) == 'WP_Error')) {
        		echo $i . " - " . $user_id . " - " . $update_user->get_error_message() . "\n";
        	} else {
        		echo $i . " - " . $user_id . " - ATUALIZADO \n";
        	}
        // }else {
        // 	echo $i . " - " . $user_id . " - NAO ENCONTRADO\n";
        // }
    }
} else {
    // error opening the file.
}