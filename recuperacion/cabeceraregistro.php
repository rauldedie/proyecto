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
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div>
        <label>Nombre (*): </label for="nombre"><input name="nombre" class="form" type="text" id="datoreg0" required placeholder="Nombre">
        <label class="error" id="errorReg0"></label><br><br>

        <label>Apellidos (*): </label for="apellidos" ><input name="apellidos" class="form" type="text" id="datoreg1" required placeholder="Apellidos">
        <label class="error" id="errorReg1"></label><br><br>

        <label>Correo electrónico (*): </label for="mail"><input name="mail" class="form" type="email" id="datoreg2" required placeholder="Correo electrónico">
        <label class="error" id="errorReg2"></label><br><br>
                   
        <label>Contraseña (*): </label for="pass1"><input  name="pass1" class="form" type="password" id="datoreg3" required placeholder="Mínimo 8 caracteres"">
        <label class="error" id="errorReg3"></label><br><br>
        
        <label>Repetir Contraseña (*): </label for="pass2"><input name="pass2" class="form" type="password" id="datoreg4" required placeholder="Mínimo 8 caracteres">
        <label class="error" id="errorReg4" ></label><br><br>

        <label>Nombre Usuario (*): </label for="nombreusuario"><input name="nombreusuario" class="form" type="text" id="datoreg5" required placeholder="Nombre de usuario">
        <label class="error" id="errorReg5" ></label><br><br>
            
        <label for="">Los campos marcados con (*) son obligatorios</label><br><br>
    </div>
    <button type="submit" name="registro" onclick="ValidarRegistro()">Registrar</button><br><br>
    <div id=avisoreg></div>

</form> 