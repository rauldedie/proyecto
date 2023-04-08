<?php

$asunto = "No reply: Registrado Correctamente";
$mensaje = "Bienvenido "+$nombre+" "+$apellidos+" se ha registrado correctamente, su usuarios es: "+$nuevousu+" y su contraseña es "+$nuevopass;
$cabecera = "From: Admin (info@iawraul.com)";
mail($mail,$asunto,$mensaje,$cabecera);

?>