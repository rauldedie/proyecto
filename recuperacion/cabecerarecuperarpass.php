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
    <H1>RECUPERAR CONTRASEÑA</H1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div>
        <label>Nombre Usuario (*): </label for="nombreusuario"><input name="nombreusuario" class="form" type="text" id="dato0" required placeholder="Nombre de usuario">
        <label class="error" id="error0" ></label><br><br>

        <label >Correo electrónico (*): </label for="mail"><input name="mail" style="display:none" class="form" type="email" id="dato1" required placeholder="Correo electrónico">
        <label class="error" id="error1" style="display:none"></label><br><br>
            
        <label for="">Los campos marcados con (*) son obligatorios</label><br><br>
    </div>
    <label>Introduce el nombre de usuario y el correo que usaste cuando te diste de alta</label>
    <button id="btn_recuperar" type="submit" name="btn_recuperar" onclick="RecuperarPass()">Recuperar contraseña</button><br><br>
    <div id=avisologin></div>

</form> 