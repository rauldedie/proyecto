<?php

    $metodo = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($metodo);
    $options = 0;
    $vectorcript = '102938475601928374651234567890';
    $key = "K1s10p2A";

    $usuariocript= openssl_encrypt($usuario, $metodo,$key, $options, $vectorcript);

?>