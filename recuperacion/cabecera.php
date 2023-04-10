<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="altausuario.js"></script>
    <link rel="stylesheet" href="altausuario.css">
    <title>Formuario alta de usuario</title>
</head>
<body>
    <H1>ALTA NUEVO USUARIO</H1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div>
        <label>Nombre (*): </label for="nombre"><input class="form" type="text" id="dato0" required placeholder="Nombre">
        <label class="error" name="nombre" id="error0"></label><br><br>

        <label>Apellidos (*): </label for="apellidos" ><input class="form" type="text" id="dato1" required placeholder="Apellidos">
        <label class="error" name="apellidos" id="error1"></label><br><br>

        <label>Correo electrónico (*): </label for="mail"><input class="form" type="email" id="dato2" required placeholder="Correo electrónico">
        <label class="error" name="mail" id="error2"></label><br><br>
                   
        <label>Contraseña (*): </label for="pass1"><input class="form" type="password" id="dato3" required placeholder="Mínimo 8 caracteres"">
        <label class="error" id="error3" name="pass1"></label><br><br>
        
        <label>Repetir Contraseña (*): </label for="pass2"><input class="form" type="password" id="dato4" required placeholder="Mínimo 8 caracteres">
        <label class="error" id="error4" name="pass2" ></label><br><br>

        <label>Nombre Usuario (*): </label for="nombreusuario"><input class="form" type="text" id="dato5" required placeholder="Nombre de usuario">
        <label class="error" name="apellidos" id="error5" name="nombreusuario"></label><br><br>
            
        <label for="">Los campos marcados con (*) son obligatorios</label><br><br>
    </div>
    <button type="submit" name="login" onclick="ValidarFormulario()">Login</button>
    <button type="submit" name="registro" onclick="ValidarFormulario()">Registrar</button><br><br>
    <div id=aviso></div>

</form> 