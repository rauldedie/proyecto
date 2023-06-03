<?php
session_start();
$tiempo_inactivo = 10 * 60;
if (!array_key_exists("usuario_id",$_SESSION))
{
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA
if (isset($_SESSION['inactivo']) && (time() - $_SESSION['inactivo']) > $tiempo_inactivo) 
{
    session_unset();
    session_destroy();

    //Redireccionamos el usuario a logout
    header("Location: logout.php");
    exit();
}else
{
// Regenera nueva sesion y fija de nuevo el tiempo
session_regenerate_id(true);

// Update the last timestamp
$_SESSION['inactivo'] = time();
}

include "conexion.php";

if (isset($_GET['idusuario']))
{
    $id = htmlspecialchars($_GET['idusuario']);

    if (isset($_POST['cambiar']))
    {
        $contraseña_actual = md5(mysqli_real_escape_string($enlace, $_POST['contrasena_actual']));
        $nueva = mysqli_real_escape_string($enlace, $_POST['nueva_contrasena']);
        $nueva_contraseña = md5(mysqli_real_escape_string($enlace, $nueva));

        $confirmar_contraseña = md5(mysqli_real_escape_string($enlace, $_POST['confirmar_contrasena']));
        $sql = "SELECT pass FROM usuarios2 WHERE idusuario = {$id}";
        $result = mysqli_query($enlace, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row['contrasena'] == $contraseña_actual) 
        {
            if ($nueva_contraseña == $confirmar_contraseña) 
            {
                $sql = "UPDATE usuarios2 SET pass = '{$nueva}' WHERE idusuario = {$id}";
                if (mysqli_query($enlace, $sql)) 
                {
                    echo "Contraseña actualizada exitosamente.";
                }else 
                {
                    echo "Error: " . $sql . "<br>" . mysqli_error($enlace);
                }
            }else 
            {
                echo "La nueva contraseña y la confirmación no coinciden.";
            }

        }else 
        {
            echo "La contraseña actual es incorrecta.";
        }

        mysqli_close($enlace);
    }
}
include "cabecera.php";?>
<h1>Cambiar contraseña</h1>
<div class="container">
    <form action="actualizar_pass.php" method="POST">
        <label for="contraseña_actual">Contraseña actual:</label>
        <input type="password" id="contrasena_actual" name="contrasena_actual" required class="form-control">
        <br>
        <label for="nueva_contraseña">Nueva contraseña:</label>
        <input type="password" id="nueva_contrasena" name="nueva_contrasena" required class="form-control">
        <br>
        <label for="confirmar_contraseña">Confirmar nueva contraseña:</label>
        <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required class="form-control">

        <br>
        <input type="submit" name="cambiar" value="Cambiar contraseña">
    </form>
    <div class="container text-center mt-5">
    <a href="panelgestion.php?usuario=<?php echo $id?>" class="btn btn-warning mt-5"> Volver </a>
  </div>
</div>
<?php include "pie.php";?>