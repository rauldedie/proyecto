
<?php   
    header("content-type:text/html;charset=utf-8");
    include (cabecera.php);
    if (isset($_POST["submit"]))
    {
        include(conectar.php);
    
        //HABRIA QUE CONTROLAR LA ENTRADA 
        $nuevousu = mysqli_real_escape_string($enlace,$_POST["usuario"]);
        $nuevopass = mysqli_real_escape_string($enlace,$_POST["passwd"]);
        $nombre =;
        $apellidos =;
        $mail =;
        
        $query = "insert into usuarios (idusuario,nombre,apellidos,mail,password,nomreusuario) values ('','".$nuevousu."','".$nuevopass."');";
        $resultado = mysqli_query($enlace,$query);
        if ($resultado)
        {
            echo "Te has dado de alta correcctamente.";
    
        }else
        {
            echo "Lo siento, ha ocurrido un error en el proceso de alta<br>" . mysqli_error($enlace);
        }    
        mysqli_close($enlace);     
    
    }
    ?>

    <?php include "pie.php" ?>