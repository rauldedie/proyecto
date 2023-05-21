<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
header("Location: login.php");
exit();
}
include 'conexion.php';
$usuario_id = $_SESSION['usuario_id'];
$contraseña_actual = md5(mysqli_real_escape_string($conn, $_POST['contrasena_actual']));
$nueva_contraseña = md5(mysqli_real_escape_string($conn, $_POST['nueva_contrasena']));
$confirmar_contraseña = md5(mysqli_real_escape_string($conn, $_POST['confirmar_contrasena']));
$sql = "SELECT contrasena FROM usuarios WHERE id = '$usuario_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row['contrasena'] == $contraseña_actual) {
if ($nueva_contraseña == $confirmar_contraseña) {
$sql = "UPDATE usuarios SET contrasena = '$nueva_contraseña' WHERE id =
'$usuario_id'";
if (mysqli_query($conn, $sql)) {
echo "Contraseña actualizada exitosamente.";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
} else {
echo "La nueva contraseña y la confirmación no coinciden.";
}
} else {
echo "La contraseña actual es incorrecta.";
}
mysqli_close($conn);
?>