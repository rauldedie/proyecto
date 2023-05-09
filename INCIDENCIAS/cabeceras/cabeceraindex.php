<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!--No necesito poner ../estilos/incidencias porque al usar include es como sipegara esta parte en index
    y por tanto no me encuentro dentro de cabeceras-->
    <link rel="stylesheet" href="estilos/incidencias.css">
    <title>Portal de entrada</title>
  </head>
  <body>
  <div class="container">
        <h1>Formulario de Login</h1>
        <div id="error">
            <?php
            echo $error;
            ?>

        </div>
        <div>
            <p><h3>Introduce tu usuario y contraseña para entrar al sistema</h3></p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="form-group">
                    <label for="usuario">Nombre de Usuario
                        <input type="text" name="usuario" class="form-control" id="usuario" aria-describedby="AyudaUsuario" placeholder="Escribe tu usuario">
                        <small id="AyudaUsuario">Este campo es obligatorio.</small>
                    </label>
                </div>
                <div class="form-group">
                    <label for="Password">Password
                        <input type="password" name="password" aria-describedby="AyudaPasswd" class="form-control" id="Password" placeholder="Escribe tu Password">
                        <small id="AyudaPasswd" >Este campo es obligatorio.</small>
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="sesioniniciada" value=1 class="form-check-input" id="AyudaCheck">
                    <label class="form-check-label" for="AyudaCheck">Mantener Sesión</label>
                </div>
                    <br><button type="submit" name="submit" class="btn btn-primary">Login</button>
                    
                    <a href="registro.php" onclick="CambiarURL()" name="registro" target="_blank">Registrar usuario nuevo</a>
            </form>

        </div>
    </div>  
    </body>