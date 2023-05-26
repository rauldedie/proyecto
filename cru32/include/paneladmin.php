<?php //include "./acciones/header.php";
//SEGUN EL ROL QUE ME ENVIA EN EL LOCATION CARGAMOS UNA U OTRO PANEL
//SE QUE SERIA MEJOR HABILITAR O DESHABILITAR ELTOS PERO TENDRIA QUE BUSCAR Y TARDO MAS

if (isset($_GET['rol']))
{
    if(isset($_SESSION["timeout"]))
    {
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad)
        {
            session_destroy();
            header("Location: /include/logout.php");
        }
    }else
    {
        if(isset($_SESSION['idusuario']))
        {
            //segun el id busco el rol que le corresponde
            $idusuario=$_SESSION['idusuario'];
            include "conexion.php";
            $query = "SELECT rol from usuarios2 WHERE idusuario = {$idusuario}";
            $resultado = mysqli_query($enlace,$query);
            if($resultado)
            {
                include "administrador.php";
            }else
            {
                session_destroy();
                header("Location: /include/logout.php");
            }

        }
    }

    
    /*$rol = htmlspecialchars($_GET['rol']);

    switch ($rol)
    {
        case 'administrador' :
        {
            include "administrador.php";
            break;
        }
        case "direccion"://NO ESTAN HECHOS SIN SESIONS NI COOKIES TENDRIA QUE REPTIR MUCHO CODIGO
        {
            include "direccion.php";
            break;
        }
        case "profesorado":
        {
            include "profesorado.php";
            break;
        }
    }*/ 
}//NO LAS IMPRIME
//echo $_SESSION['rol']."<br>";
//echo $_SESSION['usuario_id']."<br>";
//echo $_SESSION['usuario_nombre']."<br>";
//echo $_COOKIE['rol']."<br>";
//echo $_COOKIE['usuario_id']."<br>";
//echo $_COOKIE['usuario_nombre']."<br>";      


//include "./acciones/footer.php"; ?>



   