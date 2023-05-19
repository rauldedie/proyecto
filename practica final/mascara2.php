<?php
// Store a string into the variable which
// need to be Encrypted
$nombre="Antonio";
$apellidos="Empresa";
$mail="antonioempresa.org";
$telefono="123456789";
$rol="profesorado";
$nombreusu = "rocioalvarezgarrido";
  
// Store the cipher method
$metodo = "AES-128-CTR";
  
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($metodo);
$options = 0;
  
// Non-NULL Initialization Vector for encryption
$vectorcript = '102938475601928374651234567890';
  
// Store the encryption key
$key = "K1s10p2A";
  
// Use openssl_encrypt() function to encrypt the data
$nombrecrip = openssl_encrypt($nombre, $metodo,$key, $options, $vectorcript);
$apellidoscrip = openssl_encrypt($apellidos, $metodo,$key, $options, $vectorcript);
$mailcrip = openssl_encrypt($mail, $metodo,$key, $options, $vectorcript);
$telefonocrip = openssl_encrypt($telefono, $metodo,$key, $options, $vectorcript);
$nombreusucrip = openssl_encrypt($nombreusu, $metodo,$key, $options, $vectorcript);
$rolcrip = openssl_encrypt($rol, $metodo,$key, $options, $vectorcript);

  
// Display the encrypted string
echo "nombre: " . $nombrecrip. "<br>";
echo "apellidos: " . $apellidoscrip . "<br>";
echo "mail: " . $mailcrip . "<br>";
echo "telefono: " . $telefonocrip. "<br>";
echo "nombreusuario: " . $nombreusucrip. "<br>";
echo "rol: " . $rolcrip . "<br>";

// Non-NULL Initialization Vector for decryption
$decryption_iv = '102938475601928374651234567890';
  
// Store the decryption key
$decryption_key = "K1s10p2A";
  
// Use openssl_decrypt() function to decrypt the data
$nombredecrip=openssl_decrypt ($nombrecrip, $metodo,$key, $options, $vectorcript);
$apellidosdecrip = openssl_decrypt($apellidoscrip, $metodo,$key, $options, $vectorcript);
$maildecrip = openssl_decrypt($mailcrip, $metodo,$key, $options, $vectorcript);
$telefonodecrip = openssl_decrypt($telefonocrip, $metodo,$key, $options, $vectorcript);
$nombreusudecrip = openssl_decrypt($nombreusucrip, $metodo,$key, $options, $vectorcript);
$roldecrip = openssl_decrypt($rolcrip, $metodo,$key, $options, $vectorcript);

  
// Display the encrypted string
echo "nombre: " . $nombredecrip. "<br>";
echo "apellidos: " . $apellidosdecrip . "<br>";
echo "mail: " . $maildecrip . "<br>";
echo "telefono: " . $telefonodecrip. "<br>";
echo "nombreusuario: " . $nombreusudecrip. "<br>";
echo "rol: " . $roldecrip . "<br>";
/*  
// Display the decrypted string
echo "Decrypted String: " . $decryption;*/
?>