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

include "conexion.php";
$idusuarioenuso = $_SESSION['usuario_id'];
$nombreusuario = $_SESSION['usuario_nombre'];
$rolenuso = $_SESSION['usuario_rol']; 


include "cabecera.php" ?>
<?php //no funciona ???????
     if(isset($_GET['eliminar']))
     { 
        $id= htmlspecialchars($_GET['eliminar']);
        $query = "DELETE FROM incidencias2 WHERE idincidencia =". $id; 
        $delete_query= mysqli_query($enlace, $query);
        
        echo "<script>window.location='panelgestion.php?usuario={$idusuarioenuso}';</script>";
     }
?>
<?php include "pie.php" ?>