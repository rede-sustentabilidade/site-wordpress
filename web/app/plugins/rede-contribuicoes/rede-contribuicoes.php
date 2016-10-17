<?php

/*
Plugin Name: Relatórios de Contribuições
Plugin URI: http://bitbucket.org/rede-sustentabilidade/portal-wp/
Description: Ferramenta para exportar relatórios sobre as contribuições feitas através da esteira de pagamentos
Author: Lucas Pirola
Version: 0.1
Author URI: http://bitbucket.org/lucaspirola/
*/

include 'src/Contribuicoes.php'; // Class File

// Create an instance of the Plugin Class
function call_contribuicoes()
{
    return new Rede\Contribuicoes('admin');
}

// Only when the current user is an Admin
if (is_admin()) {
    add_action('init', 'call_contribuicoes');
}

// Helper function
if (!function_exists('pp')) {
    function pp()
    {
        return plugin_dir_url(__FILE__);
    }
}

function add_roles_on_plugin_activation() {
   add_role( 'finance', 'Financeiro', array( 'manage_finance'=>true ) );
}

register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );

function remove_roles_on_plugin_deactivation() {
  remove_role( 'finance' );
}

register_deactivation_hook( __FILE__, 'remove_roles_on_plugin_deactivation' );
