<!-- registro.php -->
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro</title>
</head>
<body>
<form action="registrar_usuario.php" method="POST">
<label for="nombre">Nombre:</label>
<input type="text" id="nombre" name="nombre" required>
<br>
<label for="email">Correo electrónico:</label>
<input type="email" id="email" name="email" required>
<br>
<label for="contraseña">Contraseña:</label>
<input type="password" id="contrasena" name="contrasena" required>
<br>
<input type="submit" value="Registrarse">
</form>
</body>
</html>