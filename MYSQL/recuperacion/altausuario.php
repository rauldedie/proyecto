
<?php   
    header("content-type:text/html;charset=utf-8");
    include (cabecera.php);
    if (isset($_POST["registro"]))
    {
        include(conectar.php);
    
        $nombre =mysqli_real_escape_string($enlace,$_POST["nombre"]);
        $apellidos =mysqli_real_escape_string($enlace,$_POST["apellidos"]);
        $mail =mysqli_real_escape_string($enlace,$_POST["mail"]);

        $nuevousu = mysqli_real_escape_string($enlace,$_POST["nombreusuario"]);
        $nuevopass = mysqli_real_escape_string($enlace,$_POST["pass1"]);
        $nuevopass2 = mysqli_real_escape_string($enlace,$_POST["pass2"]);

        //VERIFICAR QUE NO EXISTE EL USUARIO
        $query = sprintf("SELECT nombreusuario FROM usuarios2 WHERE nombreusuario='%s' limit 1",$nuevousu);
        $resultado = mysqli_query($enlace,$query);

        if ($resultado)
        {
            echo "El usuario ya existe";

        }else
        {        
            $query = "insert into usuarios2 (idusuario,nombre,apellidos,mail,password,nombreusuario) values ('','".$nuevousu."','".$nuevopass."');";
            $resultado = mysqli_query($enlace,$query);

            if ($resultado)
            {
                echo "Te has dado de alta correcctamente.";
                include(enviarmail.php);
    
            }else
            {
                echo "Lo siento, ha ocurrido un error en el proceso de alta<br>" . mysqli_error($enlace);
            }    
        }

        if (isset($_POST["login"]))
        {
            include(conectar.php);
    
            $nombre =mysqli_real_escape_string($enlace,$_POST["nombre"]);
            $apellidos =mysqli_real_escape_string($enlace,$_POST["apellidos"]);
            $mail =mysqli_real_escape_string($enlace,$_POST["mail"]);

            $usu = mysqli_real_escape_string($enlace,$_POST["nombreusuario"]);
            $pass = mysqli_real_escape_string($enlace,$_POST["pass1"]);
            

            //VER SI EXISTE EL USUARIO
            $query = sprintf("SELECT nombreusuario FROM usuarios2 WHERE nombreusuario='%s' AND passwword='%s' limit 1",$usu,$pass);
            $resultado = mysqli_query($enlace,$query);

            if ($resultado)
            {
                echo "El usuario se ha logado correctamente";

            }else
            {
                echo "Lo siento el usuario no existe";
            }
        }


        mysqli_close($enlace);     
    
    }
    ?>

    <?php include "pie.php" ?>