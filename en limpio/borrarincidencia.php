<?php
session_start();
if (!array_key_exists("usuario_id",$_SESSION))
{
  // Si no tenia la sesion iniciada
  header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA

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