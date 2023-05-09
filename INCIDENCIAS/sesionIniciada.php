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
    
    include ("gestion.php");
}

?>
