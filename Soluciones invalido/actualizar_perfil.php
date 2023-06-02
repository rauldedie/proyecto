<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
header("Location: login.php");
exit();
}
include 'conexion.php';
$usuario_id = mysqli_real_escape_string($conn, $_POST['usuario_id']);
$nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$sql = "UPDATE usuarios SET nombre = '$nombre', email = '$email' WHERE id = '$usuario_id'";
if (mysqli_query($conn, $sql)) {
$_SESSION['usuario_nombre'] = $nombre;
echo "Perfil actualizado exitosamente.";
header("Location: perfil.php");
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>