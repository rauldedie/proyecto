<?php
session_start();
if ((array_key_exists("usuario",$_SESSION) AND $_SESSION['id'])){
    // Si ya tenia la sesion iniciada
    //header("Location: include/paneladmin.php?rol=" . $_COOKIE["rol"]);
    header("Location: prueba.php");
}

// Guardar datos de sesión
$_SESSION["usuario"] = "Raul";
$_SESSION["id"] = "1";

echo "Sesión iniciada y establecido nombre de usuario!" . "<br>";
?>
<a href="segundo.php">Segundo!</a>