
<?php   
    header("content-type:text/html;charset=utf-8");
    include ("cabecera.php");
    if (isset($_POST["registro"]))
    {
        //¿PODRIA SACARLO DEL IF? EL INCLUDE Y LA TOMA DE DATOS
        include("conectar.php");
        
        $nombre =mysqli_real_escape_string($enlace,$_POST["nombre"]);
        $apellidos =mysqli_real_escape_string($enlace,$_POST["apellidos"]);
        $mail =mysqli_real_escape_string($enlace,$_POST["mail"]);

        $nuevousu = mysqli_real_escape_string($enlace,$_POST["nombreusuario"]);
        $nuevopass = mysqli_real_escape_string($enlace,$_POST["pass1"]);
        $nuevopass2 = mysqli_real_escape_string($enlace,$_POST["pass2"]);

        //VERIFICAR QUE NO EXISTE EL USUARIO
        $query = sprintf("SELECT * FROM usuarios2 WHERE nombreusuario='%s'",$nuevousu);
        $resultado = mysqli_query($enlace,$query);

        if (!$resultado)
        {
            $query = "SELECT last_insert_id();";
            $id = mysqli_query($enlace,$query);
            $id+=1;
            $passh= md5(md5($id).$nuevopass);

            $query = "insert into usuarios2 (idusuario,nombre,apellidos,mail,password,nombreusuario) values ('','".$nuevousu."','".$passh."');";
            $resultado = mysqli_query($enlace,$query);

            if ($resultado)
            {
                echo "Te has dado de alta correcctamente.";
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

        if (isset($_POST["login"]))
        {
            //¿PODRIA SACARLO DEL IF? EL INCLUDE Y LA TOMA DE DATOS
            include("conectar.php");
    
            $nombre =mysqli_real_escape_string($enlace,$_POST["nombre"]);
            $apellidos =mysqli_real_escape_string($enlace,$_POST["apellidos"]);
            $mail =mysqli_real_escape_string($enlace,$_POST["mail"]);

            $usu = mysqli_real_escape_string($enlace,$_POST["nombreusuario"]);
            $pass = mysqli_real_escape_string($enlace,$_POST["pass1"]);
            

            //VER SI EXISTE EL USUARIO
            $query = sprintf("SELECT * FROM usuarios2 WHERE nombreusuario='%s'",$usu);
            $resultado = mysqli_query($enlace,$query);

            if (!$resultado)
            {
                
                echo "Lo siento el usuario y/o la contraseña son incorrectos.";
                //echo "<script> document.getElementById("aviso").innerHTML="Lo siento el usuario y/o la contraseña son incorrectos."; </script>";
                

            }else
            {
                $fila = mysqli_fetch_array ($resultado);
                $passh= md5(md5($fila["id"]).$pass);
                if ($passh==$fila["password"])
                {
                    echo "Bienvenido ". $fila["nombreusuario"];
                    echo "El usuario se ha logado correctamente";
                    //echo "<script> document.getElementById("aviso").innerHTML="Login correcto"; </script>";
                }else
                {
                    echo "Lo siento, error al logarse usuario y/o contraseñas incorrecto.";
                    //echo "<script> document.getElementById("aviso").innerHTML="Lo siento, error al logarse usuario y/o contraseñas incorrecto."; </script>";
                    
                }
                
                
            }
        }

        mysqli_close($enlace);     
    
    }
    ?>

    <?php include "pie.php" ?>