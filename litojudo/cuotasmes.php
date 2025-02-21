<?php
session_start();
$tiempo_inactivo = 10 * 60;
if (!array_key_exists("usuario_id",$_SESSION)){
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA
if (isset($_SESSION['inactivo']) && (time() - $_SESSION['inactivo']) > $tiempo_inactivo) {
    session_unset();
    session_destroy();

    //Redireccionamos el usuario a logout
    header("Location: logout.php");
    exit();
  }else{
    // Regenera nueva sesion y fija de nuevo el tiempo
    session_regenerate_id(true);

    // Update the last timestamp
    $_SESSION['inactivo'] = time();
  }

$nombreusuario = $_SESSION['usuario_nombre'];
$idenuso = $_SESSION['usuario_id'];
$rolenuso = $_SESSION['usuario_rol'];
$rol=$rolenuso;
$error = "";

include "conexion.php";

if (isset($_GET['usuario']))
{
    
    $idusuario = htmlspecialchars(stripslashes($_GET['usuario']));
    
    if($idusuario == $idenuso && $rolenuso==1)
    {
      $query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idenuso} and u.tipousuario=t.idtipo and u.estado='alta'";
      $fila = mysqli_fetch_array(mysqli_query($enlace,$query));
      if (strcmp($fila['tipo'],"administrador")!=0)
      {
        echo "<script>window.location='logout.php;</script>";
      }
    }else
    {
      echo "<script>window.location='logout.php;</script>";
    }

    $mesactual = date('m');
    $anioactual = date(('Y'));

    //VEMOS SI YA HEMOS AÑADIDO LA MENSUALIDAD

    $query = "SELECT idalumno, estado FROM cuotas WHERE mes='{$mesactual}' and anio='{$anioactual}'";
    $respuesta = mysqli_query($enlace,$query);
    //echo $query."<br>";

    if(mysqli_num_rows($respuesta)>0)
    {
        //YA SE HA AÑADIDO LA MENSUALIDAD AÑADIMOS SOLO LOS ALUMNOS NUEVOS QUE SE HAN APUNTADO DESDE LA ULTIMA ACTUALIZACION

        $query = "SELECT a.idalumno FROM alumnos a LEFT JOIN cuotas c  ON a.idalumno = c.idalumno WHERE c.idalumno is NULL";
        $respuesta2 = mysqli_query($enlace,$query);
        //echo $query."<br>";
        
        while($row = mysqli_fetch_assoc($respuesta2))
        {
            $idalumno = $row['idalumno'];
            $query = "INSERT INTO cuotas (idalumno, mes, anio, estado) VALUES ({$idalumno},'{$mesactual}','{$anioactual}',0 )";
            $resultado = mysqli_query($enlace,$query);
            //echo "ALUMNOS NUEVOS <br>";
            //echo $query."<br>";
        }
        $error = 1;

    }else
    {
        //AÑADIMOS LA MENSUALIDAD A TODOS LOS ALUMNOS.
        $query = "SELECT idalumno FROM alumnos";
        $respuesta = mysqli_query($enlace,$query);

        while($row = mysqli_fetch_assoc($respuesta))
        {
            $idalumno = $row['idalumno'];
            $query = "INSERT INTO cuotas (idalumno, mes, anio, estado) VALUES ({$idalumno},'{$mesactual}','{$anioactual}',0 )";
            $resultado = mysqli_query($enlace,$query);
            //echo $query."<br>";
        }
    }

    if($error == 1)
    {
        echo "<script type='text/javascript'>alert('¡Ya estaban añadidas las cuotas!')</script>";
        echo "<script>window.location='gestionarmensualidad.php?usuario={$idenuso}&&ord=asc&&mostrar=all';</script>";
    }

    if ($resultado && $error !=1)
    {
        
        $error = "";

    }else
    {
    
        $error.="Error al dar de alta las cuotas".mysqli_error($enlace)."<br>";
        

    }
    if($error == "")
    {
        echo "<script type='text/javascript'>alert('¡Cuotas añadidas!')</script>";
        echo "<script>window.location='gestionarmensualidad.php?usuario={$idenuso}&&ord=asc&&mostrar=all';</script>";
    }
       
}
mysqli_close($enlace);
?>