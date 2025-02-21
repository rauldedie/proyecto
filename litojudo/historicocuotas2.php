<?php
session_start();
setlocale(LC_ALL, 'es_ES.UTF-8');
$tiempo_inactivo = 10 * 60;
if (!array_key_exists("usuario_id",$_SESSION)){
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
    exit();
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

$nombreusuario = htmlspecialchars($_SESSION['usuario_nombre'], ENT_QUOTES, 'UTF-8');
$idenuso = (int)$_SESSION['usuario_id'];
$rolenuso = htmlspecialchars($_SESSION['usuario_rol'], ENT_QUOTES, 'UTF-8');

include "conexion.php"; 

// Compruebo que es administrador quien está en la sesión
$query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario=? AND u.tipousuario=t.idtipo";
$stmt = mysqli_prepare($enlace, $query);
mysqli_stmt_bind_param($stmt, "i", $idenuso);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($enlace));
}

$fila = mysqli_fetch_array($resultado);
mysqli_free_result($resultado);

if (!$fila || strcmp($fila['tipo'], "administrador") != 0) {
    echo "<script>window.location='logout.php';</script>";
    exit();
}
//hasta aqui lo nuevo

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
    //OBTENGO EL ID DEL ALUMNO DESDE LA URL

    $id = (int)$_GET['idalumno'];

    //OBTENGO LOS DATOS DEL ALUMNO DESDE LA BASE DE DATOS
    
    $query = "SELECT nombre, apellido1, apellido2 FROM alumnos WHERE idalumno=?";
    $stmt = mysqli_prepare($enlace, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $respuesta = mysqli_stmt_get_result($stmt);

    if (!$respuesta) {
        die("Error en la consulta de alumnos: " . mysqli_error($enlace));
    }

    $alumno = mysqli_fetch_array($respuesta);
    mysqli_free_result($respuesta);
    
    //OBTENGO LAS CUOTAS DEL ALUMNO DESDE LA BASE DE DATOS

    $query2 = "SELECT mes, anio, estado FROM cuotas WHERE idalumno=? ORDER BY anio DESC, mes DESC";
    $stmt2 = mysqli_prepare($enlace, $query2);
    mysqli_stmt_bind_param($stmt2, "i", $id);
    mysqli_stmt_execute($stmt2);
    $respuesta2 = mysqli_stmt_get_result($stmt2);

    if (!$respuesta2) {
        die("Error en la consulta de cuotas: " . mysqli_error($enlace));
    }

    //OBTENGO EL NOMBRE DEL ALUMNO DESDE LA BASE DE DATOS

    $nombre = htmlspecialchars($alumno['nombre'] . " " . $alumno['apellido1'] . " " . $alumno['apellido2'], ENT_QUOTES, 'UTF-8');

    //dibujo tabla para mostrar los datos del elto alumno y sus cuotas

        echo "<div class='form-group'>";
        echo "<br><br>";
        echo "<table class='table table-striped table-bordered table-hover'>";
        echo "<thead class='table table-striped'>";
        echo "<tr>";
        echo "<th class='table-dark' scope='col'>Nombre</th>";
        echo "<th class='table-dark' scope='col'>Mes</th>";
        echo "<th class='table-dark' scope='col'>Año</th>";
        echo "<th class='table-dark' scope='col'>Estado</th>";
        echo "</tr>";  
        echo "</thead>";
        echo "<tbody>";

        while($fila = mysqli_fetch_assoc($respuesta2))
        {
            // Línea de depuración
            // var_dump($fila['estado']);

           // Convertir el mes a un número entero y obtener el nombre del mes
            
            $mesNumero = intval($fila['mes']);
            
           // Usar switch para obtener el nombre del mes
            switch($mesNumero) {
                case 1: $mesNombre = "Enero"; break;
                case 2: $mesNombre = "Febrero"; break;
                case 3: $mesNombre = "Marzo"; break;
                case 4: $mesNombre = "Abril"; break;
                case 5: $mesNombre = "Mayo"; break;
                case 6: $mesNombre = "Junio"; break;
                case 7: $mesNombre = "Julio"; break;
                case 8: $mesNombre = "Agosto"; break;
                case 9: $mesNombre = "Septiembre"; break;
                case 10: $mesNombre = "Octubre"; break;
                case 11: $mesNombre = "Noviembre"; break;
                case 12: $mesNombre = "Diciembre"; break;
                default: $mesNombre = "Desconocido";
            }
            $anio = htmlspecialchars($fila['anio'], ENT_QUOTES, 'UTF-8');

            $estado = ($fila['estado'] == 1) ? "Pagado" : "Pendiente";

            // Línea de depuración
            // echo "Debug - Estado: " . $estado . "<br>";
            $mesNombre = "ENERO";
            //echo "Debug - Mes número: {$mesNumero}, Mes nombre: {$mesNombre}<br>";
            echo "<tr>

                    <td>
                    $nombre
                    </td>
                    <td class='table-dark'>
                    " . htmlspecialchars($mesNombre, ENT_QUOTES, 'UTF-8') . "
                    echo 'Debug - Mes número: {$mesNumero}, Mes nombre: {$mesNombre}<br>';
                    </td>
                    <td class='table-dark'>
                    $anio
                    </td>
                    <td>" . htmlspecialchars($estado, ENT_QUOTES, 'UTF-8') . "</td>
              </tr>";
        }

        echo "</tbody>
    </table>";
    mysqli_free_result($respuesta2);
    
}
mysqli_close($enlace);
include "pie.php";

?>