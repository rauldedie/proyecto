<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de entrada</title>
</head>
<body>
    <H1>Tienes que loguearte</H1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <label for="usuario">Dime nombre de usuario</label>
    <input type="text" name="usuario"><br><br>
    <label for="passwd">Dime la contraseña</label>
    <input type="password" name="passwd"><br><br>
    <input type="submit" name="submit"><br><br>
</form>  
<?php

if (isset($_POST["submit"]))
{
    $servidor="sdb-53.hosting.stackcp.net";
    $usuario="rauldedie";
    $passwd="lince123";
    $bd="bdpruebas-353030355619";

    $enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);

    if(!$enlace)
    {
        echo "Conexion fallida: ".mysqli_connect_error();

    }else
    {
        //HABRIA QUE CONTROLAR LA ENTRADA 
        $usu = mysqli_real_escape_string($enlace,$_POST["usuario"]);
        $pass = mysqli_real_escape_string($enlace,$_POST["passwd"]);
        
        $query = sprintf("SELECT * FROM usuarios WHERE username='%s' AND password='%s'",$usu,$pass);
        $resultado = mysqli_query($enlace,$query);

        //print_r($resultado);

        if ($resultado)
        {
            $fila = mysqli_fetch_array ($resultado);
            //print_r($fila);
            if (mysqli_num_rows($resultado)>0)
            {
                echo "Bienvenido ". $fila["username"];
            }else
            {
                echo "Lo siento, no eres usuario registrado<br>" . mysqli_error($enlace);
            }
            
        }    
        mysqli_close($enlace);     
    }
}


?> 
</body>
</html>