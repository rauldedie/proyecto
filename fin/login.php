<?php 

if (isset($_POST["submit"]))
{

    $enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);

    if(!$enlace)
    {
        echo "Conexion fallida: ".mysqli_connect_error();

    }else
    {
        
        $usu = mysqli_real_escape_string($enlace,$_POST["usuario"]);
        $pass = mysqli_real_escape_string($enlace,$_POST["passwd"]);
        echo $pass."<br>";
        echo $usu."<br>";

        $query = sprintf("SELECT * FROM usuarios2 WHERE nombreusuario='%s'",$usu);
        $resultado = mysqli_query($enlace,$query);
        print_r($resultado);echo "<br>";
        $fila = mysqli_fetch_array ($resultado);
        print_r($fila);echo "<br>";
        echo $fila['pass']."<br>";
        echo $fila['rol']."<br>";
        echo $fila['nombreusuario']."<br>";

            if (mysqli_num_rows($resultado)>0)
            {
                $fila = mysqli_fetch_array ($resultado);

                if($fila['pass'] == $pass)
                {
                    //establecemos inicion de session
                    //necsitamos session_star(); ??????
                    $_SESSION["id"]=$fila['idusuario'];
                    //session_set_cookie_params("usuario",$usu,time()+60*10,true,true);
                    if ($_POST['sesioniniciada']==1)
                    {
                        //si esta marcada la casilla de mantener la sesion abierta le metemos cookie por 1 dia de tiempo.
                        //la cookie sera por sesion y rol.
                        setcookie("id",$fila['idusuario'],time()+60*60*24,true,true);
                        setcookie("rol",$fila['rol'],time()+60+60*24,true,true);
                        setcookie("usuario",$fila['nombreusuario'],time()+60+60*24,true,true);

                    }
                    echo $_COOKIE['id']."<br>";
                    echo $_COOKIE['rol']."<br>";
                    echo $_SESSION['id']."<br>";
                    echo $fila['rol'];
                    //redireccionamos a la pagina que le corresponde por rol
                    if ($fila['rol']=="administrador")
                    {
                        
                        include('paneladmin.php');
                        exit();
                    }
                    if ($_fila['rol']=="direccion")
                    {
                        //header("Location:paneldirec.php");
                    }
                    if ($_fila['rol']=="profesorado")
                    {
                        //header("Location:panelprofe.php");
                    }

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