<?php

$asunto = "No reply: Recueracion contraseña";
$mensaje = "Hola ".$fila[nombre]." ".$fila[apellidos].", su usuario es: ".$usuario." y su contraseña es ".$pass."\n"."Acceda a https://iawraul-com.stackstaging.com/recuperacion/recuperacion.php y cambie por una nueva contraseña";
$from = "info@iawraul.com";
$cabecera = "From:".$from;
mail($fila[mail],$asunto,$mensaje,$cabecera);

?>