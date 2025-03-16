<?php
include "conexion.php";

$idAlumno = (int)$_GET['idAlumno'];

// Obtener datos del alumno
$queryAlumno = "SELECT nombre, apellido1, apellido2 FROM alumnos WHERE idalumno=?";
$stmtAlumno = mysqli_prepare($enlace, $queryAlumno);
mysqli_stmt_bind_param($stmtAlumno, "i", $idAlumno);
mysqli_stmt_execute($stmtAlumno);
$alumno = mysqli_fetch_assoc(mysqli_stmt_get_result($stmtAlumno));

// Obtener cuotas
$queryCuotas = "SELECT mes, anio, estado FROM cuotas WHERE idalumno=? ORDER BY anio DESC, mes DESC";
$stmtCuotas = mysqli_prepare($enlace, $queryCuotas);
mysqli_stmt_bind_param($stmtCuotas, "i", $idAlumno);
mysqli_stmt_execute($stmtCuotas);
$cuotas = mysqli_fetch_all(mysqli_stmt_get_result($stmtCuotas), MYSQLI_ASSOC);

// Generar HTML de la tabla
echo "<table class='table table-striped table-bordered table-hover'>";
echo "<thead><tr>
        <th>Nombre</th>
        <th>Mes</th>
        <th>Año</th>
        <th>Estado</th>
      </tr></thead><tbody>";

foreach ($cuotas as $fila) {
    $mesNombre = DateTime::createFromFormat('!m', $fila['mes'])->format('F');
    $estado = $fila['estado'] ? "Pagado" : "Pendiente";
    $botonTexto = $fila['estado'] ? "Quitar" : "Pagar";

    echo "<tr>
            <td>{$alumno['nombre']} {$alumno['apellido1']} {$alumno['apellido2']}</td>
            <td>$mesNombre</td>
            <td>{$fila['anio']}</td>
            <td>
                <span id='estado-{$fila['mes']}-{$fila['anio']}'>$estado</span>
                <button class='btn btn-primary btn-sm' 
                        onclick='cambiarEstado($idAlumno, {$fila['mes']}, {$fila['anio']}, {$fila['estado']})'>
                    $botonTexto
                </button>
            </td>
          </tr>";
}

echo "</tbody></table>";
mysqli_close($enlace);
?>