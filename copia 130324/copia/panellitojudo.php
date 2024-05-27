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
$nombreusuario = $_SESSION['usuario_nombre'];
$idenuso = $_SESSION['usuario_id'];
$rolenuso = $_SESSION['usuario_rol'];

if (isset($_GET['usuario']))
{
  $idusuario = htmlspecialchars(stripslashes($_GET['usuario']));
  if($idusuario == $idenuso)
  {
    $query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idusuario} and u.tipousuario=t.idtipo and u.estado='alta'";
    $fila = mysqli_fetch_array(mysqli_query($enlace,$query));
    if (strcmp($fila['tipo'],"administrador")!=0)
    {
      echo "<script>window.location='logout.php;</script>";
    }
  }else
  {
    echo "<script>window.location='logout.php;</script>";
  }
  
}

include "cabecera.php";?>

<nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <p><img class="logo" src="logolitho.jpg"></p>
  <label class="navbar-brand"><span class="text-light bg-dark">PANEL PRINCIPAL</span></label>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="gestiondeportistas.php?estado=alta&&mostrar=all&&ord=desc&&campo=nombre&&usuario=<?php echo $rolenuso?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="text-light bg-dark">Gestionar Alumnos</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class='dropdown-item' href='gestiondeportistas.php?mostrar=all&&ord=desc&&campo=nombre&&usuario=<?php echo $rolenuso?>'>Gestionar alumnos</a>
          <a class='dropdown-item' href='altadeportista.php'>Añadir nuevo alumno</a> 
        </div>
      </li>
      <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
        <span class='text-light bg-dark'>Gestionar Escuela</span></a>
        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
          <?php 
              //include "conexion.php";
              $query = "SELECT * FROM dojo ";
              $respuesta = mysqli_query($enlace,$query);
              while ($dojo = mysqli_fetch_assoc($respuesta))
              {
                echo "<a class='dropdown-item' href='gestionardojo.php?dojo={$dojo[iddojo]}'>{$dojo['nombre']}</a>";
                echo "<div class='dropdown-divider'></div>";
              }
              echo "<a class='dropdown-item' href='#'>Nuevo Dojo</a>";
              
          ?>
        </div>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="#"><span class="text-light bg-dark">Gestionar Usuarios</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="text-light bg-dark">Tesorería</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Ingresos</a>
          <a class="dropdown-item" href="#">Gastos</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Balance</a>
        </div>
      </li>
      <li class='nav-item'>
        <a class='navbar-brand' href='logout.php'><span class='text-warning'>SALIR</span></a>
      </li>
    </ul>
    
  </div>
</nav>
<br>
<label class='nav-item'><h6>Usuario:<?php echo " ".$nombreusuario ?></h6></label><br>

<div class="container">

  <br><br>
  <div>
    <h1>GESTIÓN ESCUELA DEPORTIVA LITHOJUDO</h1>
  </div>
</div>



<?php 
mysqli_close($enlace);
include "pie.php";
?>