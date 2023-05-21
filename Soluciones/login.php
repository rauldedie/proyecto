<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar sesión</title>
</head>
<body>
<form action="verificar_login.php" method="POST">
<label for="email">Correo electrónico:</label>

<input type="email" id="email" name="email" required>
<br>
<label for="contraseña">Contraseña:</label>
<input type="password" id="contrasena" name="contrasena" required>
<br>
<label for="recuerdame">Recuérdame</label>
<input type="checkbox" id="recuerdame" name="recuerdame">
<br>
<input type="submit" value="Iniciar sesión">
</form>
<p><a href="recordar_contraseña.php">¿Olvidaste tu contraseña?</a></p>
</body>
</html>