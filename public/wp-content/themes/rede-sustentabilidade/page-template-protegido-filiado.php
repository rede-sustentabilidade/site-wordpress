<?php
/**
 * Template name: Visível somente p/ filiados
 */

if (!is_filiado()) {
    echo "<h1>Acesso restrito</h1>";
    exit;
}
?>

<?php require_once('page.php'); ?>