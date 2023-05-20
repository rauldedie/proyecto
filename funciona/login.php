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
        echo $usu."<br>";
        echo $pass."<br>";
        $query = sprintf("SELECT * FROM usuarios2 WHERE nombreusuario='%s'",$usu);
        $resultado = mysqli_query($enlace,$query);
        print_r($resultado);

            if (mysqli_num_rows($resultado)>0)
            {
                $fila = mysqli_fetch_array ($resultado);
                print_r($fila);
                echo "<br>";
                echo $fila['rol']."<br>";
                echo $fila['pass']."<br>";
                echo $fila[7];
                if($fila['pass']==$pass)
                {
                    //establecemos inicion de session
                    //necesitamos session_star(); ??????
                    $_SESSION["id"]=$fila['idusuario'];
                    if ($_POST['sesioniniciada']==1)
                    {
                        //si esta marcada la casilla de mantener la sesion abierta le metemos cookie por 1 dia de tiempo.
                        //la cookie sera por sesion y rol.
                        setcookie("id",$fila['idusuario'],time()+60*60*24,true,true);
                        setcookie("rol",$fila['rol'],time()+60+60*24,true,true);

                    }else
                    {   //si no está marcada la casilla manetener sesion
                        //tiene 10 minutos de sesion
                        setcookie("id",$fila['idusuario'],time()+60*10,true,true);
                        setcookie("rol",$fila['rol'],time()+60*10,true,true);
                    }
                    //redireccionamos a la pagina que le corresponde por rol
                    if ($_COOKIE['rol']=="administrador" OR $fila['rol']=="administrador")
                    {
                        include("paneladmin.php");exit();
                    }
                    if ($_COOKIE['rol']=="direccion")
                    {
                        include("Location:paneldirec.php");exit();
                    }
                    if ($_COOKIE['rol']=="profesorado")
                    {
                        include("Location:panelprofe.php");exit();
                    }
                    //seria posible include(panelprofe.php);exit(); ??????
                    //si es posible podria solucionar el orden
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