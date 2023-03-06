<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir una imagen</title>
</head>
<body>

    <!--Nos aseguramos que el file_uploads = on 
en el php.ini, para saber donde esta miramos el phpinfo() 	/etc/php/7.4/apache2 -->

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="FileToUpLoad" id="FileToUpLoad">
  <input type="submit" value="Subir Imagen" name="submit">
</form>

<?php
$target_dir = "uploads/";//donde se ubica el archivo. Si no esta en el servidor hay que crearla
$target_file = $target_dir . basename($_FILES["FileToUpLoad"]["name"]);
//ruta donde esta el archivo.
$uploadOk = 1;//indica si la subida es correcta o no. De inicio partimos que es correcta
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//mira la xtension del archivo tendremosque ver si es una imagen



if(isset($_POST["submit"])) {
    
    //comprobamos que la imagen es una imagen y no una imagen falsa
    $check = getimagesize($_FILES["FileToUpLoad"]["tmp_name"]);
    if($check !== false) {
        echo "El archivo es una imagen - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;//la subida no ha sido correcta
    }

    // Vemos si la imagen ya existe
    if (file_exists($target_file)) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }

    // Vemos tamaño del archivo
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Comprobar que el archvo tiene extension de imagen. Esto tb se puede hacer con un array
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Lo siento, solo admite archivos de imagenes JPG, JPEG, PNG & GIF.";
        $uploadOk = 0;
    }

    // Si $uploadOk es 0 es porque hay un error
    if ($uploadOk == 0) {
        echo "Lo siento, tu archivo no se ha subido.";

    } else {//en caso contrario esta todo ok y sube el archivo
        echo "<br>";
        if (move_uploaded_file($_FILES["FileToUpLoad"]["tmp_name"], $target_file)) {
            echo "El archivo ". htmlspecialchars( basename( $_FILES["FileToUpLoad"]["name"])). " se ha subido con exito.";
            echo "<p><img width='20%' src='$target_file'></p>";
        } else {
            echo "Lo siento, ha ocurrido un error en la subida de tu archivo.";
        }
    }
    
}
?>
</body>
</html>