<?php include "header.php" ?>
<?php 
     if(isset($_GET['eliminar']))
     { 
        $id= htmlspecialchars($_GET['eliminar']);
        $query = "DELETE FROM incidencias2 WHERE idincidencias =". $id; 
        $delete_query= mysqli_query($enlace, $query);
        
        echo "<script>window.location='../administrador.php';</script>";
     }
?>
<?php include "footer.php" ?>