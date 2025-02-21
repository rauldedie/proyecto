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

    if (isset($_GET['idelemento']))
    {
        $id = htmlspecialchars(stripslashes($_GET['idelemento']));
        $query = "UPDATE cuotas SET estado = 1 WHERE idcuota={$id}";
        //echo $query;
        $respuesta = mysqli_query($enlace,$query);

        if ($respuesta)
        {
            $error = "";

        }else
        {
            {
                $error.="Error al pagar la cuota".mysqli_error($enlace)."<br>";
            }
    
        }
        if($error=="")
        {
            echo "<script type='text/javascript'>alert('¡Cuota pagada correctamente!')</script>";
            echo "<script>window.location='gestionarmensualidad.php?usuario={$idenuso}&&ord=asc&&mostrar=all';</script>";
        }
    }

}
mysqli_close($enlace);
?>