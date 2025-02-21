<?php
$mail = "rauldedie@gmail.com";
$asunto = "No reply: Registrado Correctamente";
$mensaje = "Bienvenido";
$from = "info@iawraul.com";
$cabecera = "From:".$from;
mail($mail,$asunto,$mensaje,$cabecera);
?>