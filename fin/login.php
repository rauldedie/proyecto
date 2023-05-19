<?php include('versesion.php');

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
        echo $pass;
        $query = sprintf("SELECT nombreusuario,pass,idusuario FROM usuarios2 WHERE nombreusuario='%s'",$usu);
        $resultado = mysqli_query($enlace,$query);

            if (mysqli_num_rows($resultado)>0)
            {
                $fila = mysqli_fetch_array ($resultado);
                if($fila['pass']==$pass)
                {
                    echo "Bienvenido ". $fila["nombreusuario"];
                    //establecemos inicion de session
                    $_SESSION["id"]=$fila['idusuario'];
                    if ($_POST['sesioniniciada']==1)
                    {
                        //si esta marcada la casilla de mantener la sesion abierta le metemos cookie por 1 dia de tiempo.
                        //la cookie sera posr sesion y rol.
                        setcookie("id",$id,time()+60*60*24,true,true);
                        setcookie("rol",$fila['rol'],time()+60+60*24,true,true);

                    }else
                    {   //tiene 10 minutos de sesion
                        setcookie("id",$id,time()+60*10,true,true);
                        setcookie("rol",$fila['rol'],time()+60*10,true,true);
                    }
                    //redireccionamos a la pagina que le corresponde por rol
                    if ($_COOKIE['rol']=="administrador")
                    {
                        header("Location:paneladmin.php");
                    }
                    if ($_COOKIE['rol']=="direccion")
                    {
                        header("Location:paneldirec.php");
                    }
                    if ($_COOKIE['rol']=="profesorado")
                    {
                        header("Location:panelprofe.php");
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