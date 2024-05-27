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

$nombreusuario = $_SESSION['usuario_nombre'];
$idenuso = $_SESSION['usuario_id'];
$rolenuso = $_SESSION['usuario_rol'];



include "cabecera.php";?>
<h1>GESTIÓN ESCUELA DEPORTIVA LITHOJUDO</h1>
<h1>PANEL PRINCIPAL</h1>
<p>Usuario:<?php echo $nombreusuario;?></p>
<div class="container">
  <br><br>
  <div>
  <a href="gestiondeportistas.php?mostrar=all&&ord=asc&&campo=dateborn&&usuario=<?php echo $rolenuso?>" class="btn btn-primary mt-2"> <h3>Gestión Deportistas</h3></a>
  </div><br>
  <div>
  <a href="gestionclases.php" class="btn btn-primary mt-2"> <h3>Gestión Clases</h3> </a>
  </div><br>
  <div>
  <a href="gestionpersonal.php" class="btn btn-primary mt-2"> <h3>Gestión Personal</h3> </a>
  </div><br>
  <div>
  <a href="gestiondojos.php" class="btn btn-primary mt-2"> <h3>Gestión Dojos</h3> </a>
  </div><br>
  <div>
  <a href="gestioneconomica.php" class="btn btn-primary mt-2"> <h3>Gestión Económica</h3> </a>
  </div>

  <br><br><br><br><a href='logout.php' class='btn btn-warning mt-5'> Salir </a>

</div>



<?php include "pie.php";
?>