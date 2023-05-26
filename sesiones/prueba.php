<?php
session_start();
echo "La sesion ya esta iniciada <br>";
echo "Nombre de usuario: " . $_SESSION["usuario"]."<br>";
echo "id de usuario: " . $_SESSION["id"]."<br>";
$sql = "INSERT INTO accesos (idusuario, fecha) VALUES ({$idusuario}, '{$fecha}')";
echo $sql;
?>