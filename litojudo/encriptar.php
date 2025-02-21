<?php
/*$metodo = 'aes-256-abc';
$clave = '@Ndr0med@.2024';
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($metodo));
$datocry = openssl_encrypt($dato,$metodo,$clave,0,$iv);
$datocry = base64_encode($datocry.'::'.$iv);*/



$clave = sodium_crypto_secretbox_keygen();
$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
//$mensaje = 'datos_sensibles';
echo $clave."<br>";
echo $nonce."<br>";

$cifrado = sodium_crypto_secretbox($mensaje, $nonce, $clave);


$metodo = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($metodo);
$options = 0;
$vectorcript = '102938475601928374651234567890';
$key = "K1s10p2A";

$usuariocript= openssl_encrypt($usuario, $metodo,$key, $options, $vectorcript);




?>