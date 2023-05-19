<?php include "header.php" ?>
<?php 
    if(isset($_GET['eliminar']))
    {
        $id= htmlspecialchars($_GET['eliminar']);
        $query = "DELETE FROM incidencias WHERE id = {$id}"; 
        $delete_query= mysqli_query($conn, $query);
        // header("Location: home.php");
        echo "<script>window.location='paneladmin.php';</script>";
    }
?>
<?php include "pie.php" ?>