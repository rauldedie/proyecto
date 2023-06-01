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
    $usuario = mysqli_real_escape_string($enlace, $_POST['usuario']);
    $pass = mysqli_real_escape_string($enlace, $_POST['password']);
    $idusuario = $row['idusuario'];
    //echo "Usuario: " . $usuario . " y password: " . $pass;
    $error="";
    if (empty($usuario))
    {
        $error .= "El campo usuario no puede quedar vacío.";

    }else if (empty($pass))
    {
        $error .= "El campo contraseña no puede quedar vacío.";
    }else
    {

        $sql = "SELECT * FROM usuarios2 WHERE nombreusuario='" . $usuario . "' AND pass='" . $pass . "'";
        //echo $query."<br>";
        $result = mysqli_query($enlace, $sql);

        if ($result)
        {
            $row = mysqli_fetch_array($result);
           
            if (mysqli_num_rows($result)>0)
            {
                $_SESSION['usuario_id'] = $row['idusuario'];
                $_SESSION['usuario_nombre'] = $usuario;
                $_SESSION['usuario_rol'] = $row['rol'];
            
                if ($_POST['recuerdame']=='1')
                {
                    
                    //primero calculo tiempo ultima conexion
                    $consulta = "SELECT max(fecha) fecha FROM accesos WHERE idusuario={$idusuario}";
                    //echo $query."<br>";
                    $resultado = mysqli_query($enlace,$consulta);
                    $hoy = date('Y-m-d H:i:s');
                    date_default_timezone_set('Europe/Madrid');

                    if (!$resultado)
                    {
                        $_SESSION['tiempo_ultima conexion'] = "Bienvenido a tu primiera conexión";
                    }else
                    {
                        $fecha = mysqli_fetch_array ($resultado);
                        $fechaInicio = new Datetime ($hoy);
                        $fechaFin = new Datetime($fecha['fecha']);
                        $intervalo = $fechaInicio->diff($fechaFin);
                        $_SESSION['tiempo_ultima_conexion'] = $intervalo->y . " años, " . $intervalo->m." meses, ".$intervalo->d." dias, " . $intervalo->h . " horas, " . $intervalo->i . " minutos y " . $intervalo->s . " segundos"."</p>";
                        
                    }

                    //actualizo con la última conexion
                    $fecha = date('Y-m-d H:i:s');
                    $query = "INSERT INTO accesos (idusuario,fecha) VALUES ({$idusuario},'{$fecha}')"; // Historial de accesos
                    //echo $query."<br>";
                    mysqli_query($enlace, $query);
                    //echo $query;
                }
                
                echo "<script>window.location='panelgestion.php?usuario=". $row['idusuario'] . "';</script>";

            }
            else {
                echo "<p class='usuario'>Usuario y/o password erróneo.</p>";
            }
        }
        else
        {
            echo "<p class='usuario'>Usuario y/o password erróneo. " . mysqli_error($enlace)."</p>";
            mysqli_close($enlace);
        }  
    }
}
include "cabecera.php";
?>
<div class="container">
    <h1>GESTIÓN INCIDENCIAS TÉCNICAS IES A. MACHADO</h1> 
    <div>
        <p><h3>Introduce tu usuario y contraseña para entrar al sistema</h3></p>

        <form id="formulario" action="index.php" autocomplete="off" onsubmit="ValidarLogin()" method="POST">
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
                <small id="AyudaPasswd2" >Longitud mínima 6 caracteres.</small>
            </div>

            <div class="form-check">
                <input type="checkbox" name="recuerdame" value="1" class="form-check-input" id="AyudaCheck">
                <label class="form-check-label" for="AyudaCheck">Recordar Sesión</label>
            </div>

            <br><button type="submit" name="login" class="btn btn-primary">Login</button>
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



<!--<script>

document.addEventListener("DOMContentLoaded", function() 
{
  document.getElementById("formulario").addEventListener('submit', validarFormulario); 
});

function validarFormulario(evento) 
{
    evento.preventDefault();
    var usuario = document.getElementById('usuario').value;
    if(usuario.length == 0) {
        alert('No has escrito nada en el usuario');
        return;
    }
    var clave = document.getElementById('clave').value;
    if (clave.length < 6) {
        alert('La clave no es válida');
        return;
    }
    this.submit();
}
</script>-->
