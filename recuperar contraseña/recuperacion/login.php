<?php   

    header("content-type:text/html;charset=utf-8");

    include ("cabeceralogin.php");
    include("conectar.php");
    
    ob_end_clean();

    $mail =mysqli_real_escape_string($enlace,$_POST["mail"]);
    $intentos = 0;
    $usuario = mysqli_real_escape_string($enlace,$_POST["nombreusuario"]);
    $pass = mysqli_real_escape_string($enlace,$_POST["pass"]);

    while (intentos < 3)
    {
        if (isset($_POST["btn_login"]))
        {  
            //VERIFICAR EL USUARIO
            $query = sprintf("SELECT idusuario,nombreusuario,password FROM usuarios2 WHERE nombreusuario='%s'",$usuario);
            $resultado = mysqli_query($enlace,$query);
            $fila = mysqli_fetch_array ($resultado);

            if ($fila[nombreusuario]==$usuario)
            {
                $passh= md5(md5($fila[idusuario]).$pass);
            

                if ($fila[password]!= $passh)
                {
                    echo "contraseña incorrecta";
                    //include ("recuperarpass.php");
                    //include("enviarmail.php");
                    //echo "<script> document.getElementById("aviso").innerHTML="Mail registro enviado"; </script>";
                }else
                {   
                    echo "Login correcto";
                    //echo "<script> document.getElementById("aviso").innerHTML="Lo siento, ha ocurrido un error en el proceso de alta"; </script>";
                } 
            
            }else
            {        
                echo "El usuario no existe";
                //echo "<script> document.getElementById("aviso").innerHTML="El usuario ya existe"; </script>";
               
            }
        

            mysqli_close($enlace);     
    
        }
    }
    if(intentos == 3)
    {
        echo "Lo siento superaste el numero de intentos";
    }

    
    ?>

<?php include "pie.php" ?>