<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
header("Location: login.php");
exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cambiar contraseña</title>
</head>
<body>
<h1>Cambiar contraseña</h1>
<form action="actualizar_contraseña.php" method="POST">
<label for="contraseña_actual">Contraseña actual:</label>
<input type="password" id="contrasena_actual" name="contrasena_actual" required>
<br>
<label for="nueva_contraseña">Nueva contraseña:</label>
<input type="password" id="nueva_contrasena" name="nueva_contrasena" required>
<br>
<label for="confirmar_contraseña">Confirmar nueva contraseña:</label>
<input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>

<br>
<input type="submit" value="Cambiar contraseña">
</form>
</body>
</html>