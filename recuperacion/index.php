
<?php   

    header("content-type:text/html;charset=utf-8");

    include ("cabecera.php");
    include("conectar.php");
    
    ob_end_clean();

    $nombre =mysqli_real_escape_string($enlace,$_POST["nombre"]);
    $apellidos =mysqli_real_escape_string($enlace,$_POST["apellidos"]);
    $mail =mysqli_real_escape_string($enlace,$_POST["mail"]);

    $usuario = mysqli_real_escape_string($enlace,$_POST["nombreusuario"]);
    $pass = mysqli_real_escape_string($enlace,$_POST["pass1"]);

    if (isset($_POST["registro"]))
    {  
        //VERIFICAR QUE NO EXISTE EL USUARIO
        $query = sprintf("SELECT nombreusuario FROM usuarios2 WHERE nombreusuario='%s'",$usuario);
        $resultado = mysqli_query($enlace,$query);

        if ($resultado!=$usuario)
        {
            $query = "SELECT last_insert_id();";
            $id = mysqli_query($enlace,$query);
            $id+=1;
            $passh= md5(md5($id).$nuevopass);
            $query = "insert into usuarios2 (idusuario,nombre,apellidos,mail,password,nombreusuario) values ('','".$nombre."','".$apellidos."','".$mail."','".$passh."','".$usuario."');";
            $resultado = mysqli_query($enlace,$query);

            if ($resultado)
            {
                echo "Te has dado de alta correcctamente. Se te ha enviado un correo con los datos de conexión.";
                include("enviarmail.php");
                //echo "<script> document.getElementById("aviso").innerHTML="Mail registro enviado"; </script>";
    
            }else
            {
                echo "Lo siento, ha ocurrido un error en el proceso de alta<br>" . mysqli_error($enlace);
                //echo "<script> document.getElementById("aviso").innerHTML="Lo siento, ha ocurrido un error en el proceso de alta"; </script>";
            } 
            
        }else
        {        
            echo "El usuario ya existe";
            //echo "<script> document.getElementById("aviso").innerHTML="El usuario ya existe"; </script>";
               
        }
        

        mysqli_close($enlace);     
    
    }
    ?>

<?php include "pie.php" ?>