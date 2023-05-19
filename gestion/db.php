<?php
  session_start();
  $error="";
  if(array_key_exists('Logout',$_GET))
  {
    //viene de la pagina sesion iniciada. Limpiamos todas las sesiones
    session_unset();
    //evitar que me usen la cookie para recuperar la sesion que he limpiado
    setcookie('id',"",time()-60*60,true,true);
    $_COOKIE['id']="";
  }
  else if ((array_key_exists('id',$_SESSION) AND $_SESSION['id']) OR (array_key_exists('id',$_COOKIE) AND $_COOKIE['id']))
  {
    //ya tendría la sesion iniciada y no hacemos que se autentique de nuevo
    header("Location:include/sesioniniciada.php");
        
  }

  $host = "217.76.150.73";  
  $user = "qahx080"; 
  $pass = "1smer1l10N";  
  $database = "qahx080";    
  $conn = mysqli_connect($host,$user,$pass,$database);

  if (!$conn) 
  {                                             
    die("Conexión fallida con base de datos: " . mysqli_connect_error());     
  }

  if(!$_POST['usuario'])
  {
    $error.="<br>nombre de usuario requerido.";
  }

  if(!$_POST['password'])
  {
    $error.="<br>contraseña requerida.";
  }

  if ($error!="")
  {
    $error="<p>El formulario contiene errores: ".$error."</p>";
  }
  else
  {

  //Capturo los datos del formulario
  $usuario = mysql_real_escape_string($enlace,$_POST['usuario']);
  $pass = mysql_real_escape_string($enlace,$_POST['password']);
  //realizo la consulta para ver si el usuario existe en la BD
  $query = sprintf("SELECT * FROM usuarios2 WHERE nombreusuario='%s'",$usuario);
  $resultado = mysqli_query($enlace,$query);

  if (mysqli_num_rows($resultado)>0)
  {
    //convierto en array el resultado de la consulta (idusuario,nombre,...)
    $fila = mysqli_fetch_array ($resultado);
    //verifico contraseña
    //$passh = md5(md5($fila["idusuario"]).$pass);
    
        if ($pass==$fila['pass'])
        {
            //El usuario se loguea correctamente
            $error="Bienvenido".$usuario;
            //establecemos inicion de session
            $_SESSION["id"]=$fila['idusuario'];
            if ($_POST['sesioniniciada']==1)
            {
                //si esta marcada la casilla de mantener la sesion abierta le metemos cookie por 1 dia de tiempo.
                //la cookie sera posr sesion y rol.
                setcookie("id",$id,time()+60*60*24,true,true);
                setcookie("rol",$fila['rol'],time()+60+60*24,true,true);

            }
            header("Location:include/sesioniniciada.php");
        }

    }else
    {
        $error = "Lo siento el usuario y/o contraseña introducidos no son correctos.";
    }
}

?>


