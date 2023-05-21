<!-- editar_perfil.php -->
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
<title>Editar perfil</title>
</head>
<body>
<h1>Editar perfil</h1>
<form action="actualizar_perfil.php" method="POST">
<input type="hidden" name="usuario_id" value="<?php echo $row['id']; ?>">
<label for="nombre">Nombre:</label>
<input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>"
required>
<br>
<label for="email">Correo electrónico:</label>
<input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
<br>
<input type="submit" value="Actualizar perfil">
</form>
</body>
</html>
<?php
mysqli_close($conn);
?>