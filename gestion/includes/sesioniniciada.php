<?php

    session_start();
    //comprobamos si exste alguna cookie de sesion
    //Si existe la cookie hacemos que la sesion tome su valor
    //Si existe una session id hacemos que el usuario pueda cerar la sesion y volver al index
    //si no el usuario no tenia sesion con lo que ira a index
    if (array_key_exists('id',$_COOKIE))
    {
        $_SESSION['id'] = $_COOKIE['id'];
    }
    if (array_key_exists('id',$_SESSION))
    {
        echo "<p>Sesion iniciada.<a>href='../index.php?Logout=1'>Cerrar Sesión.</a></p>";
    }
    else
    {
        header("Location:../index.php");
    }
?>