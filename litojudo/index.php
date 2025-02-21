<?php
session_start();

if ((array_key_exists("usuario_id",$_SESSION) AND $_SESSION['usuario_id']) OR (array_key_exists("usuario_id",$_COOKIE) AND $_COOKIE['usuario_id'])){
    // Si ya tenia la sesion iniciada
    header("Location:panelprincipal.php?rol={$_SESSION['usuario_rol']}&&usuario={$_SESSION['usuario_id']}");
 
}

if (isset($_POST["login"]))
{
    include 'conexion.php';
    $error="";
    $usuario = htmlspecialchars(mysqli_real_escape_string($enlace, stripslashes($_POST['usuario'])));
    $pass = htmlspecialchars(mysqli_real_escape_string($enlace, stripslashes($_POST['password'])));
    
    $error="";
    if (empty($usuario))
    {
        $error .= "El campo usuario no puede quedar vacío.";

    }else if (empty($pass))
    {
        $error .= "El campo contraseña no puede quedar vacío.";
    }else
    {

        //encripto el pass y el usuario paara que se pueda comparar con la BD
        $dato = $pass;
        include "encriptar.php";
        $pass = $datocry;

        $dato = $usuario;
        include "encriptar.php";
        $usuario = $datocry;

        echo $pass."<br>";
        echo $usuario."<br>";


        $query = "SELECT * FROM usuarios WHERE usuario='{$usuario}' AND pass='{$pass}' and estado='alta'";
        //$resultado = mysqli_query($enlace, $query);

        if (mysqli_num_rows($resultado)>0)
        {
            $row = mysqli_fetch_array($resultado);

            //desencripto datos
            $datocry = $row['idusuario'];
            include "desencriptar.php";
            $idusuario = $datodcry;

            $$datocry = $row['tipousuario'];
            include "desencriptar.php";
            $tipousuario = $datodcry;


            $_SESSION['usuario_id'] = $idusuario;
            $_SESSION['usuario_nombre'] = $usuario;
            $_SESSION['usuario_rol'] = $tipousuario;
            $_SESSION['inactivo'] = time();

            $query = "SELECT tipousuario FROM tipo_usuario WHERE idtipo={$tipousuario}";
            $fila = mysqli_fetch_array(mysqli_query($enlace,$query));
            
            if (strcmp($fila['tipousuario'],'administrador')==0)
            {
                //echo "<script>window.location='panelprincipal.php?rol={$row['tipousuario']}&&usuario={$row['idusuario']}</script>";
                header("Location:panelprincipal.php?rol={$_SESSION['usuario_rol']}&&usuario={$_SESSION['usuario_id']}");
            }else
            {
                echo "<script>window.location='logout.php;</script>";
            }
            
            //echo "<script type='text/javascript'>alert('¡Te has logado correctamente!')</script>";
        }else 
        {
            echo "<script type='text/javascript'>alert('¡Usuario y/o contraseñas erróneos!')</script>";
            //echo "<p class='usuario'>Usuario y/o password erróneo. " . mysqli_error($enlace)."</p>";
            
            
        }
    }
    //echo $error;
    mysqli_close($enlace);
}

include "cabecera.php";
?>
<div class="container">
    <h1>GESTIÓN ESCUELA DEPORTIVA LITHOJUDO</h1> 
    <div>
        <p><h3>Introduce tu usuario y contraseña para entrar al sistema</h3></p>

        <form id="formulario" name="formulario" action="index.php" method="POST">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="InputUsuario" name="usuario" placeholder="Usuario">
                <label for="floatingInput">Nombre de usuario</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="InputPassword" placeholder="Contraseña">
                <label for="floatingPassword">Contraseña</label>
            </div>
            <br><button type="submit" name="login" class="btn btn-primary">Login</button>
            <p><a href="recordar_pass.php" target="_blank">Recordar contraseña</a></p>               
        </form>
    </div>
    <div>
        <label class="error" id="aviso1" ></label>
        <?php if($error!="") echo $error; ?>
    </div> 
</div>  
<?php include "pie.php"; ?>