<?php //include "./acciones/header.php";

if (isset($_GET['rol']))
{
    $rol = htmlspecialchars($_GET['rol']);

    switch ($rol)
    {
        case 'administrador' :
        {
            include "administrador.php";
            break;
        }
        case "administrador":
        {
            include "direccion.php";
            break;
        }
        case "administrador":
        {
            include "profesorado.php";
            break;
        }
    } 
}
echo $_SESSION['rol']."<br>";
echo $_SESSION['usuario_id']."<br>";
echo $_SESSION['usuario_nombre']."<br>";
echo $_COOKIE['rol']."<br>";
echo $_COOKIE['usuario_id']."<br>";
echo $_COOKIE['usuario_nombre']."<br>";      


//include "./acciones/footer.php"; ?>



   