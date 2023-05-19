<?php

    $error="";
    if (array_key_exists("login",$_POST))
    {
        include("include/conectar.php");

        if(!$_POST['nombre'])
        {
            $error.="<br>nombre requerido.";
        }

        if(!$_POST['apellidos'])
        {
            $error.="<br>apellidos requeridos.";
        }

        if(!$_POST['mail'])
        {
            $error.="<br>direccion mail requerida.";
        }

        if(!$_POST['pass1'])
        {
            $error.="<br>contraseña requerida.";
        }

        if(!$_POST['pass2'])
        {
            $error.="<br>repeticion contraseña requerida.";
        }

        if(!$_POST['usuario'])
        {
            $error.="<br>nombre de usuario requerido.";
        }    

        if(!$_POST['nombreusuario'])
        {
            $error.="<br>usuario requerido.";
        }

        if(!$_POST['rol'])
        {
            $error.="<br>rol requerido.";
        }

        if ($error!="")
        {
            $error="<p>El formulario contiene errores: ".$error."</p>";
        }

        else{

            $nombre = mysql_real_escape_string($enlace,$_POST['nombre']);
            $apellido = mysql_real_escape_string($enlace,$_POST['apellido']);
            $mail = mysql_real_escape_string($enlace,$_POST['mail']);
            $telefono = mysql_real_escape_string($enlace,$_POST['telefono']);
            $pass1 = mysql_real_escape_string($enlace,$_POST['pass']);
            $pass2 = mysql_real_escape_string($enlace,$_POST['pass']);
            $usuario = mysql_real_escape_string($enlace,$_POST['usuario']);
            $rol = mysql_real_escape_string($enlace,$_POST['rol']);

            $nombrecript = openssl_encrypt($nombre, $metodo,$key, $options, $vectorcript);
            $apellidocript = openssl_encrypt($apellido, $metodo,$key, $options, $vectorcript);
            $mailcript = openssl_encrypt($mail, $metodo,$key, $options, $vectorcript);
            $telefonocript = openssl_encrypt($telefono, $metodo,$key, $options, $vectorcript);
            $usuariocript = openssl_encrypt($usuario, $metodo,$key, $options, $vectorcript);
            $rolcript = openssl_encrypt($rol, $metodo,$key, $options, $vectorcript);

            //realizo la consulta para ver si el usuario existe en la BD
            $query = sprintf("SELECT * FROM usuarios WHERE nombreusuario='%s' LIMIT 1",$usuariocript);
            $resultado = mysqli_query($enlace,$query);

            if (mysqli_num_rows($resultado)>0)
            {
                $error = "Usuario ya registrado.";

            }else
            {
                $query = sprintf("INSERT INTO usuarios (nombre,apellidos,mail,telefono,pass,nombreusurio,rol,) 
                VALUES ('%s',%s','%s','%s','%s',%s','%s')",$nombrecript,$apellidocript,$mailcript,$telefonocript,$usuariocript,$rolcript);
                $resultado = mysqli_query($enlace,$query);
                
                if(!$resultado)
                {
                    $error = "No se hapodido completar el alta del nuevo usuario, por vafor, inténtelo más tarde.";
                } else
                {
                    $id = mysqli_insert_id($enlace);
                    $passh = md5(md5($id).$pass);
                    $query = sprintf("UPDATE usarios SET pass='%s' WHERE idusuario=$id",$passh);
                    mysqli_query($enlace,$query);
                    
                }
            }

            
        }
        
    }


?>
<div>
    <?php
        echo $error;
    ?>
</div>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <div>
        <label>Nombre (*): </label for="nombre"><input name="nombre" class="form" type="text" id="datoreg0" required placeholder="Nombre">
        <label class="error" id="errorReg0"></label><br><br>

        <label>Apellidos (*): </label for="apellido" ><input name="apellido" class="form" type="text" id="datoreg1" required placeholder="Apellidos">
        <label class="error" id="errorReg1"></label><br><br>

        <label>Correo electrónico (*): </label for="mail"><input name="mail" class="form" type="email" id="datoreg2" required placeholder="Correo electrónico">
        <label class="error" id="errorReg2"></label><br><br>
                   
        <label>Contraseña (*): </label for="pass1"><input  name="pass1" class="form" type="password" id="datoreg3" required placeholder="Mínimo 8 caracteres"">
        <label class="error" id="errorReg3"></label><br><br>
        
        <label>Repetir Contraseña (*): </label for="pass2"><input name="pass2" class="form" type="password" id="datoreg4" required placeholder="Mínimo 8 caracteres">
        <label class="error" id="errorReg4" ></label><br><br>

        <label>Nombre Usuario (*): </label for="nombreusuario"><input name="nombreusuario" class="form" type="text" id="datoreg5" required placeholder="Nombre de usuario">
        <label class="error" id="errorReg5" ></label><br><br>

        <label>Rol (*): </label for="rol" ><input name="rol" class="form" type="list" value="Profesorado" id="datoreg6">
        <label class="error" id="errorReg6"></label><br><br>
            
        <label for="">Los campos marcados con (*) son obligatorios</label><br><br>
    </div>
    <button type="submit" name="registro" onclick="ValidarRegistro()">Registrar</button><br><br>
    <div id=avisoreg></div>

</form>