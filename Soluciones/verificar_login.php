<?php
session_start();
include 'conexion.php';
$email = mysqli_real_escape_string($conn, $_POST['email']);
$contraseña = md5(mysqli_real_escape_string($conn, $_POST['contrasena']));
$sql = "SELECT * FROM usuarios WHERE email = '$email' AND contrasena = '$contraseña'";
//echo $sql;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['usuario_id'] = $row['id'];
    $_SESSION['usuario_nombre'] = $row['nombre'];
    //echo "Usuario iniciado con éxito...";
    if (isset($_POST['recuerdame'])) {
    setcookie("usuario_id", $row['id'], time() + (86400 * 30), "/"); // 86400 = 1 día
    setcookie("usuario_nombre", $row['nombre'], time() + (86400 * 30), "/");
    $fecha = date('Y-m-d H:i:s');
    $usuario_id = $row['id'];
    $sql = "INSERT INTO accesos (usuario_id, fecha) VALUES ('$usuario_id', '$fecha')"; // Historial de accesos
    mysqli_query($conn, $sql);
    }
    header("Location: galeria.php");
    } else {
    echo "Correo electrónico o contraseña incorrecta.";
    }
mysqli_close($conn);
?>