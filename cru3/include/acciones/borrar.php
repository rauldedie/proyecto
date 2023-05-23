<?php include "header.php" ?>
<?php 
     if(isset($_GET['eliminar']))
     {
        echo "dentro del if"; 
        $id= htmlspecialchars($_GET['eliminar']);
        $query = "DELETE FROM incidencias2 WHERE idincidencias = $id"; 
        //$delete_query= mysqli_query($enlace, $query);
        // header("Location: home.php");
        echo "<script>window.location='../administrador.php';</script>";
     }
?>
<?php include "footer.php" ?>