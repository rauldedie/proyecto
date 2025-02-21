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

//compruebo que es administrador quien esta en la sesion

$query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idenuso} and u.tipousuario=t.idtipo";
$fila = mysqli_fetch_array(mysqli_query($enlace,$query));

if (strcmp($fila['tipo'],"administrador")!=0)
{
    echo "<script>window.location='logout.php;</script>";
}
include "cabecera.php";

echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>";
echo"<p><img class='logo' src='logolitho.jpg'></p>";
echo "<label class='navbar-brand'><span class='text-light bg-dark'>GESTION MENSUALIDADES</span></label>
    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
        <ul class='navbar-nav mr-auto'>

            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <span class='text-light bg-dark'>Gestionar Usuarios</span></a>
                <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                    <a class='dropdown-item' href='#'>Nuevo Usuario</a>
                </div>
            </li>

            <li class='nav-item'>
                <a class='navbar-brand' href='gestionarmensualidad.php?mostrar=all&&ord=desc&&campo=nombre&&usuario={$idenuso}'><span class='text-primary'>VOLVER</span></a>
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

if(isset($_GET['idalumno']))
{
    $id = htmlspecialchars(stripslashes($_GET['idalumno']));
    //echo $id."<br>";
    //OBTENGO LOS DATOS DEL ALUMNO

    $query = "SELECT nombre, apellido1, apellido2 FROM alumnos WHERE idalumno={$id}";
    $respuesta = mysqli_fetch_array(mysqli_query($enlace,$query));
    //echo $query."<br>";
    //OBTENGO LAS CUOTAS DEL ALUMNO

    $query2 = "SELECT mes,anio,estado FROM cuotas WHERE idalumno={$id} ORDER BY anio,mes desc";
    $respuesta2 = mysqli_query($enlace,$query2);
    //echo $query2."<br>";
    
    $nombre = $respuesta['nombre']." ".$respuesta['apellido1']." ".$respuesta['apellido2'];

    //dibujo tabla1 para mostrar los datos del elto

    echo "<div class='form-group'>";
    echo "<br>";
    echo "<br>";
    echo "<table class='table table-striped table-bordered table-hover'>";
        echo "<thead class='table table-striped'>";
            echo "<tr>";
                echo "<th class='table-dark' scope='col'>$nombre</th>";
                echo "<th class='table-dark' scope='col'>Mes</th>";
                echo "<th class='table-dark' scope='col'>Año</th>";
                echo "<th class='table-dark' scope='col'>Estado</th>";
            echo "</tr>";  
        echo "</thead>";
        echo "<tbody>";

        while($fila = mysqli_fetch_assoc($respuesta2))
        {
            $mes = $fila['mes'];
            $anio = $fila['anio'];

            if ($fila['estado'] == 0)
            {
                $estado = "Pendiente";
            }else
            {
                $estado = "Pagado";
            }
            echo "<tr>
                    <td>
                    </td>
                    <td class='table-dark'>
                    $mes
                    </td>
                    <td class='table-dark'>
                    $anio
                    </td>
                    <td>
                    $estado
                    </td>
                </tr>";
        }

        echo "</tbody>
    </table>";
    
}
mysqli_close($enlace);
include "pie.php";
?>