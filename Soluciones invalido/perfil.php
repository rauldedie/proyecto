<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
header("Location: login.php");
exit();
}
include 'conexion.php';
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE id = '$usuario_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perfil de <?php echo $row['nombre']; ?></title>
</head>
<body>
<h1>Perfil de <?php echo $row['nombre']; ?></h1>
<p>Correo electrónico: <?php echo $row['email']; ?></p>
<p><a href="cambiar_contraseña.php">Cambiar contraseña</a></p>
<p><a href="historial_accesos.php">Ver historial de accesos</a></p>
<p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>
<?php

mysqli_close($conn);
?>