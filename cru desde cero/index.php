<?php
session_start();
//ver si la sesion esta caducada
//ver si la sesion no esta caducada y esta iniciada
//acciones si la sesion no esta iniciada (hacer el login)
include "include/conexion.php";
if (isset($_POST["login"]))
{
    $error="";
    $usuario = mysqli_real_escape_string($enlace, $_POST['usuario']);
    $pass = mysqli_real_escape_string($enlace, $_POST['password']);
    if (empty($usuario))
    {
        $error .= "El campo usuario no puede quedar vacío.";

    }else if (empty($pass))
    {
        $error .= "El campo contraseña no puede quedar vacío.";
    }else
    {
        //include "encriptar.php";
        //$usuarioc = openssl_encrypt($usuario, $metodo,$key, $options, $vectorcript);
        //$sql = "SELECT * FROM usuarios2 WHERE nombreusuario = '$usuarioc'";
        //PRIMERO EL USUARIO Y LUEGO LA CONTRASEÑA.
        $sql = "SELECT * FROM usuarios2 WHERE nombreusuario='" . $usuario . "' AND pass='" . $pass . "'";
        $result = mysqli_query($enlace, $sql);
        //while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        //    echo "ID: " . $row["idusuario"]. ", nombre: " . $row["nombre"]. ", nombreusuario: " . $row["nombreusuario"] . ", password:" . $row["pass"] . "<br>";
        //}
        if ($result)
        {
            $row = mysqli_fetch_array($result);
            //$passh = md5(md5($row["idusuario"]).$pass); DE MOMENTO ESTAN SIN ENCRIPTAR
            if (mysqli_num_rows($result)>0)
            {
                //$usuario = openssl_decrypt($row['nombreusuario'], $metodo,$key, $options, $vectorcript);
                //$rol = openssl_decrypt($row['rol'], $metodo,$key, $options, $vectorcript);
                
                // Establecer tiempo de vida de la sesión en segundos
                $inactividad = 600;
                // Comprobar si $_SESSION["timeout"] está establecida
                if(isset($_SESSION["timeout"]))
                {
                    // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
                    $sessionTTL = time() - $_SESSION["timeout"];
                    if($sessionTTL > $inactividad)
                    {
                        session_destroy();
                        header("Location: /include/logout.php");
                    }
                }
                // El siguiente key se crea cuando se inicia sesión

                $_SESSION["timeout"] = time();

                $rol = $row['rol'];
                $_SESSION['idusuario'] = $row['idusuario'];
                $_SESSION['nombreusuario'] = $usuario;
                $_SESSION['rol'] = $rol;

                if ($_POST['recuerdame']=='1')
                {
                    setcookie("idusuario", $row['idusuario'], time() + 86400); // 86400 = 1 día
                    setcookie("nombreusuario", $usuario, time() + 86400); // ¿Para que?
                    setcookie("rol", $rol,time()+86400);  // ¿Para que?
                    $fecha = date('Y-m-d H:i:s');
                    $idusuario = $row['idusuario'];
                    //$sql = sprintf ("INSERT INTO accesos (idusuario, fecha) VALUES ('%i','%d')",$idusuario,$fecha);
                    //TIENEN QUE LLEVAR COMILLAS LAS FECHAS???? LO HE PROBADO CON Y SIN Y NO VA
                    $sql = "INSERT INTO accesos (idusuario, fecha) VALUES ({$idusuario}, '{$fecha}')"; // Historial de accesos
                    mysqli_query($enlace, $sql);
                }
            
                echo "<script>window.location='include/paneladmin.php?rol=". $rol . "';</script>";
        
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

include("include/header.php");
?>
<p><h1>GESTIÓN INCIDENCIAS TÉCNICAS IES A. MACHADO - LOGIN</h1></p>
    <div class="container">
        <div id="error">
            <?php
            echo $error;
            ?>
        </div>
        
        <div>
            <form action="index.php" method="POST">
                <div class="form-group">
                    <label for="usuario">Nombre de Usuario
                        <input type="text" name="usuario" class="form-control" id="usuario" aria-describedby="AyudaUsuario" placeholder="Escribe tu usuario">
                        <small id="AyudaUsuario">Este campo es obligatorio.</small>
                    </label>
                </div>

                <div class="form-group">
                    <label for="Password">Password
                        <input type="password" name="password" aria-describedby="AyudaPasswd" class="form-control" id="Password" placeholder="Escribe tu Password">
                        <small id="AyudaPasswd" >Este campo es obligatorio.</small>
                    </label>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="recuerdame" value="1" class="form-check-input" id="AyudaCheck">
                    <label class="form-check-label" for="AyudaCheck">Mantener Sesión (la sesion durará un max. de  24 horas)</label>
                </div><br>

                <button type="submit" name="login" onclick="ValidarLogin()" class="btn btn-primary">Iniciar Sesión</button><br><br>
                <p><a href="include/recordar_pass.php" target="_blank">Recordar contraseña</a></p> 
                
            </form>

        </div>
    </div>

<?php
    include("include/footer.php");
?>