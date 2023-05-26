<?php
// Continuamos la sesión
session_start();
// Devolver los valores de sesión
echo "Nombre de usuario: " . $_SESSION["usuario"]."<br>";
echo "Nombre de usuario: " . $_SESSION["id"]."<br>";
$sql = "INSERT INTO accesos (idusuario, fecha) VALUES ({$idusuario}, '{$fecha}')";
echo $sql;
?>