<?php
include 'conexion.php';
$email = mysqli_real_escape_string($conn, $_POST['email']);
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
echo "Se ha enviado un enlace de restablecimiento de contraseña a su correo electrónico.";
// Aquí se enviaría el correo electrónico con el enlace de restablecimiento de contraseña
} else {
echo "No se encontró ninguna cuenta con ese correo electrónico.";
}
mysqli_close($conn);
?>