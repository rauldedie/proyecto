<?php
session_start();
if (!array_key_exists("usuario_id",$_SESSION)){
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA



if(isset($_POST['registro'])) 
{
    include "conexion.php";
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $email = htmlspecialchars($_POST['email']);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $pass1 = htmlspecialchars($_POST['password']);
    $nombreusuario =  strtolower(htmlspecialchars($_POST['usuario']));
    //$pass2 = htmlspecialchars($_POST['password2']);
    $rol = htmlspecialchars($_POST['rol']);

    echo $nombre."<br>";
    echo $apellidos."<br>";
    echo $email."<br>";
    echo $telefono."<br>";
    echo $pass1."<br>";
    echo $nombreusuario."<br>";
    echo $rol."<br>";
    //busco que no exista

    $query = "SELECT * FROM usuarios2 WHERE nombreusuario = '{$nombreusuario}'";
    echo $query."<br>";
    $resultado = mysqli_query($enlace,$query);
    $fila = mysqli_fetch_array($resultado);
    echo count($fila)."<br>";

    //if(count($fila)>0)
    //{
      //  echo "Lo siento ese nombre de usuario ya existe";
    //}else
    //{
        $query = "INSERT INTO usuarios2 (nombre,apellidos,mail,telefono,nombreusuario,pass,rol) VALUES ('{$nombre}','{$apellidos}','{$email}','{$telefono}','{$nombreusuario}','{$pass1}','{$rol}')";
        //$resultado2 = mysqli_query($enlace,$query);
        echo $query."<br>";
        //if($resultado2)
          //  echo "<script type='text/javascript'>alert('¡Usuario Añadido!')</script>";
        //else
          //  echo "Se ha producido un error al actualizar la incidencia.".mysqli_error($enlace);
    
        //HECHO ESTO HE DE ENCRIPTAR LA CONTRASEÑA Y HACER UN UPDATE USANDO EL ID COMO HASS
    //}
        mysqli_close($enlace);
}

include "cabecera.php";
?>
<div class=container2>
    <div class="nuevo">
        <p><h1 class="text-center" >Gestión de incidencias (CRUD) - Alta nuevo usuario.</h1></p>
    </div>
    <div class="nuevo">
        <p><h4 class="text-center">Facilita los datos del nuevo usuario.</h4></p>
    </div>
</div>
<div class="container2">  
    <form action="" method="POST">
        <div class="nuevo">
            <label for="usuario">Nombre de Usuario                        
                <input type="text" name="usuario" class="form-control" id="usuario" aria-describedby="AyudaUsuario" placeholder="Escribe tu usuario">
                <label class="error" id="errorusuario" > </label>
                <small id="AyudaUsuario">Este campo es obligatorio.</small>
            </label>
            <label for="email">Correo electrónico
                <input type="email" name="email" aria-describedby="AyudaEmail" class="form-control" id="email" placeholder="Escribe tu correo electrónico">
                <small id="AyudaEmail" >Este campo es obligatorio.</small>
                <label class="error" id="errormail" ></label>
            </label>
        </div>
        <div class="nuevo">
            <label for="nombre">Nombre
                <input type="text" name="nombre" aria-describedby="Ayudanombre" class="form-control" id="nombre" placeholder="Escribe tu nombre">
                <small id="Ayudanombre" >Este campo es obligatorio.</small>
                <label class="error" id="errornombre" ></label>
            </label>
            <label for="apellidos">Apellidos
                <input type="text" name="apellidos" aria-describedby="AyudaApellidos" class="form-control" id="apellidos" placeholder="Escribe tus apellidos">
                <small id="AyudaApellidos" >Este campo es obligatorio.</small>
                <label class="error" id="errorapellidos" ></label>
            </label>
            <label for="telefono">Telefono
                <input type="text" name="telefono" aria-describedby="Ayudatelefono" class="form-control" id="telefono" placeholder="Escribe tu telefono">
                <label class="error" id="errortelefono" ></label>
            </label>            
        </div>

        <div class="nuevo">
            <label for="Password">Password
                <input type="password" name="password" aria-describedby="AyudaPasswd" class="form-control" id="password" placeholder="Escribe tu Password">
                <label class="error" id="errorpasswd" ></label>
                <small id="AyudaPasswd" >Este campo es obligatorio.</small>
                <small id="Ayuda2Passwd" >Longitud mínima 8 caracteres.</small>
            </label>
            <label for="Password">Repite Password
                <input type="password" name="password2" aria-describedby="AyudaPasswd" class="form-control" id="password2" placeholder="Repite tu Password">
                <label class="error" id="errorpasswd2" ></label>
                <small id="AyudaPasswd" >Este campo es obligatorio.</small>
                <small id="Ayuda2Passwd2" >Longitud mínima 8 caracteres.</small>
            </label>
            </div>

            <div class="nuevo">
            <label>Rol del usuario.</label>
            <select name="rol" id="rol">
                <option value="administrador">administrador</option>
                <option value="direccion">direccion</option>
                <option value="profesorado" selected>profesorado</option>
            </select>
        </div>
        <div class="nuevo">
            <br><button type="submit" name="registro" class="btn btn-primary">Alta usuario</button>
            <a href="gestionarusuario.php" class="btn btn-primary"> Volver </a>
        </div>               
    </form>  
</div>
<?php include "pie.php"?>