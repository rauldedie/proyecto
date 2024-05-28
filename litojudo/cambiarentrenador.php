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

$query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idenuso} and u.tipousuario=t.idtipo and u.estado='alta'";
$fila = mysqli_fetch_array(mysqli_query($enlace,$query));

if (strcmp($fila['tipo'],"administrador")!=0)
{
    echo "<script>window.location='logout.php;</script>";
}else
{
    if (isset($_GET['dojo']))
    {
        $iddojo = htmlspecialchars(stripslashes($_GET['dojo']));

    }else $iddojo = 1;

    //Obtengo nombre dojo
    $query = "SELECT * FROM dojo WHERE iddojo={$iddojo}";
    $dojo = mysqli_fetch_array(mysqli_query($enlace,$query));
    $nombredojo = $dojo['nombre']; 
 
    include "cabecera.php";
    //Muestro menu de la pagina
    echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>";
    echo"<p><img class='logo' src='logolitho.jpg'></p>";
    echo "<label class='navbar-brand'><span class='text-light bg-dark'>GESTION CLASES</span></label>
    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
        <ul class='navbar-nav mr-auto'>

            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='gestionardojo.php?dojo={$iddojo}&&mostrar=all&&ord=desc&&campo=nombre&&usuario={$rolenuso}' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <span class='text-light bg-dark'>Gestionar Alumnos</span>
                </a>
                <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                    <a class='dropdown-item' href='gestionardojo.php?dojo={$iddojo}&&mostrar=all&&ord=desc&&campo=nombre&&usuario={$rolenuso}'>Gestionar alumnos</a>
                    <a class='dropdown-item' href='altadeportista.php?dojo={$iddojo}'>Añadir nuevo alumno</a> 
                </div>
            </li>

            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <span class='text-light bg-dark'>Gestionar Clases</span></a>
                <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                    <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=1&&hora=1'>Clase lunes-miércoles (16:30-17:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=1&&hora=2'>Clase lunes-miércoles (17:30-18:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=1&&hora=3'>Clase lunes-miércoles (18:30-19:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=1&&hora=4'>Clase lunes-miércoles (19:30-20:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=1&&hora=5'>Clase lunes-miércoles (20:30-22:00)</a>
                    <div class='dropdown-divider'></div>
                    <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=2&&hora=1'>Clase martes-jueves (16:30-17:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=2&&hora=2'>Clase martes-jueves (17:30-18:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=2&&hora=3'>Clase martes-jueves (18:30-19:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=2&&hora=4'>Clase martes-jueves (19:30-20:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=2&&hora=5'>Clase martes-jueves (20:30-22:00)</a>
                    <div class='dropdown-divider'></div>
                    <a class='dropdown-item' href='cambiarentrenador.php?dojo={$iddojo}'>Cambios de entrenador en clases</a>
                    <div class='dropdown-divider'></div>
                    <a class='dropdown-item' href='#'>Nueva Clase</a>
                </div>
            </li>


            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <span class='text-light bg-dark'>Gestionar Usuarios</span></a>
                <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                    <a class='dropdown-item' href='#'>Nuevo Usuario</a>
                </div>
            </li>
            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <span class='text-light bg-dark'>Tesorería</span></a>
                <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                    <a class='dropdown-item' href='#'>Ingresos</a>
                    <a class='dropdown-item' href='#'>Gastos</a>
                
                    <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='#'>Balance</a>
                    </div>
                </div>
            </li>
            <li class='nav-item'>
                <a class='navbar-brand' href='gestionardojo.php?dojo={$iddojo}&&usuario={$idenuso}'><span class='text-primary'>VOLVER</span></a>
            </li>
            <li class='nav-item'>
                <a class='navbar-brand' href='avisolegal.php'><span class='text-warning'>AVISO LEGAL</span></a>
            </li>
            <li class='nav-item'>
                <a class='navbar-brand' href='logout.php'><span class='text-warning'>SALIR</span></a>
            </li>
        </ul>    
    </div>
    </nav><br>";

    echo "<label class='nav-item'><h6>Usuario: ".$nombreusuario."</h6></label><br>";
    echo "<label class='nav-item'><h6>Dojo: ".$nombredojo."</h6></label><br>";

    //pillo las clases que tenemos por dojo
    $query = "SELECT * from clases where iddojo={$iddojo}";
    //echo $query;
    $resp = mysqli_query($enlace,$query);

    echo "<table class='table table-striped table-bordered table-hover'>";
    echo "<thead class='table table-striped'>";
        echo "<tr>";
            echo "<th class='table-dark' scope='col'>Dias de la clase</th>";
            echo "<th class='table-dark' scope='col'>Hora de la clase</th>";
            echo "<th class='table-dark' scope='col'>Entrenador</th>";
            echo "<th class='table-dark' scope='col' class='text-center'>Operaciones</th>";
        echo "</tr>";  
    echo "</thead>";
    echo "<tbody>";

    while ($clase = mysqli_fetch_assoc($resp))
    {
        $idclase = $clase['idclase'];

        //miro el dia y la hora que le corresponde
        $query = "SELECT *from horasclases where idhoraclase={$clase['idhoraclase']}";
        //echo $query;
        $horaclase = mysqli_fetch_array(mysqli_query($enlace,$query));

        $query = "SELECT *from diasclases where iddiaclase={$clase['iddiaclase']}";
        //echo $query;
        $diaclase = mysqli_fetch_array(mysqli_query($enlace,$query));

        //averiguo el entrenador para la clase
        $query = "SELECT e.identrenador, u.nombre from entrenadores e, usuarios u 
        where e.identrenador={$clase['identrenador']} and e.idusuario=u.idusuario";
        //echo $query;
        $entrenador = mysqli_fetch_array(mysqli_query($enlace,$query));

        echo "<tr>";
            echo "<td>{$diaclase['diaclase']}</td>";
            echo "<td class='table-dark'>{$horaclase['hora']}</td>";
            echo "<td class='table-dark'>{$entrenador['nombre']}</td>";
            echo " <td class='text-center' > <a href='camb_entrenador.php?clase={$idclase}&&dojo={$iddojo}' class='btn btn-danger' ><i class='bi bi-pencil'></i> Cambiar Entrenador</a> </td>";
        echo "</tr>";

    }
    echo "</body>";
    echo "</table>";
    include "pie.php";
}
mysqli_close($enlace);
?>