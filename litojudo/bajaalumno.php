<?php
session_start();
$tiempo_inactivo = 10 * 60;
if (!array_key_exists("usuario_id",$_SESSION))
{
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA
if (isset($_SESSION['inactivo']) && (time() - $_SESSION['inactivo']) > $tiempo_inactivo) 
{
    session_unset();
    session_destroy();

    //Redireccionamos el usuario a logout
    header("Location: logout.php");
    exit();
}else
{
    // Regenera nueva sesion y fija de nuevo el tiempo
    session_regenerate_id(true);

    // Update the last timestamp
    $_SESSION['inactivo'] = time();
}

$idenuso = $_SESSION['usuario_id'];
include "conexion.php";

if (isset($_GET['dojo']))
{
    $iddojo = htmlspecialchars(stripslashes($_GET['dojo']));
    
}else $iddojo=1;

if (isset($_GET['eliminar']))
{
    $idbaja = htmlspecialchars(stripslashes($_GET['eliminar']));


    $query = "UPDATE alumnos set estado='baja' WHERE idalumno={$idbaja}";
    $respuesta = mysqli_query($enlace,$query);
    if ($respuesta)
    {
        echo "<script>window.location='gestionardojo.php?dojo={$iddojo}&&usuario=". $idenuso . "&ord=desc&campo=nombre';</script>";
        
    }else
    {
        echo "Se ha producido un error al dar la baja del usuario".mysqli_error($enlace);
    }

}else if (isset($_GET['alta']))
{
    $idalta = htmlspecialchars(stripslashes($_GET['alta']));
    $query = "UPDATE alumnos set estado='alta' WHERE idalumno={$idalta}";
    $respuesta = mysqli_query($enlace,$query);
    if ($respuesta)
    {
        echo "<script>window.location='gestionardojo.php?dojo={$iddojo}&&usuario={$idenuso}&&estado=baja';</script>";
    }else
    {
        echo "Se ha producido un error al dar el alta del usuario".mysqli_error($enlace);
    }
}
mysqli_close($enlace);
?>