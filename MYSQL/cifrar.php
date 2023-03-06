<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encriptar Texto</title>
</head>
<body>

<?php

if(isset($_POST["submit"]))
{
    $texto = ValidarInput($texto);    
    $resultado = crypt($texto,md5(bin2hex(random_bytes(5))));
}

function ValidarInput($datos){

    if ($datos == "")
    {
        $datos = "Este campo es obligatorio";

    }else 
    {
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos);
        $datos = "";
        
    } 
    return ($datos);

}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <label for="texto">
        <textarea name="texto" id="texto" cols="30" rows="10"></textarea>
    </label><br><br>
    <input type="submit" name="submit">
    <div>
        <p><h2>Texto encriptado</h2></p>
        <span> * <?php echo $resultado;?></span><br><br>
    </div>
</form>

</body>
</html>