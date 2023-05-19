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

    if (array_key_exists("login",$_POST))
    {
        //include("include/conectar.php");

        $servidor="217.76.150.73";
        $usuario="qahx080";
        $passwd="1smer1l10N";
        $bd="qahx080";
    
        $enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);

        if (!$enlace)
        {

            die("Conexion fallida: ".mysqli_connect_error());

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
        else{

            //Capturo los datos del formulario
            $usuario = mysql_real_escape_string($enlace,$_POST['usuario']);
            $pass = mysql_real_escape_string($enlace,$_POST['password']);
            //encripto usuario para la consulta
            //include("include/encriptar.php");
            $metodo = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($metodo);
            $options = 0;
            $vectorcript = '102938475601928374651234567890';
            $key = "K1s10p2A";
            $usuariocript= openssl_encrypt($usuario, $metodo,$key, $options, $vectorcript);
            //realizo la consulta para ver si el usuario existe en la BD
            $query = sprintf("SELECT * FROM usuarios WHERE nombreusuario='%s' LIMIT 1",$usuariocript);
            $resultado = mysqli_query($enlace,$query);

            if (!$resultado)
            {
                $error = "No se ha podido completar el login, por favor, inténtelo más tarde.";

            }else if (mysqli_num_rows($resultado)>0)
            {
                //convierto en array el resultado de la consulta (idusuario,nombre,...)
                $fila = mysqli_fetch_array ($resultado);
                //verifico contraseña
                $passh = md5(md5($fila["idusuario"]).$pass);
            
                if ($passh==$fila['pass'])
                {
                    //El usuario se loguea correctamente
                    $error="Bienvenido".$usuario;
                    //establecemos inicion de session
                    $_SESSION["id"]=$passh;
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

        close($enlace);
        
    }


?>

<div>
    <?php
        echo $error;
    ?>
</div>

<form method="POST">
    <div class="form-group">
        <div><img class="iconoayuda" id="ayuda"  src="recursos/ayuda.png" alt="ayuda"></div>
        <label for="usuario">Nombre de Usuario                        
            <input type="text" name="usuario" class="form-control" id="usuario" aria-describedby="AyudaUsuario" placeholder="Escribe tu usuario">
            <label class="error" id="errorusuario" ></label>
            <small id="AyudaUsuario">Este campo es obligatorio.</small>
        </label>
    </div>
    <div class="form-group">
        <label for="Password">Password
            <input type="password" name="password" aria-describedby="AyudaPasswd" class="form-control" id="password" placeholder="Escribe tu Password">
            <label class="error" id="errorpasswd" ></label>
            <small id="AyudaPasswd" >Este campo es obligatorio.</small>
        </label><br>
        <small id="AyudaPasswd2" >Longitud mínima 8 caracteres, ha de contener al menos un numero y una mayúscula.</small>
    </div>
    <div class="form-check">
        <input type="checkbox" name="sesioniniciada" value=1 class="form-check-input" id="AyudaCheck">
        <label class="form-check-label" for="AyudaCheck">Mantener Sesión (la sesion durará 24 horas)</label>
    </div>
   
    <br><button type="submit" name="login" class="btn btn-primary">Login</button>
                    
</form>

