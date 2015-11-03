<?php
set_time_limit(0);
require_once("../../../../wp-config.php");

$usuario_sem_perfil = get_users(array('role'=> ''));
$i=0;
foreach ($usuario_sem_perfil as $key => $value) {
	if (count($value->roles)==0) {
		$user_id = $value->ID;

		$update_user = wp_update_user(array('ID'=>$user_id, 'role'=>'subscriber'));

		if ( (is_object($update_user)) && (get_class($update_user) == 'WP_Error')) {
			echo $i . " - " . $user_id . " - " . $update_user->get_error_message() . "\n";
		} else {
			echo $i . " - " . $user_id . " - ATUALIZADO \n";
		}
	}
}