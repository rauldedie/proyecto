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
  $idusuario = htmlspecialchars(stripslashes(trim($_GET['usuario'])));
  if(isset ($_GET['rol']))
  {
    $rol=htmlspecialchars(stripslashes(trim($_GET['rol'])));
    $query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idusuario} and u.tipousuario={$rol} and u.estado='alta'";
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

include "cabecera.php";
//Muestro menu de la pagina
echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>
<p><img class='logo' src='logolitho.jpg'></p>
<label class='navbar-brand'><span class='text-light bg-dark'>PANEL PRINCIPAL</span></label>
  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
    <ul class='navbar-nav mr-auto'>
      <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
        <span class='text-light bg-dark'>Gestionar Escuela</span></a>
        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
          $query = "SELECT * FROM dojo ";
          $respuesta = mysqli_query($enlace,$query);
          while ($dojo = mysqli_fetch_assoc($respuesta))
          {
            echo "<a class='dropdown-item' href='gestionardojo.php?dojo={$dojo['iddojo']}&&usuario={$idusuario}'>{$dojo['nombre']}</a>";
            echo "<div class='dropdown-divider'></div>";
          }
          echo "<a class='dropdown-item' href='#'>Nuevo Dojo</a>
        </div>
      </li>
      <li></li>
      <li></li>
      <li></li>
      <li class='nav-item'>
        <a class='navbar-brand' href='logout.php'><span class='text-warning'>SALIR</span></a>
      </li>

    </ul>

    </div>
</nav>";
echo "<label class='nav-item'><h6>Usuario: ".$nombreusuario."</h6></label><br>
<table class='table table-striped table-bordered table-hover'>
<thead class='table table-striped'>
    <tr>                   
      <th class='table-dark' scope='col'colspan='12'><center><h3>RESUMEN GENERAL ESCUELA LITHOJUDO</h3></center></th>
    </tr>
    <tr>";
    $query = "SELECT * FROM dojo ";
    $respuesta = mysqli_query($enlace,$query);

    while ($dojo = mysqli_fetch_assoc($respuesta))
    {
      echo "                  
        <th class='table-dark' scope='col'colspan='6'><center><h4>{$dojo['nombre']}</h4></center></th>";
    }
    echo "</tr> 
 </thead>";

$query = "SELECT count(*) total FROM alumnos WHERE iddojo=1";
$totalbormujos = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos WHERE iddojo=2";
$totalmairena = mysqli_fetch_array(mysqli_query($enlace,$query));

$query = "SELECT count(*) total FROM alumnos where competicion = 1 and iddojo=1";
$fedbormujos = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where competicion = 1 and iddojo=2";
$fedmairena = mysqli_fetch_array(mysqli_query($enlace,$query));

$query = "SELECT count(*) total FROM alumnos where competicion = 2 and iddojo=1";
$ligabormujos = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where competicion = 2 and iddojo=2";
$ligamairena = mysqli_fetch_array(mysqli_query($enlace,$query));

$query = "SELECT count(*) total FROM alumnos where competicion = 3 and iddojo=1";
$nobormujos = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where competicion = 3 and iddojo=2";
$nomairena = mysqli_fetch_array(mysqli_query($enlace,$query));

$query = "SELECT count(*) total FROM alumnos where idnivel = 12 and iddojo=1";
$negrobormujos = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where idnivel = 11 and iddojo=1";
$marronbormujos = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where idnivel in (9,10) and iddojo=1";
$azulbormujos = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where idnivel in (7,8) and iddojo=1";
$verdebormujos = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where idnivel in (5,6) and iddojo=1";
$naranjabormujos = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where idnivel in (3,4) and iddojo=1";
$amarillobormujos = mysqli_fetch_array(mysqli_query($enlace,$query));

