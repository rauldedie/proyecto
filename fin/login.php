<?php 

if (isset($_POST["submit"]))
{

    $enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);

    if(!$enlace)
    {
        echo "Conexion fallida: ".mysqli_connect_error();

    }else
    {
        //HABRIA QUE CONTROLAR LA ENTRADA
        
        $usu = mysqli_real_escape_string($enlace,$_POST["usuario"]);
        $pass = mysqli_real_escape_string($enlace,$_POST["passwd"]);

        $query = sprintf("SELECT * FROM usuarios2 WHERE nombreusuario='%s'",$usu);
        $resultado = mysqli_query($enlace,$query);

            if (mysqli_num_rows($resultado)>0)
            {
                $fila = mysqli_fetch_array ($resultado);

                if($fila['pass']==$pass)
                {
                    //establecemos inicion de session
                    //necsitamos session_star(); ??????
                    $_SESSION["id"]=$fila['idusuario'];
                    session_set_cookie_params("usuario",$usu,time()+60*10,true,true);
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
                    echo $_COOKIE['id']."<br>";
                    echo $_COOKIE['rol']."<br>";
                    echo $_SESSION['id']."<br>";
                    //redireccionamos a la pagina que le corresponde por rol
                    if ($fila['rol']=="administrador")
                    {
                        //header("Location:paneladmin.php");
                        include('paneladmin.php');exit();
                    }
                    if ($_fila['rol']=="direccion")
                    {
                        //header("Location:paneldirec.php");
                    }
                    if ($_fila['rol']=="profesorado")
                    {
                        //header("Location:panelprofe.php");
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