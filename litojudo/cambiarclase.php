<?php
include "conexion.php";

if (isset($_POST['cambioclase']))
{
    $total =  htmlspecialchars(mysqli_real_escape_string($enlace, stripslashes($_POST['filatotal'])));
    
    for($j=0;j<$total;$j++)
    {

        $diaclase = htmlspecialchars(mysqli_real_escape_string($enlace, stripslashes($_POST['diaclase'.$j])));
        $horaclase = htmlspecialchars(mysqli_real_escape_string($enlace, stripslashes($_POST['horaclase'.$j])));
        $idalumno =  htmlspecialchars(mysqli_real_escape_string($enlace, stripslashes($_POST['idalumno'.$j])));
        $iddojo = htmlspecialchars(mysqli_real_escape_string($enlace, stripslashes($_POST['dojo'.$j])));
        $idclase = htmlspecialchars(mysqli_real_escape_string($enlace, stripslashes($_POST['idclase'.$j])));
    
    }

    //averiguo dia y hora de clase actual
    $query = "SELECT * from clases where idclase={$idclase}";
    $claseactual = mysqli_fetch_array(mysqli_query($enlace,$query));

    //clase correspondiente al dia y hora nuevos
    $query = "SELECT * from clases where iddia={$diaclase} and idhora={$horaclase} and iddojo={$iddojo}";
    $clasemod = mysqli_fetch_array(mysqli_query($enlace,$query));

    //actualizo la clase del alumno
    $query = "UPDATE alumnos set idclase={$clasemod['idclase']} where idalumno={$idalumno}";
    $resp = mysqli_fetch_array(mysqli_query($enlace,$query));
    if ($resp)
    {
        //header("Location:gestionar.clases.php?dojo={$iddojo}&&dia={$claseactual['iddiaclase']}&hora{$claseactual['idhoraclase']}");
    }else
    {
        echo "<script type='text/javascript'>alert('¡Error al cambiar de clase!')</script>";
    }
}

?>