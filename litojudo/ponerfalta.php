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
    $idclase = htmlspecialchars(stripslashes($_GET['clase']));
    $fecha = date("dmy");

    /*echo $falta."<br>";  
    echo $idalumno."<br>";
    echo $iddia."<br>";
    echo $idhora."<br>";
    echo $iddojo."<br>";
    echo $idusu."<br>";
    echo $idclase."<br>";
    echo $fecha."<br>";*/


    //compruebo que esta falta no esta ya registrada
    $query = "SELECT idfalta,idalumno,idclase,fechafalta FROM faltas 
    WHERE fechafalta='{$fecha}' and idalumno={$idalumno}";
    //echo $query."<br>";
    $resultado = mysqli_query($enlace,$query);

    if(mysqli_num_rows($resultado)>0)
    {
        //si esto ocurre ya existe la falta del alumno.
        //echo "Ya se ha contabilizado la falta"."<br>";
        echo "<script>window.location='gestionarclases.php?dojo={$iddojo}&&dia={$iddia}&&hora={$idhora}';</script>";
    } else
    {
        //echo "El alumno no tiene faltas registradas"."<br>";
        //no tiene esa falta recogida el alumno asi que le asignamos la falta
        //para evitar poner una falta en un dia que el alumno no tiene clase por error controlamos que estemos en un dia con clase de ese alumno.
        //podriamos poner otros controles por ejemplo que estemos dentro de la hora de la clase pero me parece excesivo.
        $dia = date("D");

        if ($iddia==1 && ($dia=="Mon" || $dia=="Wed" ))
        {
            //hoy es lunes o miercoles y ha faltado ese dia
            //echo "Falta dia: ";
            //echo date("d/m/y")."<br>";
            $query = "INSERT INTO faltas (idalumno,idclase,fechafalta) VALUES ({$idalumno},{$idclase},'{$fecha}')";
            //echo $query."<br>";
            $resultado = mysqli_query($enlace,$query);

            if ($resultado)
            {
                echo "<script>window.location='gestionarclases.php?dojo={$iddojo}&&dia={$iddia}&&hora={$idhora}';</script>";
                //echo "Falta registrada"."<br>";
                
            }else
            {
                echo "Se ha producido un error al dar la baja del usuario".mysqli_error($enlace);
            }


        } else
        {
            if ($iddia==2 && ($dia=="Thu" || $dia=="Tue" ))
            {
                //hoy es martes o jueves y ha faltado a esa clase
                //echo "Falta dia: ";
                //echo date("d/m/y")."<br>";
                $query = "INSERT INTO faltas (idalumno,idclase,fechafalta) VALUES ({$idalumno},{$idclase},'{$fecha}')";
                //echo $query."<br>";
                $resultado = mysqli_query($enlace,$query);

                if ($resultado)
                {
                    echo "<script>window.location='gestionarclases.php?dojo={$iddojo}&&dia={$iddia}&&hora={$idhora}';</script>";
                    //echo "Falta registrada"."<br>";
                    
                }else
                {
                    echo "Se ha producido un error al dar la baja del usuario".mysqli_error($enlace);
                }

            }else
            {
                echo "Este dia no puede ponerse falta";
                echo "<script>window.location='gestionarclases.php?dojo={$iddojo}&&dia={$iddia}&&hora={$idhora}';</script>";
            }
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