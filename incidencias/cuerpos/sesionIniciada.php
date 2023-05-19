<?php
echo $_COOKIE['id'];
echo $_COOKIE['rol'];
echo $_COOKIE['usuario'];

session_start();
if (array_key_exists("id",$_COOKIE) && $_COOKIE['id'])
{
    $_SESSION["id"] = $_COOKIE['id'];
    echo "Sesion no iniciada";

}
if (array_key_exists("id",$_SESSION) && $_SESSION['id'])
{
    
    if(isset($_COOKIE["rol"]) && $_COOKIE["rol"]=="administrador")
    {
        include ("gestionadmin.php");
    }

    if(isset($_COOKIE["rol"]) && $_COOKIE["rol"]=="direccion")
    {
        include ("gestiondireccion.php");

    }

    if(isset($_COOKIE["rol"]) && $_COOKIE["rol"]=="profesorado")
    {
        include ("gestioprofesorado.php");
    }
    exit();
}

?>
