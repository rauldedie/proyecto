<?php
session_start();

// Guardar datos de sesión
$_SESSION["usuario"] = "Raul";

echo "Sesión iniciada y establecido nombre de usuario!" . "<br>";
?>