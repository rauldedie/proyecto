<?php
session_start();
setlocale(LC_ALL, 'es_ES.UTF-8');
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

include "conexion.php"; 
include "cabecera.php";
//compruebo que es administrador quien esta en la sesion
//añadir entrenadores y oficina
$query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idenuso} and u.tipousuario=t.idtipo";
$fila = mysqli_fetch_array(mysqli_query($enlace,$query));

if (strcmp($fila['tipo'],"administrador")!=0)
{
    echo "<script>window.location='logout.php;</script>";
}
if(isset($_GET['estado']))
{
    $estado = htmlspecialchars(stripslashes($_GET['estado']));
    
}else $estado='alta';

if(isset($_GET['dojo']))
{
    $iddojo = htmlspecialchars(stripslashes($_GET['dojo']));

}else $iddojo = 1;

echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>";
echo"<p><img class='logo' src='logolitho.jpg'></p>";
echo "<label class='navbar-brand'><span class='text-light bg-dark'>GESTION DEPORTISTAS</span></label>
    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
        <ul class='navbar-nav mr-auto'>
            <li class='nav-item dropdown'>
            <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <span class='text-light bg-dark'>Ver Alumno</span></a>

                <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                    
                    <a class='dropdown-item' href='gestiondeportistas.php?mostrar=all&&ord=desc&&campo=nombre&&usuario={$idenuso}'>Gestionar alumnos</a>
                    <a class='dropdown-item' href='altadeportista.php'>Añadir nuevo alumno</a>
                </div>
            </li>

            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <span class='text-light bg-dark'>Gestionar Clases</span></a>
                <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                    <a class='dropdown-item' href='gestionarclases.php?dia=1&&hora=1'>Clase lunes-miércoles (16:30-17:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=1&&hora=2'>Clase lunes-miércoles (17:30-18:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=1&&hora=3'>Clase lunes-miércoles (18:30-19:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=1&&hora=4'>Clase lunes-miércoles (19:30-20:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=1&&hora=5'>Clase lunes-miércoles (20:30-22:00)</a>
                    <div class='dropdown-divider'></div>
                    <a class='dropdown-item' href='gestionarclases.php?dia=2&&hora=1'>Clase martes-jueves (16:30-17:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=2&&hora=2'>Clase martes-jueves (17:30-18:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=2&&hora=3'>Clase martes-jueves (18:30-19:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=2&&hora=4'>Clase martes-jueves (19:30-20:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=2&&hora=5'>Clase martes-jueves (20:30-22:00)</a>
                    <div class='dropdown-divider'></div>
                    <a class='dropdown-item' href='cambiarentrenador.php?clase=all'>Cambios de entrenador en clases</a>
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
                <a class='navbar-brand' href='gestionardojo.php?dojo={$iddojo}&&estado={$estado}&&mostrar=all&&ord=desc&&campo=nombre&&usuario={$idenuso}'><span class='text-primary'>VOLVER</span></a>
            </li>
            <li class='nav-item'>
                <a class='navbar-brand' href='avisolegal.php'><span class='text-warning'>AVISO LEGAL</span></a>
            </li>
            <li class='nav-item'>
                <a class='navbar-brand' href='logout.php'><span class='text-warning'>SALIR</span></a>
            </li>
        </ul>
    </div>
</nav>";
echo "<label class='nav-item'><h6>Usuario: {$nombreusuario}</h6></label>";

if(isset($_GET['idelemento']))//añadir poder consultar como entrenador y como oficina
{
    $idelemento = htmlspecialchars(stripslashes($_GET['idelemento']));

    if(isset($_GET['estado']))
    {
        $estado = htmlspecialchars(stripslashes($_GET['estado']));
    }

    
//Obtengo los datos del alumno
    $query = "SELECT * FROM alumnos WHERE idalumno={$idelemento} and estado='{$estado}'";   
    $alumno = mysqli_fetch_array(mysqli_query($enlace,$query));
    

//Obtengo los datos de nivel, competicion, clase, dojo y faltas
    $query = "SELECT * FROM nivel where idnivel={$alumno['idnivel']}";
    $kyu = mysqli_fetch_array(mysqli_query($enlace,$query));

    $query = "SELECT * FROM competiciones WHERE idcompeticion={$alumno['competicion']}"; 
    $competicion = mysqli_fetch_array(mysqli_query($enlace,$query));

    $query = "SELECT * FROM dojo WHERE iddojo={$alumno['iddojo']}";
    $centro = mysqli_fetch_array(mysqli_query($enlace,$query));

    $query = "SELECT * FROM clases WHERE idclase={$alumno['idclase']}";
    $clase = mysqli_fetch_array(mysqli_query($enlace,$query));

    $query = "SELECT d.diaclase, h.hora, u.nombre 
    FROM diasclases d, horasclases h, entrenadores e, usuarios u
    WHERE d.iddiaclase={$clase['iddiaclase']} and
    h.idhoraclase={$clase['idhoraclase']} and
    e.identrenador = {$clase['identrenador']} and
    u.idusuario = e.idusuario"; 
    $datos = mysqli_fetch_array(mysqli_query($enlace,$query));

    $diaclase = $datos['diaclase'];
    $horaclase = $datos['hora'];
    $entrenador = $datos['nombre'];

//asigno los valores a las vbles
    $nombre = $alumno['nombre']." ".$alumno['apellido1']." ".$alumno['apellido2'];
    $idalumno = $alumno['idalumno'];
    $dateborn = $alumno['dateborn'];
    $estado = $alumno['estado'];
    $dni = $alumno['dni'];
    $email = $alumno['email'];
    $telefono = $alumno['etslefono'];
    $dojo = $centro['nombre'];
    $inscrito = $competicion['competicion'];
    $color = $kyu['color'];
    $madre = $alumno['madre'];
    $padre = $alumno['padre'];
    $urgencias1 = $alumno['urgencias1'];
    $urgencias2 = $alumno['urgencias2'];
//calculo categoria
    $hoy = date('Y');
    $fechaentera = strtotime($alumno['dateborn']);
    $anio = date("Y",$fechaentera);                        
    $diferencia = $hoy-$anio;

    if ($diferencia < 9) $categoria = "Prebenjamín";
    else if ( $diferencia<11 ) $categoria = "Benjamín";
    else if ($diferencia<13) $categoria = "Alevín";
    else if ($diferencia<15) $categoría = "Infantil";
    else if ($diferencia<18) $categoria = "Cadete";
    else if ($diferencia<21) $categoria = "Junior";
    else $categoria = "Senior";

//dibujo tabla1 para mostrar los datos del elto

    echo "<div class='form-group'>";
    echo "<br>";
    echo "<br>";
    echo "<table class='table table-striped table-bordered table-hover'>";
        echo "<thead class='table table-striped'>";
            echo "<tr>";
                echo "<th class='table-dark' scope='col'>Alumno</th>";
                echo "<th class='table-dark' scope='col'>Fecha de Nacimiento</th>";
                echo "<th class='table-dark' scope='col'>Email</th>";
                echo "<th class='table-dark' scope='col'>Telefono</th>";
                echo "<th class='table-dark' scope='col'>Nombre Padre</th>";
                echo "<th class='table-dark' scope='col'>Nombre madre</th>";
                echo "<th class='table-dark' scope='col'>Teléfono de Urgencias1</th>";
                echo "<th class='table-dark' scope='col'>Teléfono de Urgencias 2</th>";
            echo "</tr>";  
        echo "</thead>";
        echo "<tbody>";

            echo "<tr >";
                echo " <th scope='row' >{$nombre}</th>";
                echo " <td> {$dateborn}</td>";
                echo " <td class='table-dark'> {$email}</td>";
                echo " <td class='table-dark'>{$telefono} </td>";
                echo " <td class='table-dark'>{$padre} </td>";
                echo " <td class='table-dark'>{$madre} </td>";
                echo " <td>{$urgencias1} </td>";
                echo " <td>{$urgencias2} </td>";
            echo " </tr> ";                       
            
        echo "</tbody>";
    echo "</table>";

//dibujo tabla2 para mostrar los datos del elto        
    echo "<table class='table table-striped table-bordered table-hover'>";
        echo "<thead class='table table-striped'>";
            echo "<tr>";

                echo "<th class='table-dark' scope='col'>Categoría</th>";
                echo "<th class='table-dark' scope='col'>Nivel (Kyu)</th>";
                echo "<th class='table-dark' scope='col'>Competición</th>";
                echo "<th class='table-dark' scope='col'>Dojo</th>";
                echo "<th class='table-dark' scope='col'>Estado</th>";
                
                //echo "<th class='table-dark' scope='col' colspan='3' class='text-center'>Operaciones</th>";
            echo "</tr>";  
        echo "</thead>";
        echo "<tbody>";

            echo "<tr >";
                echo " <th scope='row' >{$categoria}</th>";
                echo " <td> {$color}</td>";
                echo " <td class='table-dark'> {$inscrito}</td>";
                echo " <td class='table-dark'>{$dojo} </td>";
                echo " <td>{$estado} </td>";
            echo " </tr> ";                       

        echo "</tbody>";
    echo "</table>";
//dibijo tabla tres para mostar la clase donde esta y su entrenador
    echo "<table class='table table-striped table-bordered table-hover'>";
        echo "<thead class='table table-striped'>";
            echo "<tr>";

                echo "<th class='table-dark' scope='col'>Días de clase</th>";
                echo "<th class='table-dark' scope='col'>Horario</th>";
                echo "<th class='table-dark' scope='col'>Entrenador</th>";
            echo " </tr> ";
        echo "</thead>";
        echo "<tbody>";

            echo "<tr >";
                echo " <th scope='row' >{$diaclase}</th>";
                echo " <td class='table-dark'> {$horaclase}</td>";
                echo " <td> {$entrenador}</td>";
            echo " </tr> ";                       

        echo "</tbody>";
    echo "</table>";

// obtenemos las faltas del alumno y dibujo tabla de faltas
    $query = "SELECT fechafalta FROM faltas WHERE idalumno={$idalumno}";
    //echo $query."<br>";
    $faltas = mysqli_query($enlace,$query);


   echo "<table class='table table-striped table-bordered table-hover'>";
        echo "<thead class='table table-striped'>";
            echo "<tr>";
                echo "<th class='table-dark' scope='col'>Fechas de faltas a clase</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
            while ($lista = mysqli_fetch_assoc($faltas))
            {
                $falta = $lista['fechafalta'];
                $falta = date('d-m-Y',strtotime($falta));
                echo "<tr>";
                    echo "<td> {$falta} </td>";
                echo "</tr>";
            }
        echo "</tbody>";
    echo "</table>";
    
}
mysqli_close($enlace);
include "pie.php";
?>