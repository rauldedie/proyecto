<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
header("Location: index.php");
exit();
}
include 'conexion.php';
$usuario_id = $_SESSION['usuario_id'];
$contraseña_actual = md5(mysqli_real_escape_string($enlace, $_POST['contrasena_actual']));
$nueva = mysqli_real_escape_string($enlace, $_POST['nueva_contrasena']);
$nueva_contraseña = md5(mysqli_real_escape_string($enlace, $nueva));

$confirmar_contraseña = md5(mysqli_real_escape_string($enlace, $_POST['confirmar_contrasena']));
$sql = "SELECT pass FROM usuarios2 WHERE idusuario = '$usuario_id'";
$result = mysqli_query($enlace, $sql);
$row = mysqli_fetch_assoc($result);
if ($row['contrasena'] == $contraseña_actual) {
if ($nueva_contraseña == $confirmar_contraseña) {
$sql = "UPDATE usuarios2 SET contrasena = '{$nueva}' WHERE idusuario = {$usuario_id}";
if (mysqli_query($enlace, $sql)) {
echo "Contraseña actualizada exitosamente.";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($enlace);
}
} else {
echo "La nueva contraseña y la confirmación no coinciden.";
}
} else {
echo "La contraseña actual es incorrecta.";
}
mysqli_close($enlace);
?>