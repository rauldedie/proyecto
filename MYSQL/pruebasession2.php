<?php

session_start(); //inicializa una sesion
//esto me premite hacer uso de una vbl llamada $_SESSION que es un array

if ($_SESSION["idusuario"])
{
    echo "<p>El usuario ".$_SESSION["idusuario"]." , ha iniciado sesion.</p>";
}else
{
    echo "<p>No ha iniciado sesion</p>";
}

?>