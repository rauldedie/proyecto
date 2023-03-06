<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMagenes en Base de Datos</title>
</head>
<body>
<form name="MiForm" id="MiForm" method="post" action="cargar.php" enctype="multipart/form-data">
    <h4 class="text-center">Seleccione imagen a cargar</h4>
    <div class="form-group">
        <label class="col-sm-2 control-label">Archivos</label>
        <div class="col-sm-8">
            <input type="file" class="form-control" id="image" name="image" multiple>
        </div>
        <button name="submit" class="btn btn-primary">Cargar Imagen</button>
    </div>
</form>

<?php
if(isset($_POST["submit"])){
    $revisar = getimagesize($_FILES["image"]["tmp_name"]);
    if($revisar !== false){
        $image = $_FILES['image']['tmp_name'];
        $imgContenido = addslashes(file_get_contents($image));
        
        //Credenciales Mysql
        include(conexion2.php);
        //Crear conexion con la abse de datos
        $db = new mysqli($servidor, $usuario, $password, $nombrebd);
        
        // Cerciorar la conexion
        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
        }
        
        
        //Insertar imagen en la base de datos
        $insertar = $db->query("INSERT into tablaimagenes (imagenes, creado) VALUES ('$imgContenido', now())");
        // COndicional para verificar la subida del fichero
        if($insertar){
            echo "Archivo Subido Correctamente.";
        }else{
            echo "Ha fallado la subida, reintente nuevamente.";
        } 
        // Si el usuario no selecciona ninguna imagen
    }else{
        echo "Por favor seleccione imagen a subir.";
    }
}
?>
</body>
</html>




