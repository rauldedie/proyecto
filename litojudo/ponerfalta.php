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
$fecha = date("D");

if (isset($_GET['falta']))
{
    $falta = htmlspecialchars(stripslashes($_GET['falta']));
    $idalumno = htmlspecialchars(stripslashes($_GET['alumno']));
    $iddia = htmlspecialchars(stripslashes($_GET['dia']));
    $idhora = htmlspecialchars(stripslashes($_GET['hora']));
    $iddojo = htmlspecialchars(stripslashes($_GET['dojo']));
    $idusu = htmlspecialchars(stripslashes($_GET['usu']));
    //$fecha = date("dmy");

    echo $falta."<br>";  
    echo $idalumno."<br>";
    echo $iddia."<br>";
    echo $idhora."<br>";
    echo $iddojo."<br>";
    echo $idusu."<br>";
    echo $fecha."<br>";

    //compruebo que se le pone la falta el dia que corresponde -- minimizo errores por darle un dia que no es la clase
    if ($iddia==1 && ($fecha=="Mon" || $fecha=="Wed" ))
    {
        echo "Falta dia lunes o miercoles";
        echo date("dmy");
    }else 
    {
        if ($iddia==2 && ($fecha=="Thu" || $fecha=="Tue" ))
        {
            echo "Falta dia martes o jueves";
            echo date("dmy");
        }else
        {
            echo "Este dia no puede ponerse falta";
        }
    }

}


    /*$query = "INSERT INTO faltas () VALUES ()";
    $respuesta = mysqli_query($enlace,$query);

    if ($respuesta)
    {
        echo "<script>window.location='gestionarclases.php?dojo={$iddojo}&&usuario=". $idenuso . "&ord=desc&campo=nombre';</script>";
    
    }else
    {
        echo "Se ha producido un error al poner la falta".mysqli_error($enlace);
    }*/


mysqli_close($enlace);
?>