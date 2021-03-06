<?php

/*
Plugin Name: Gerenciador de filiados
Plugin URI: http://bitbucket.org/rede-sustentabilidade/portal-wp/
Description: Ferramenta com filtro e exportação os filiados, além da edição de algumas propriedades
Author: Lucas Pirola
Version: 0.1
Author URI: http://bitbucket.org/lucaspirola/
*/

include 'src/Filiados.php'; // Class File

add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy ();
}

// Create an instance of the Plugin Class
function call_filiados()
{
    return new Rede\Filiados('admin');
}

// Only when the current user is an Admin
if (is_admin()) {
    add_action('init', 'call_filiados');
}

// Helper function
if (!function_exists('ppf')) {
    function ppf()
    {
        return plugin_dir_url(__FILE__);
    }
}

function add_roles_on_afiliados_activation() {
   add_role( 'filiados', 'Gerenciar Filiados', array( 'manage_filiados'=>true ) );
   add_role( 'organizador_estadual', 'Organizador Estadual', array( 'manage_filiados'=>true ) );

   $role = get_role( 'administrator' );
   $role->add_cap( 'manage_filiados' );
}

register_activation_hook( __FILE__, 'add_roles_on_afiliados_activation' );

function remove_roles_on_afiliados_deactivation() {
  remove_role( 'filiados' );
  remove_role( 'organizador_estadual' );
}

register_deactivation_hook( __FILE__, 'remove_roles_on_afiliados_deactivation' );


add_action( 'admin_head', 'menu_highlight' );

function menu_highlight() {
	global $parent_file, $submenu_file, $post_type, $plugin_page;
    remove_submenu_page( 'rs_filiados', 'rs_filiado_profile' );
	if ( 'rs_filiado_profile' == $plugin_page ) :
		$parent_file = 'rs_filiados';
		$submenu_file = 'rs_filiados';

        
	endif;
}
