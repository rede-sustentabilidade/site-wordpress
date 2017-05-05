<?php

$cep = filter_input(INPUT_GET, 'cep', FILTER_SANITIZE_SPECIAL_CHARS);
$ch = curl_init("http://cep.correiocontrol.com.br/".$cep.".json");


curl_setopt($ch, CURLOPT_HEADER, 0);

// Use output buffering instead of returntransfer -itmaybebuggy 
ob_start(); 
curl_exec($ch); 
curl_close($ch); 
$retrievedhtml = ob_get_contents(); 
ob_end_clean();
header('Content-Type: application/json');
echo $retrievedhtml;
