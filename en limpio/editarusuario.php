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


$idusuarioenuso = $_SESSION['usuario_id'];
$nombreusuario = $_SESSION['usuario_nombre'];
$rolenuso = $_SESSION['usuario_rol']; 


if(isset($_GET['usuarioid']))
{
    $usuario_id = htmlspecialchars($_GET['usuarioid']); 
    include "conexion.php";

    $query="SELECT * FROM usuarios2 WHERE idusuario = {$usuario_id}";
    $vista_usuarios= mysqli_query($enlace,$query);
    $fila= mysqli_fetch_array($vista_usuarios);

    $id = $fila['idusuario']; 

    $nombre = $fila['nombre'];
    $apellidos = $fila['apellidos'];

    $idusuario = $id;      
    $usuario = $fila['nombreusuario'];       
    $email = $fila['mail'];       
    $telefono = $fila['telefono'];        
    $rol = $fila['rol'];

    if(isset($_POST['editar'])) 
    {
        //$usuario_mod = (htmlspecialchars($_POST['usuario']));
        $usuario_mod = stripslashes($_POST['usuario']);
        $usuario_mod = mysqli_real_escape_string($enlace,$usuario_mod);
        //$nombre_mod = (htmlspecialchars($_POST['nombre']));
        $nombre_mod = stripslashes($_POST['nombre']);
        $nombre_mod = mysqli_real_escape_string($enlace,$nombre_mod);
        //$apellidos_mod = htmlspecialchars($_POST['apellidos']);
        $apellidos_mod = stripslashes($_POST['apellidos']);
        $apellidos_mod = mysqli_real_escape_string($enlace,$apellidos_mod);
        //$email_mod = htmlspecialchars($_POST['email']);
        //$email_mod = stripslashes($_POST['email']);
        $email_mod = mysqli_real_escape_string($enlace,$_POST['email']);
        $email_mod = filter_var($email_mod, FILTER_SANITIZE_EMAIL);
        $email_mod = filter_var($email_mod, FILTER_VALIDATE_EMAIL);
        //$telefono_mod = htmlspecialchars($_POST['telefono']);
        $telefono_mod = stripslashes($_POST['telefono']);
        $telefono_mod = mysqli_real_escape_string($enlace,$telefono_mod);

        $query = "UPDATE usuarios2 SET nombreusuario='{$usuario_mod}', nombre='{$nombre_mod}', apellidos='{$apellidos_mod}', telefono='{$telefono_mod}', mail='{$email_mod}' WHERE idusuario={$idusuario}";
        $usuario_actualizado = mysqli_query($enlace,$query);
        //echo $query."<br>";

        if (!$usuario_actualizado)
        {
            echo "Error en la actualizacion del usuario <br>".mysqli_error($enlace);
        }else
        {
            echo "<script type='text/javascript'>alert('¡Usuario actualizado!')</script>";
            echo "<script>window.location='editarusuario.php?usuarioid=". $usuario_id . "';</script>";
        }

    }
        mysqli_close($enlace);
}         
include "cabecera.php";
?>

<h1 class="text-center">Gestión de incidencias (CRUD). Panel Administrador - Editar Usuario.</h1>
<div>
    <p class="usuario"><?php echo"Usuario en uso: ".$nombreusuario; ?></p>
</div>
<div class="container2">
<div class="container">
  <p class="edicion"><h3 class="edicion"> Datos actuales del Usuario:</h3></p>
  <p class="edicion">Usuario: <?php echo $usuario?></p>
  <p class="edicion">Nombre: <?php echo $nombre?></p>
  <p class="edicion">Apellidos: <?php echo $apellidos?></p>
  <p class="edicion">Telefono: <?php echo $telefono?></p>
  <p class="edicion">Email: <?php echo $email?> </p>        
  <p class="edicion">Rol: <?php echo $rol?></p>       
</div>

<div class="container ">
  <form action="" method="post">
    <div class="form-group">
      <p><h3>Datos modificables del Usuario:</h3></p>
      <label for="usuario" >Nombre de Usuario</label>
      <input type="text" name="usuario" class="form-control" value="<?php echo $usuario?>">
      <label for="nombre" >Nombre</label>
      <input type="text" name="nombre" class="form-control" value="<?php echo $nombre?>">
      <label for="apellidos" >Apellidos</label>
      <input type="text" name="apellidos" class="form-control" value="<?php echo $apellidos?>">
      <label for="telefono" >Teléfono</label>
      <input type="text" name="telefono" class="form-control" value="<?php echo $telefono?>">
      <label for="email" >Correo Electrónico</label>
      <input type="email" name="email" class="form-control" value="<?php echo $email?>">
      <p><h1>El resto de datos no pueden ser modificados tendras que eliminar y crear el usuario de nuevo.</h1></p>
    </div>

    <div class="form-group">
        <input type="submit"  name="editar" class="btn btn-primary mt-2" value="editar">
    </div>
  </form>    
</div>
</div>

<div class="container text-center mt-5">
  <a href="gestionarusuario.php" class="btn btn-warning mt-5"> Volver </a>
</div>

<?php include "pie.php" ?>