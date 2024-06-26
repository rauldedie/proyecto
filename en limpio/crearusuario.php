<?php
session_start();
$tiempo_inactivo = 10 * 60;
if (!array_key_exists("usuario_id",$_SESSION)){
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA
if (isset($_SESSION['inactivo']) && (time() - $_SESSION['inactivo']) > $tiempo_inactivo) {
    session_unset();
    session_destroy();

    //Redireccionamos el usuario a logout
    header("Location: logout.php");
    exit();
  }else{
    // Regenera nueva sesion y fija de nuevo el tiempo
    session_regenerate_id(true);

    // Update the last timestamp
    $_SESSION['inactivo'] = time();
  }

include "conexion.php";

if(isset($_POST['registro'])) 
{
    //include "conexion.php";
    $nombre = stripslashes($_POST['nombre']);
    $nombre = mysqli_real_escape_string($enlace,$nombre);
    $apellidos = stripslashes($_POST['apellidos']);
    $apellidos = mysqli_real_escape_string($enlace,$apellidos);
    $telefono = stripslashes($_POST['telefono']);
    $telefono = mysqli_real_escape_string($enlace,$telefono);
    $email = stripslashes($_POST['email']);
    $email = mysqli_real_escape_string($enlace,$email);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $pass1 = stripslashes($_POST['password1']);
    $pass1 = mysqli_real_escape_string($enlace,$pass1);
    $nombreusuario = stripslashes($_POST['usuario']);
    $nombreusuario = mysqli_real_escape_string($enlace,$nombreusuario);
    $pass2 = stripslashes($_POST['password2']);
    $pass2 = mysqli_real_escape_string($enlace,$pass2);
    $rol = stripslashes($_POST['rol']);
    $rol = mysqli_real_escape_string($enlace,$rol);
    $error = "";
    //para comprobar que los datos estan bien
    if(empty($nombre) OR empty($apellidos) OR empty($email) OR empty($nombreusuario) OR empty($pass1) OR empty($pass2))
    {
        $error.= "Ningún campo obligatorio puede quedar vacío.<br>";
    }
    if (strcmp($pass1,$pass2)!=0)
    {
        $error.="Las contraseñas han de ser iguales.<br>";
    }
    if (strlen($pass1)<6)
    {
        $error.="Longitud mínima de contraseña 6 caracteres.<br>";
    }
    else
    {
        //busco que no exista ya en la BD
        $query = "SELECT * FROM usuarios2 WHERE nombreusuario = '{$nombreusuario}'";
        $resultado = mysqli_query($enlace,$query);
       
        if(mysqli_num_rows($resultado)>0)
        {
            echo "Lo siento ese nombre de usuario existe";
            
        }else
        {
            //echo "Lo siento ese nombre de usuario no existe";
            $query = "INSERT INTO usuarios2 (nombre,apellidos,mail,telefono,nombreusuario,pass,rol) VALUES ('{$nombre}','{$apellidos}','{$email}','{$telefono}','{$nombreusuario}','{$pass1}','{$rol}')";
            $resultado2 = mysqli_query($enlace,$query);
            //HECHO ESTO HE DE ENCRIPTAR LA CONTRASEÑA Y HACER UN UPDATE USANDO EL ID COMO HASS

            if($resultado2)
            {
                echo "<script type='text/javascript'>alert('¡Usuario Añadido!')</script>";

                $output='<p>Estimado '.$nombre.' '.$apellidos.' no tiene que responder este mensaje.</p>';
                $output.='<p>Su usuario acaba de ser registrado en la app de incidencias del IES A. Machado.</p>';
                $output.='<p>Sus datos de conexion son:</p>'; 
                $output.='<p>Usuario: '.$nombreusuario.'</p>';
                $output.='<p>Contraseña: '.$pass1.'</p>';
                $output.='<p>No comparta estos datos con nadie. Puede ingresar a la aplicacion en www.practicasrdm.es</p>';
                $output.='<p>Gracias por su colaboración.</p>';   	
                $body = $output; 
                $subject = "Equipo técnico IES A. Machado.";
                $email_to = $email;
                $fromserver = "info@practicasrdm.es"; 
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <info@practicasrdm.es>' . "\r\n";
                if (mail($email_to,$subject,$body,$headers))
                {
                  echo "<script type='text/javascript'>alert('¡Se ha enviado un mail al usuario!')</script>";
                }
            }else
            {
                echo "Se ha producido un error al crear el usuario".mysqli_error($enlace);
            }           
        }
    }
    echo $error;
       
}
mysqli_close($enlace);
include "cabecera.php";
?>
<p class="encabezado"><h1 class="text-center" >Gestión de incidencias (CRUD). Panel Administrador - Alta nuevo usuario.</h1></p>
<p class="encabezado"><h4 class="text-center">Facilita los datos del nuevo usuario.</h4></p>
<div class="container">  
    
    <form action="" method="POST">
        <div>
            <label for="usuario" >Nombre de Usuario                        
                <input type="text" name="usuario" class="form-group" id="usuario" aria-describedby="AyudaUsuario" placeholder="Escribe tu usuario" required>
                <label class="error" id="errorusuario" > </label><br>
                <small id="AyudaUsuario">Este campo es obligatorio.</small>
            </label>
            <label for="Password">Password
                <input type="password" name="password1" class="form-group" aria-describedby="AyudaPasswd" id="password1" placeholder="Escribe tu Password" required>
                <label class="error" id="errorpasswd" ></label><br>
                <small id="AyudaPasswd" >Este campo es obligatorio.</small>
                <small id="Ayuda2Passwd" >Longitud mínima 8 caracteres.</small>
            </label><br>
            
            <label for="Password">Repite Password
                <input type="password" name="password2" class="form-group" aria-describedby="AyudaPasswd" id="password2" placeholder="Repite tu Password" required>
                <label class="error" id="errorpasswd2" ></label><br>
                <small id="AyudaPasswd" >Este campo es obligatorio.</small>
                <small id="Ayuda2Passwd2" >Longitud mínima 8 caracteres.</small>
            </label><br>    
        </div>

        <div class="form-group">
            <label for="nombre">Nombre
                <input type="text" name="nombre" aria-describedby="Ayudanombre" id="nombre" placeholder="Escribe tu nombre" required>
                <label class="error" id="errornombre" ></label><br>
                <small id="Ayudanombre" >Este campo es obligatorio.</small>
                
            </label>
            <label for="apellidos">Apellidos
                <input type="text" name="apellidos" aria-describedby="AyudaApellidos" id="apellidos" placeholder="Escribe tus apellidos" required>
                <label class="error" id="errorapellidos" ></label><br>
                <small id="AyudaApellidos" >Este campo es obligatorio.</small>
                
            </label>
            <label for="email">Correo electrónico
                <input type="email" name="email" aria-describedby="AyudaEmail" id="email" placeholder="Escribe tu correo electrónico" required>
                <label class="error" id="errormail" ></label><br>
                <small id="AyudaEmail" >Este campo es obligatorio.</small>
               
            </label>
            <label for="telefono">Telefono
                <input type="text" name="telefono" aria-describedby="Ayudatelefono" id="telefono" placeholder="Escribe tu telefono">
                <label class="error" id="errortelefono" ></label>
            </label>
        </div>

        <div class="form-group">
            <label>Rol del usuario.</label>
            <select name="rol" id="rol">
                <option value="administrador">administrador</option>
                <option value="direccion">direccion</option>
                <option value="profesorado" selected>profesorado</option>
            </select>
        </div>
        <div  class="container text-center mt-5">
            <button type="submit" name="registro" class="btn btn-primary">Alta usuario</button>
        </div>
        <a href="gestionarusuario.php" class='btn btn-warning mt-5'> Volver </a>
                          
    </form>  
</div>
<?php include "pie.php"?>