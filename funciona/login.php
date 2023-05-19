<?php

if (isset($_POST["submit"]))
{
    $servidor = "217.76.150.73";
    $usuario = "qahx080"; 
    $passwd = "1smer1l10N"; 
    $bd = "qahx080"; 

    $enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);

    if(!$enlace)
    {
        echo "Conexion fallida: ".mysqli_connect_error();

    }else
    {
        //HABRIA QUE CONTROLAR LA ENTRADA
        
        $usu = mysqli_real_escape_string($enlace,$_POST["usuario"]);
        $pass = mysqli_real_escape_string($enlace,$_POST["passwd"]);
        echo $pass;
        $query = sprintf("SELECT nombreusuario,pass,idusuario FROM usuarios2 WHERE nombreusuario='%s'",$usu);
        $resultado = mysqli_query($enlace,$query);

            if (mysqli_num_rows($resultado)>0)
            {
                $fila = mysqli_fetch_array ($resultado);
                if($fila['pass']==$pass)
                {
                    echo "Bienvenido ". $fila["nombreusuario"];
                    //hariamos un header('Location:panel.php')
                }else
                {
                    echo "Lo siento, contraseña incorrecta<br>" . mysqli_error($enlace);
                }

            }else
            {
                echo "Los siento no eres usuario registrado.";
            }
  
        mysqli_close($enlace);     
    }
}


?> 