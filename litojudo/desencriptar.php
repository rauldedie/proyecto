<?php
$metodo = 'aes-256-abc';
$clave = '@Ndr0med@.2024';
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($metodo));

list ($datocry,$iv) = explode('::',base64_decode($datocry),2);
$datodcry = openssl_decrypt($datocryp,$metodo,$clave,0,$iv);

?>