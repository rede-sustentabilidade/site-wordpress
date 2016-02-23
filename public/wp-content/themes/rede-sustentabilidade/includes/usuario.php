<?php

function is_logged_in() {
    global $usuario;

    if (!empty($usuario)) {
        return $usuario;
    }
    return false;
}

function force_logged_in() {
    $usuario = is_logged_in();

    if ($usuario) {
        return $usuario;
    }
    wp_redirect(site_url() . '/?login=1');
    return false;
}

function is_filiado() {
    $usuario = is_logged_in();
    $ApiRede = ApiRede::getInstance();
    $filiado = $ApiRede->getProfile($usuario->id); // trocar para e-mail

    if ((is_array($filiado)) && ($filiado['httpCode'] == 404)) {
        return false;
    } else if (
        ($filiado) && (
            ($filiado->status == 3) ||
            ($filiado->status > 10)
        )) {
        return true;
    }
    return false;
}

?>