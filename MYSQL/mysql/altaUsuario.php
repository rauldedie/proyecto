<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formuario alta de usuario</title>
</head>
<body>
    <H1>ALTA NUEVO USUARIO</H1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <label for="usuario">Dime nombre de usuario</label>
    <input type="text" name="usuario"><br><br>
    <label for="passwd">Dime la contraseña</label>
    <input type="password" name="passwd"><br><br>
    <label for="submit">Pincha en Enviar </label>
    <input type="submit" name="submit"><br><br>
</form>  
<?php
header("content-type:text/html;charset=utf-8");
if (isset($_POST["submit"]))
{
    $servidor="sdb-53.hosting.stackcp.net";
    $usuario="rauldedie";
    $password="lince123";
    $bd="bdpruebas-353030355619";

    $enlace = mysqli_connect($servidor,$usuario,$password,$bd);

    if(!$enlace)
    {
        echo "Conexion fallida: ".mysqli_connect_error();

    }else
    {
        //HABRIA QUE CONTROLAR LA ENTRADA 
        $nuevousu = mysqli_real_escape_string($enlace,$_POST["usuario"]);
        $nuevopass = mysqli_real_escape_string($enlace,$_POST["passwd"]);
        
        $query = "insert into usuarios (id,username,password) values ('','".$nuevousu."','".$nuevopass."');";
        $resultado = mysqli_query($enlace,$query);
        if ($resultado)
        {
            echo "Te has dado de alta correcctamente.";
    
        }else
        {
            echo "Lo siento, ha ocurrido un error en el proceso de alta<br>" . mysqli_error($enlace);
        }    
        mysqli_close($enlace);     
    }
    

    
}


?> 
</body>
</html>