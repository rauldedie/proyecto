<?php //include "./acciones/header.php";
//SEGUN EL ROL QUE ME ENVIA EN EL LOCATION CARGAMOS UNA U OTRO PANEL
//SE QUE SERIA MEJOR HABILITAR O DESHABILITAR ELTOS PERO TENDRIA QUE BUSCAR Y TARDO MAS
include "conexion.php";
if (isset($_GET['usuario']))
{
    $idusuario = htmlspecialchars($_GET['usuario']);
    //echo $_SESSION['usuario-id']."<br>";
    //echo $_SESSION['usuario_nombre']."<br>";
    $query="SELECT rol from usuarios2 WHERE idusuario={$idusuario}";
    $resultado=mysqli_query($enlace,$query);

    $fila = mysqli_fetch_array($resultado);

    switch ($fila['rol'])
    {
        case 'administrador' :
        {
            //include "administrador.php";
            
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
    } 
}
//include "./acciones/footer.php"; ?>



   