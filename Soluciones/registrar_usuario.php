<?php
include 'conexion.php';

$nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$contraseña = md5(mysqli_real_escape_string($conn, $_POST['contrasena']));
$sql = "INSERT INTO usuarios (nombre, email, contrasena) VALUES ('$nombre', '$email',
'$contraseña')";
if (mysqli_query($conn, $sql)) {
echo "Usuario registrado exitosamente.";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
?>