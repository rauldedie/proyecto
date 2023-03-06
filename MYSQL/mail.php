<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

//COMO ADJUNTAR UN ARCHIVO AL MAIL????
$correoErr = $asuntoErr = $mensajeErr = $emailErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $Error="";
    if (empty($_POST["correo"]))
    {
        $correoErr = "No puedo enviar un mail a un destino vacio";

    }else if (empty($_POST["asunto"]))
    {
        $asuntoErr = "No es bueno enviar un correo sin asunto";

    }else if (empty($_POST["mensaje"]))
    {
        $mensajeErr = "No es bueno enviar un correo sin texto";

    }else
    {
        $asunto = Validar($_POST["asunto"]);
        $mensaje = Validar($_POST["mensaje"]);
        $cabecera = "From: Papichuli (rauldediego@iawraul.com)";
        $correo = Validar($_POST["correo"]);

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) 
        {
            $emailErr = "Invalid email format";
        }else
        {
            mail($correo,$asunto,$mensaje);
        }       
    }
}

function Validar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<h1>Vamos a enviar un mail</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

    <label for="destinatario">Dime el destinatario: </label>
    <input type="email" name ="correo" placeholder="Email destinatario"> <br><br>
    <?php echo "$correoErr <br><br>"; ?>
    <label for="asunto">Dime el asunto: </label>
    <input type="text" name ="asunto" placeholder="Asunto"> <br><br>
    <?php echo "$asuntoErr <br><br>"; ?>
    <label for="mensaje">Escribe el texto del mensaje: </label> <br>
    <textarea name="mensaje" cols="30" rows="10"></textarea> <br><br>
    <?php echo "$mensajeErr <br><br>"; ?>
    <?php echo "$emailErr <br><br>"; ?>
    
    <input type="submit" name="submit">


</form>

</body>
</html>