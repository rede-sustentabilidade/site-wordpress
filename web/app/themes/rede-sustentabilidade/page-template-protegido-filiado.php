<?php
/**
 * Template name: Visível somente p/ filiados
 */

if (!is_filiado()) {
    require_once('page-template-acesso-negado.php');
    exit;
}
?>

<?php require_once('page.php'); ?>