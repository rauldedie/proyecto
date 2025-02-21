<?php
session_start();
$tiempo_inactivo = 10 * 60;

if (!isset($_SESSION["usuario_id"])) {
    header("Location: logout.php");
    exit();
}

if (isset($_SESSION['inactivo']) && (time() - $_SESSION['inactivo']) > $tiempo_inactivo) {
    session_unset();
    session_destroy();
    header("Location: logout.php");
    exit();
} else {
    session_regenerate_id(true);
    $_SESSION['inactivo'] = time();
}

$nombreusuario = $_SESSION['usuario_nombre'];
$idenuso = $_SESSION['usuario_id'];
$rolenuso = $_SESSION['usuario_rol'];

echo $nombreusuario;
echo $idenuso;
echo $rolenuso;

include "conexion.php";

function esAdministrador($enlace, $idenuso) {
    $query = "SELECT t.tipousuario tipo FROM usuarios u JOIN tipo_usuario t ON u.tipousuario=t.idtipo WHERE u.idusuario=? AND u.estado='alta'";
    $stmt = mysqli_prepare($enlace, $query);
    mysqli_stmt_bind_param($stmt, "i", $idenuso);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $fila = mysqli_fetch_array($resultado);
    return isset($fila['tipo']) && $fila['tipo'] === "administrador";
}

if (!isset($_GET['usuario']) || $_GET['usuario'] != $idenuso || ($rolenuso == 1 && !esAdministrador($enlace, $idenuso))) {
    header("Location: logout.php");
    exit();
}

$mesActual = date("n");
$anioActual = date("Y");

$query = "SELECT a.idalumno, CONCAT(a.nombre, ' ', a.apellido1, ' ', a.apellido2) AS nombre_completo, c.estado, c.mes, c.anio, c.idcuota
          FROM alumnos a
          LEFT JOIN cuotas c ON a.idalumno = c.idalumno AND c.mes=? AND c.anio=?
          ORDER BY a.nombre ASC";

$stmt = mysqli_prepare($enlace, $query);
mysqli_stmt_bind_param($stmt, "ii", $mesActual, $anioActual);
mysqli_stmt_execute($stmt);
$respuesta = mysqli_stmt_get_result($stmt);

$meses = [
    1 => "ENERO", 2 => "FEBRERO", 3 => "MARZO", 4 => "ABRIL", 5 => "MAYO", 6 => "JUNIO", 
    7 => "JULIO", 8 => "AGOSTO", 9 => "SEPTIEMBRE", 10 => "OCTUBRE", 11 => "NOVIEMBRE", 12 => "DICIEMBRE"
];

include "cabecera.php";
?>

<nav class='navbar navbar-expand-lg navbar-light bg-dark'>
    <p><img class='logo' src='logolitho.jpg'></p>
    <label class='navbar-brand'><span class='text-light bg-dark'>GESTIÓN MENSUALIDADES</span></label>
    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
        <ul class='navbar-nav mr-auto'>
            <li></li>
            <li></li>
            <li class='nav-item'>
                <a class='navbar-brand' href='panelprincipal.php?rol=<?php echo $rolenuso; ?>&usuario=<?php echo $idenuso; ?>'><span class='text-primary'>VOLVER</span></a>
            </li>
            <li class='nav-item'>
                <a class='navbar-brand' href='avisolegal.php'><span class='text-warning'>AVISO LEGAL</span></a>
            </li>
            <li class='nav-item'>
                <a class='navbar-brand' href='logout.php'><span class='text-warning'>SALIR</span></a>
            </li>
        </ul>
    </div>
</nav>

<div class='form-group'>
    <br>
    <label class='nav-item'><h6>Usuario: <?php echo $nombreusuario; ?></h6></label><br>

    <?php
    if(strcmp($rolenuso,"administrador")==0) {
        echo "<a href='cuotasmes.php?usuario={$idenuso}' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> AÑADIR CUOTAS DEL MES</a>";
        echo "<a href='gestionbancaria.php?usuario={$rolenuso}&ord=asc&campo=nombre&mostrar=all' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Comprobacion Cuentas</a>";
    }
    ?>

    <table class='table table-striped table-bordered table-hover'>
        <thead class='table table-striped'>
            <tr>
                <th class='table-dark' scope='col' colspan='3'><a href='gestionarmensualidad.php?dojo=<?php echo isset($iddojo) ? $iddojo : ''; ?>&usuario=<?php echo $idenuso; ?>&ord=<?php echo isset($ord) ? $ord : ''; ?>&campo=nombre' class='btn btn-secondary'>Alumno</a></th>
                <th class='table-dark' scope='col'>mes cuota</th>
                <th class='table-dark' scope='col'>año</th>
                <th class='table-dark' scope='col'>estado</th>
                <th class='table-dark' scope='col' colspan='3' class='text-center'>Operaciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($respuesta)): ?>
            <tr>
                <td colspan="3"><?php echo htmlspecialchars($row['nombre_completo']); ?></td>
                <td class='table-dark'><?php echo isset($meses[$row['mes']]) ? $meses[$row['mes']] : 'Desconocido'; ?></td>
                <td class='table-dark'><?php echo htmlspecialchars($row['anio']); ?></td>
                <td class='table-dark'><?php echo $row['estado'] == 1 ? 'Pagado' : 'Pendiente'; ?></td>
                <td class='table-dark'>
                    <?php if ($row['estado'] == 0): ?>
                        <a href='pagarcuotas.php?idelemento=<?php echo $row['idcuota']; ?>&usuario=<?php echo $idenuso; ?>' class='btn btn-primary'>Pagar Mes</a>
                    <?php else: ?>
                        <?php 
                        $query2 = "SELECT COUNT(*) AS pendientes FROM cuotas WHERE idalumno=? AND estado=0";
                        $stmt2 = mysqli_prepare($enlace, $query2);
                        mysqli_stmt_bind_param($stmt2, "i", $row['idalumno']);
                        mysqli_stmt_execute($stmt2);
                        $resultado2 = mysqli_stmt_get_result($stmt2);
                        $pendientes = mysqli_fetch_assoc($resultado2)['pendientes'];
                        ?>
                        <span><?php echo $pendientes > 0 ? "Este alumno tiene cuotas pendientes, revisa el histórico" : "Este alumno no tiene cuotas pendientes"; ?></span>
                    <?php endif; ?>
                    <a href='historicocuotas.php?idalumno=<?php echo $row['idalumno']; ?>&usuario=<?php echo $idenuso; ?>' class='btn btn-secondary'>Ver Histórico</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
mysqli_free_result($respuesta);
mysqli_close($enlace);
include "pie.php";
?>

