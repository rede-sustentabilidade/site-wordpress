<?php

function is_logged_in() {
    global $usuario;
    if (!empty($usuario)) {
        $ApiRede = ApiRede::getInstance();
        return $ApiRede->getProfile($usuario->id); // trocar para e-mail
    }
    return false;
}

function force_logged_in() {
    $filiado = is_logged_in();

    if ($filiado) {
        return $filiado;
    }
    wp_redirect(site_url() . '/?login=1');
    return false;
}

function is_filiado() {
    $filiado = is_logged_in();
    if (
        ($filiado) && (
            ($filiado->status == 3) ||
            ($filiado->status > 10)
        )) {
        return true;
    }

    return false;
}

?>