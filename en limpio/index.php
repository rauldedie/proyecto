<?php
session_start();

if ((array_key_exists("usuario_id",$_SESSION) AND $_SESSION['usuario_id']) OR (array_key_exists("usuario_id",$_COOKIE) AND $_COOKIE['usuario_id'])){
    // Si ya tenia la sesion iniciada
    header("Location:panelgestion.php?usuario=" . $_SESSION["usuario_id"]);
}



if (isset($_POST["login"]))
{
    include 'conexion.php';
    $error="";
    $usuario = stripslashes($_REQUEST['usuario']);
    $usuario = mysqli_real_escape_string($enlace, $usuario);
    $pass = stripslashes($_REQUEST['password']);
    $pass = mysqli_real_escape_string($enlace, $pass);
    $error="";
    if (empty($usuario))
    {
        $error .= "El campo usuario no es válido.";

    }else if (empty($pass))
    {
        $error .= "El campo contraseña no es válido.";
    }else
    {
        $hoy = date('Y-m-d H:i:s');
        date_default_timezone_set('Europe/Madrid');
        $query = "SELECT * FROM usuarios2 WHERE nombreusuario='{$usuario}' AND pass='{$pass}'";
        $resultado = mysqli_query($enlace, $query);

        if (mysqli_num_rows($resultado)>0)
        {
            $row = mysqli_fetch_array($resultado);
            $idusuario = $row['idusuario'];
            $_SESSION['usuario_id'] = $row['idusuario'];
            $_SESSION['usuario_nombre'] = $usuario;
            $_SESSION['usuario_rol'] = $row['rol'];
            $_SESSION['inactivo'] = time();

            //primero calculo tiempo ultima conexion
            $query = "SELECT fecha FROM accesos WHERE idusuario={$idusuario}";
            $respuesta = mysqli_query($enlace,$query);

            //si no hay registro es que es la primera vez si hay registros me quedo con max(fecha)
            //guardo en el array de sesiones el mensaje de bienvenida o el tiempo transcurrido.
            if (mysqli_num_rows($respuesta)>0)
            {
                $query = "SELECT max(fecha) fecha FROM accesos WHERE idusuario={$idusuario}";
                $fecha = mysqli_fetch_array (mysqli_query($enlace,$query));

                $fechaInicio = new Datetime ($hoy);
                $fechaFin = new Datetime($fecha['fecha']);
                $intervalo = $fechaInicio->diff($fechaFin);
                $_SESSION['tiempo_ultima_conexion'] = $intervalo->y . " años, " . $intervalo->m." meses, ".$intervalo->d." dias, " . $intervalo->h . " horas, " . $intervalo->i . " minutos y " . $intervalo->s . " segundos"."</p>";
                
            }else
            {
            
                $_SESSION['tiempo_ultima_conexion'] = "Bienvenido a tu primiera conexión";       
            }

            //si esta marcado recuerda sesiones añadimos la fecha de hoy ala tabla accesos para el usuario
            if ($_POST['recuerdame']=='1')
            {
                //actualizo con la última fecha de conexion";
                $fecha = date('Y-m-d H:i:s');
                $query = "INSERT INTO accesos (idusuario,fecha) VALUES ({$idusuario},'{$fecha}')"; // Historial de accesos
                $resultado = mysqli_query($enlace, $query);
            }
            echo "<script>window.location='panelgestion.php?usuario=". $row['idusuario'] . "';</script>";

        }else 
        {
            echo "<p class='usuario'>Usuario y/o password erróneo. " . mysqli_error($enlace)."</p>";
            mysqli_close($enlace);
            
        }
    }
    echo $error;
}

include "cabecera.php";
?>
<div class="container">
    <h1>GESTIÓN INCIDENCIAS TÉCNICAS IES A. MACHADO</h1> 
    <div>
        <p><h3>Introduce tu usuario y contraseña para entrar al sistema</h3></p>

        <form id="formulario" action="index.php" method="POST">
            <div class="form-group">
        
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
            </div>

            <div class="form-check">
                <input type="checkbox" name="recuerdame" value="1" class="form-check-input" id="AyudaCheck">
                <label class="form-check-label" for="AyudaCheck">Recordar Sesión</label>
            </div>

            <br><button type="submit" name="login" id="login" class="btn btn-primary">Login</button>
            <p><a href="recordar_pass.php" target="_blank">Recordar contraseña</a></p>               
        </form>
    </div>
    <div>
        <label class="error" id="aviso1" ></label>
        <?php if($error!="") echo $error; ?>
    </div> 
    <div>
        <label class="error" id="aviso2" ></label>
    </div>
</div>  
<?php include "pie.php"; ?>