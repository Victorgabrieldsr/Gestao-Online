<?php

function criptografarSenha($data, $conn){
    $senha = 'sua-senha';
    $iv = openssl_random_pseudo_bytes(16);
    $encrypt = openssl_encrypt($data, 'AES-256-CBC', $chave, 0, $iv);
    return base64_encode($encrypt . '::' . $iv);
}

function descriptografarSenha($data, $conn){
    $senha = 'sua-senha';
    list($encrypt, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypt, 'AES-256-CBC', $chave, 0, $iv);
}

?>