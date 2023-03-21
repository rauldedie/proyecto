<?php

    session_start();
    if (array_key_exists("id",$_COOKIE))
    {
        $_SESSION['id'] = $_COOKIE['id'];
    }
    if (array_key_exists("id",$_SESSION))
    {
        echo "<h1>Bienvenido!!!!</h1>";
        echo "<p>Sesion iniciada. <a href='index.php? Logout=1'>Cerrar sesion</a></p>";
    }
    else
    {
        header("location: index.php");
    }

?>