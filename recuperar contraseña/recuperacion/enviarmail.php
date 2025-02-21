<?php

$asunto = "No reply: Registrado Correctamente";
$mensaje = "Bienvenido ".$nombre." ".$apellidos.", su usuario es: ".$usuario." y su contraseña es ".$pass;
$from = "info@iawraul.com";
$cabecera = "From:".$from;
mail($mail,$asunto,$mensaje,$cabecera);

?>