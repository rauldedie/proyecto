<?php
session_start();
include 'include/conexion.php';
if ((array_key_exists("usuario_id",$_SESSION) AND $_SESSION['usuario_id']) OR (array_key_exists("usuario_id",$_COOKIE) AND $_COOKIE['usuario_id'])){
    // Si ya tenia la sesion iniciada
    //header("Location: include/paneladmin.php?rol=" . $_COOKIE["rol"]);
}

if (isset($_POST["login"]))
{
    $error="";
    $usuario = mysqli_real_escape_string($enlace, $_POST['usuario']);
    $pass = mysqli_real_escape_string($enlace, $_POST['password']);
    //echo "Usuario: " . $usuario . " y password: " . $pass;
    if (empty($usuario))
    {
        $error .= "El campo usuario no puede quedar vacío.";

    }else if (empty($pass))
    {
        $error .= "El campo contraseña no puede quedar vacío.";
    }else
    {

        $sql = "SELECT * FROM usuarios2 WHERE nombreusuario='" . $usuario . "' AND pass='" . $pass . "'";
        $result = mysqli_query($enlace, $sql);

        if ($result)
        {
            $row = mysqli_fetch_array($result);
           
            if (mysqli_num_rows($result)>0)
            {
                /*$datos = [];
                $datos['idusuario'] = $row['idusuario'];
                $datos['usuario'] = $row['nombreusuario'];
                $datos['rol'] = $row['rol'];*/

                $_SESSION['usuario_id'] = $row['idusuario'];
                $_SESSION['usuario_nombre'] = $usuario;
                $_SESSION['rol'] = $rol;
            

                if ($_POST['recuerdame']=='1')
                {

                    $fecha = date('Y-m-d H:i:s');
                    $idusuario = $row['idusuario'];

                    $query = "INSERT INTO accesos (idusuario,fecha) VALUES ({$idusuario},'{$fecha}')"; // Historial de accesos
                    mysqli_query($enlace, $query);
                    //echo $query;
                }
                
                echo "<script>window.location='panelrol.php?usuario=". $row['rol'] . "';</script>";
                
            }
            else {
                echo "Usuario y/o password erróneo.";
            }
        }
        else
        {
            echo "Usuario y/o contraseña incorrectos." . mysqli_error($enlace);
            mysqli_close($enlace);
        }  
    }
}
include "include/cabecera.php";
?>
<div class="container">
    <h1>GESTIÓN INCIDENCIAS TÉCNICAS IES A. MACHADO</h1> 
    <div>
        <p><h3>Introduce tu usuario y contraseña para entrar al sistema</h3></p>

        <form action="index.php" method="POST">
            <div class="form-group">
                <div>
                    <img class="iconoayuda" id="ayuda" onmouseover="Ayuda()" src="iconos/ayuda.png" alt="ayuda">
                </div>
        
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
                <input type="checkbox" name="recuerdame" value="1" class="form-check-input" id="AyudaCheck">
                <label class="form-check-label" for="AyudaCheck">Mantener Sesión (la sesion durará 24 horas)</label>
            </div>

            <br><button type="submit" name="login" class="btn btn-primary">Login</button>
            <p><a href="include/recordar_pass.php" target="_blank">Recordar contraseña</a></p>               
        </form>
    </div>
    <div>
        <label class="error" id="aviso1" ></label>
    </div> 
    <div>
        <label class="error" id="aviso2" ></label>
    </div>
</div>  
<?php include "include/pie.php"; ?>
