<?php

$headers  = 'MIME-Version: 1.1' . "\n";
$headers .= 'Content-type: text/plain; charset=utf-8' ."\n";
$headers .= 'From: ' . $_POST['name']  . ' <contato@redesustentabilidade.org.br>' . "\n";
$headers .= 'Return-Path: contato@redesustentabilidade.org.br' . "\n";
$headers .= 'Reply-To: ' . $_POST['name'] . ' <' . $_POST['email'] . '>' ."\n";
$envio = mail('contato@redesustentabilidade.org.br', '[Contato #rede] ' . $_POST['name'] . ' <' . $_POST['email'] . '>', $_POST['message'], $headers , '-rcontato@redesustentabilidade.org.br');

if ($envio) {
    echo json_encode(array('status' => true));
}else {
    echo json_encode(array('status' => false));
}
