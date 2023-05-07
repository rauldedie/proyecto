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
    <H1>RECUPERACION CONTRASEÑA</H1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div>
        <label>Nombre Usuario (*): </label for="nombreusuario"><input name="nombreusuario" class="form" type="text" id="dato0" required placeholder="Nombre de usuario">
        <label class="error" id="error0" ></label><br><br>

        <label>Contraseña (*): </label for="pass"><input  name="pass" class="form" type="password" id="dato1" required placeholder="Mínimo 8 caracteres"">
        <label class="error" id="error1"></label><br><br>
            
        <label for="">Los campos marcados con (*) son obligatorios</label><br><br>
    </div>
    <button id="btn_recuperacion" type="submit" name="btn_recuperacion" onclick="ValidarLogin()">Recuperar contraseña</button><br><br>
    <div id=avisologin></div><br><br>


</form> 