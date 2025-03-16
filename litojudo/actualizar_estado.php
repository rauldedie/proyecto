<?php
session_start();


// Validar que el usuario esté autenticado y sea administrador
/*if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'administrador') {
    header("Location: logout.php");
    exit();
}*/

// Validar y obtener los datos de la URL
if (!isset($_GET['idAlumno']) || !isset($_GET['mes']) || !isset($_GET['anio']) || !isset($_GET['nuevoEstado'])) {
    die("Datos incompletos");
}

include "conexion.php";

$idAlumno = (int)$_GET['idAlumno'];
$mes = (int)$_GET['mes'];
$anio = (int)$_GET['anio'];
$nuevoEstado = (int)$_GET['nuevoEstado'];

// Actualizar el estado de la cuota
$query = "UPDATE cuotas SET estado = ? WHERE idalumno = ? AND mes = ? AND anio = ?";
$stmt = mysqli_prepare($enlace, $query);
mysqli_stmt_bind_param($stmt, "iiii", $nuevoEstado, $idAlumno, $mes, $anio);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    // Redirigir de vuelta a historicocuotas.php
    header("Location: historicocuotas.php?idalumno={$idAlumno}");
} else {
    die("No se pudo actualizar el estado");
}

mysqli_stmt_close($stmt);
mysqli_close($enlace);
?>
