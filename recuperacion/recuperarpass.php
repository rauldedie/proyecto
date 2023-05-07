<?php   

    header("content-type:text/html;charset=utf-8");

    include ("cabecerarecuperarpass.php");
    include("conectar.php");
    
    ob_end_clean();

    $mail =mysqli_real_escape_string($enlace,$_POST["mail"]);
    $usuario = mysqli_real_escape_string($enlace,$_POST["nombreusuario"]);

        if (isset($_POST["login"]))
        {  
            //VERIFICAR QUE NO EXISTE EL USUARIO
            $query = sprintf("SELECT * FROM usuarios2 WHERE nombreusuario='%s'",$usuario);
            $resultado = mysqli_query($enlace,$query);
            $fila = mysqli_fetch_array ($resultado);

            if ($fila[nombreusuario]==$usuario && $fila[mail]==$mail)
            {
                $passh= md5(md5($fila[idusuario]).$usuario);
                $query2 = "UPDATE usuarios2 SET password = '{$pass}' WHERE nombreusuario = {$usuario}";
                $incidencia_actualizada = mysqli_query($enlace, $query2);
                if (!$incidencia_actualizada)
                {
                    echo "Se ha producido un error al intentar cambiar de contraseña.";
                }
                  
                else
                {
                    echo "<Se ha enviado mail con instrucciones para cambio de contraseña. Gracias.";
                    include("mailrecuperacion.php");
                }
                  

            }else{
                echo "Lo siento no existe el usuario y/o el mail. Introduce los datos correctamente";
            }
            mysqli_close($enlace); 
        }
    
    ?>

<?php include "pie.php" ?>