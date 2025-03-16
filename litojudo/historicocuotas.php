<?php
session_start();
setlocale(LC_ALL, 'es_ES.UTF-8');

// Configuración tiempo de inactividad
$tiempo_inactivo = 10 * 60;

// Verificamos si la sesión está iniciada
if (!array_key_exists("usuario_id", $_SESSION)) {
    // Si no tenía la sesión iniciada
    header("Location: logout.php");
    exit();
}

// Verificar inactividad
if (isset($_SESSION['inactivo']) && (time() - $_SESSION['inactivo']) > $tiempo_inactivo) {
    session_unset();
    session_destroy();

    // Redireccionamos el usuario a logout
    header("Location: logout.php");
    exit();
} else {
    // Regenera nueva sesión y fija de nuevo el tiempo
    session_regenerate_id(true);
    $_SESSION['inactivo'] = time();
}

// Obtener datos del usuario desde la sesión
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

include "cabecera.php";

echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>";
echo "<p><img class='logo' src='logolitho.jpg'></p>";
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

// Procesar el ID del alumno desde la URL
if (isset($_GET['idalumno'])) {
    $id = (int)$_GET['idalumno'];

    // Obtener los datos del alumno desde la base de datos
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

    // Obtener las cuotas del alumno desde la base de datos
    $query2 = "SELECT mes, anio, estado FROM cuotas WHERE idalumno=? ORDER BY anio DESC, mes DESC";
    $stmt2 = mysqli_prepare($enlace, $query2);
    mysqli_stmt_bind_param($stmt2, "i", $id);
    mysqli_stmt_execute($stmt2);
    $respuesta2 = mysqli_stmt_get_result($stmt2);

    if (!$respuesta2) {
        die("Error en la consulta de cuotas: " . mysqli_error($enlace));
    }

    // Obtener el nombre del alumno desde la base de datos
    $nombre = htmlspecialchars($alumno['nombre'] . " " . $alumno['apellido1'] . " " . $alumno['apellido2'], ENT_QUOTES, 'UTF-8');

    // Dibujar tabla para mostrar los datos del alumno y sus cuotas
    echo "<div class='form-group'>
        <br><br>
        <table class='table table-striped table-bordered table-hover'>
        <thead class='table table-striped'>
        <tr>
        <th class='table-dark' scope='col'>Nombre</th>
        <th class='table-dark' scope='col'>Mes</th>
        <th class='table-dark' scope='col'>Año</th>
        <th class='table-dark' scope='col'>Estado</th>
        </tr>  
        </thead>
        <tbody>";

    while ($fila = mysqli_fetch_assoc($respuesta2)) {
        $mesNumero = intval($fila['mes']);
        //$mesNombre = date('F', mktime(0, 0, 0, $mesNumero, 10)); // Obtener el nombre del mes
        //$mesNombre = strftime('%B', mktime(0, 0, 0, $mesNumero, 10)); // Obtener el nombre del mes en español

        // Obtener el nombre del mes en español usando IntlDateFormatter
        $formatter = new IntlDateFormatter(
            'es_ES', // Configuración regional (español de España)
            IntlDateFormatter::NONE, // No mostrar fecha
            IntlDateFormatter::NONE, // No mostrar hora
            null, // Zona horaria predeterminada
            null, // Calendario predeterminado
            'MMMM' // Formato: nombre completo del mes
        );
        $mesNombre = $formatter->format(mktime(0, 0, 0, $mesNumero, 10)); // Obtener el nombre del mes en español
        $mesNombre = strtoupper($mesNombre);
        $anio = htmlspecialchars($fila['anio'], ENT_QUOTES, 'UTF-8');
        $estado = ($fila['estado'] == 1) ? "Pagado" : "Pendiente";
        $botonTexto = ($fila['estado'] == 1) ? "Quitar" : "Pagar";
        $nuevoEstado = ($fila['estado'] == 1) ? 0 : 1; // Estado opuesto al actual

        echo "<tr>
                <td>{$nombre}</td>
                <td class='table-dark'>" . htmlspecialchars($mesNombre, ENT_QUOTES, 'UTF-8') . "</td>
                <td class='table-dark'>{$anio}</td>
                <td>
                    <span>{$estado}</span>
                    <a href='actualizar_estado.php?idAlumno={$id}&mes={$fila['mes']}&anio={$fila['anio']}&nuevoEstado={$nuevoEstado}' class='btn btn-primary btn-sm ml-2'>{$botonTexto}</a>
                </td>
              </tr>";
    }

    echo "</tbody>
        </table>
        </div>";

    mysqli_free_result($respuesta2);
}

mysqli_close($enlace);
include "pie.php";
?>