$query = "SELECT count(*) total FROM alumnos where idnivel = 12 and iddojo=2";
$negromairena= mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where idnivel = 11 and iddojo=2";
$marronmairena = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where idnivel in (9,10) and iddojo=2";
$azulmairena = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where idnivel in (7,8) and iddojo=2";
$verdemairena = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where idnivel in (5,6) and iddojo=2";
$naranjamairena = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM alumnos where idnivel in (3,4) and iddojo=2";
$amarillomairena = mysqli_fetch_array(mysqli_query($enlace,$query));

$query = "SELECT count(*) total FROM entrenadores e, clases c where c.iddojo=1";
$entbormujos = mysqli_fetch_array(mysqli_query($enlace,$query));
$query = "SELECT count(*) total FROM entrenadores e, clases c where c.iddojo=2";
$entmairena = mysqli_fetch_array(mysqli_query($enlace,$query));

 echo "<body>
  <tr>
    <td scope='row' colspan='6'><center>Total Alumnos: {$totalbormujos['total']}</center></td>
    <td scope='row' colspan='6'><center>Total Alumnos: {$totalmairena['total']}</center></td>
  </tr>
  <tr>
    <td scope='row' colspan='2'><center>Federados: {$fedbormujos['total']}</center></td>
    <td scope='row' colspan='2'><center>Judoliga: {$ligabormujos['total']}</center></td>
    <td scope='row' colspan='2' class='table-dark'><center>No compite: {$nobormujos['total']}</center></td>
    <td scope='row' colspan='2' class='table-dark'><center>Federados: {$fedmairena['total']}</center></td>
    <td scope='row' colspan='2'><center>Judoliga: {$ligamairena['total']}</center></td>
    <td scope='row' colspan='2'><center>No compite: {$nomairena['total']}</center></td>
  </tr>
  <tr>
    <td scope='row' colspan='6'><center>KYUS</center></td>
    <td scope='row' colspan='6'><center>KYUS</center></td>
  </tr>
  <tr>
    <td scope='row' colspan='2'><center>Kyus negros: {$negrobormujos['total']}</center></td>
    <td scope='row' colspan='2'><center>Kyus marrones: {$marronbormujos['total']}</center></td>
    <td scope='row' colspan='2' class='table-dark'><center>Kyus azules: {$azulbormujos['total']}</center></td>
    <td scope='row' colspan='2' class='table-dark'><center>Kyus negros: {$negromairena['total']}</center></td>
    <td scope='row' colspan='2'><center>Kyus marrones: {$marronmairena['total']}</center></td>
    <td scope='row' colspan='2'><center>Kyus azules: {$azulmairena['total']}</center></td>
  </tr>
  <tr>
    <td scope='row' colspan='2'><center>Kyus verdes: {$verdebormujos['total']}</center></td>
    <td scope='row' colspan='2'><center>Kyus naranjas: {$naranjabormujos['total']}</center></td>
    <td scope='row' colspan='2' class='table-dark'><center>Kyus amarillos: {$amarillobormujos['total']}</center></td>
    <td scope='row' colspan='2' class='table-dark'><center>Kyus verdes: {$verdemairena['total']}</center></td>
    <td scope='row' colspan='2'><center>Kyus naranjas: {$maramjamairena['total']}</center></td>
    <td scope='row' colspan='2'><center>Kyus amarillos: {$amarillomairena['total']}</center></td>
  </tr>
  <tr>
    <td scope='row' colspan='6'><center>ENTRENADORES: {$entbormujos['total']}</center></td>
    <td scope='row' colspan='6'><center>ENTRENADORES: {$entmairena['total']}</center></td>
  </tr>";
  if($rol==1 || $rol==3)
  {
    echo "
    <tr>
    <td scope='row' colspan='6'><center>ECONOMIA</center></td>
    <td scope='row' colspan='6'><center>ECONOMIA</center></td>
  </tr>";
  }

echo "</body>
</table>"; 

mysqli_close($enlace);
include "pie.php";
?>