<?php
include "conexion.php";
//echo $error="";
echo $enlace."<br>";
if(isset($_POST['registro']))
{
    $error="";
    echo "Se ha realizado submit <br>";

    //USAR FILTER_SANITIZE_FULL_SPECIAL_CHARS????
    //$nombre = filter_var(mysqli_real_escape_string($enlace, $_POST['nombre']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $nombre = mysqli_real_escape_string($enlace, $_POST['nombre']);
    $apellidos= mysqli_real_escape_string($enlace, $_POST['apellidos']);
    $usuario = mysqli_real_escape_string($enlace, $_POST['usuario']);
    $pass = mysqli_real_escape_string($enlace, $_POST['password']);
    $pass2 = mysqli_real_escape_string($enlace, $_POST['password2']);
    $email = filter_var(mysqli_real_escape_string($enlace, $_POST['email']), FILTER_SANITIZE_EMAIL);
    $telefono = mysqli_real_escape_string($enlace, $_POST['telefono']);
    $rol = mysqli_real_escape_string($enlace, $_POST['rol']);
    
    echo "He reogido datos formulario<br>";

    if (empty($nombre))
    {
        $error.="El campo nombre es obligatorio. <br>";

    }else if (empty($apellidos))
    {
        $error.="El campo apellidos es obligatorio. <br>";

    }else if (empty($pass) OR empty($pass1))
    {
        $error.="El campo password(contraseña) es obligatorio. <br>";
    }else if ($pass!=$pass2)
    {
        $error.="Las contraseñas no coinciden.";

    }else if (strln($pass)<8 OR strln($pass1)<8)
    {
        $error.="Las contraseñas ha de se minimo de 8 caracteres";

    }else if (empty($email))
    {
        $error.="Dirección inválida de correo. Introduzca una válida.";

    }
    echo $error."Escribo en registro <br>";

    if($error="") //no funcionan los insert ???????
    {
        //PRIMERO VEMOS QUE EL USUARIO NO ESTA YA REGISTRADO.
        $query = "SELECT * FROM usuarios2 WHERE nombreusuario='{$usuario}'";
        $resultado = mysqli_query($enlace,$query);
        
        if(mysqli_num_rows($resultado)>0)
        {
            echo "Lo siento este usuario ya está dado de alta";

        }else
        {
            //SI TODO CORRECTO PREPARO EL INSERT INTO
            $query = "INSERT INTO usuarios2 (nombre,apellidos,mail,telefono,nombreusuario,pass,rol) VALUES ('{$nombre}','{$apellidos}','{$email}','{$telefono}','{$usuario}','{$pass}','{$rol}')";
            $resultado = mysqli_query($enlace,$query);
            if(!$resultado)
            {
                echo "Se ha generado un error al insertar el usuario. Proceso abortado";

            }else{
                //encriptar contraseña usando el id introducido
                $ultimo_id = mysql_insert_id($enlace);
                $passh = md5(md5($ultimoid).$pass);
                $query = "UPDATE usuarios2 SET pass={$passh} WHERE idusuario = {$ultimo_id}";
                $reultado = mysqli_query($nelace,$query);
                if (!$resultado)
                {
                    echo "Se ha generado un error al insertar ell usuario. Revise integridad en BD";
                }else
                {
                    //enviar mail con los datos  de login del usuario a la cuenta de correo facilitada
                    echo "<script type='text/javascript'>alert('¡Usuario dado de alta con éxito!')</script>";
                }
            }
        }
    }
    mysqli_close($enlace);
}
?>