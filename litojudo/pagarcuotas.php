<?php
session_start();
$tiempo_inactivo = 10 * 60;

if (!array_key_exists("usuario_id", $_SESSION)) {
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
$rol = $rolenuso;
$error = "";
$pagado = 1; // Siempre es 1, así que podemos definirlo directamente

include "conexion.php";

if (isset($_GET['usuario'])) {
    $idusuario = $_GET['usuario']; // No escapamos aquí, lo haremos en la consulta preparada

    // --- ROLES: Consulta preparada para obtener el tipo de usuario ---
    $stmt_rol = mysqli_prepare($enlace, "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario=? AND u.tipousuario=t.idtipo AND u.estado='alta'");
    mysqli_stmt_bind_param($stmt_rol, "i", $idenuso); // "i" indica que $idenuso es un entero
    mysqli_stmt_execute($stmt_rol);
    $resultado_rol = mysqli_stmt_get_result($stmt_rol);

    if ($resultado_rol) {
        $fila = mysqli_fetch_array($resultado_rol);
        if ($idusuario == $idenuso && $rolenuso == 1 && strcmp($fila['tipo'], "administrador") == 0) {
             // Es administrador
        } else {
            header("Location: logout.php");
            exit();
        }
    } else {
        error_log("Error en la consulta de rol: " . mysqli_error($enlace));
        header("Location: logout.php"); // No revelar detalles del error al usuario
        exit();
    }
    mysqli_free_result($resultado_rol);
    mysqli_stmt_close($stmt_rol);

    if (isset($_GET['idelemento'])) {
        $idcuota = $_GET['idelemento'];  // No escapamos aquí, lo haremos en la consulta preparada

        // --- ACTUALIZACIÓN: Consulta preparada para actualizar la cuota ---
        $stmt = mysqli_prepare($enlace, "UPDATE cuotas SET estado = ? WHERE idcuota = ?");
        mysqli_stmt_bind_param($stmt, "ii", $pagado, $idcuota); // "ii" indica que ambos son enteros
        $respuesta = mysqli_stmt_execute($stmt);

        if ($respuesta) {
            $error = "";
            echo "<script type='text/javascript'>alert('¡Cuota pagada correctamente!')</script>";
            header("Location: gestionarmensualidad.php?usuario={$idenuso}&&ord=asc&&mostrar=all");
            exit();
        } else {
            $error = "Error al pagar la cuota: " . mysqli_error($enlace);
            error_log($error); // Registrar el error en el log del servidor
            echo "<script type='text/javascript'>alert('Error al pagar la cuota')</script>"; // Alerta genérica
        }
        mysqli_stmt_close($stmt);

    }
}
mysqli_close($enlace);
?>
