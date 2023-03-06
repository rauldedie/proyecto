<?php
$directorio = "uploads/";//donde se ubica el archivo. Si no esta en el servidor hay que crearla
$fichero = $target_dir . basename($_FILES["FileToUpLoad"]["name"]);
//ruta donde esta el archivo.
$uploadOk = 1;//indica si la subida es correcta o no. De inicio partimos que es correcta
$tipoArchivo = strtolower(pathinfo($fichero,PATHINFO_EXTENSION));
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
    if (file_exists($fichero)) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }

    // Vemos tamaño del archivo
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Lo siento, tu archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Comprobar que el archvo tiene extension de imagen. Esto tb se puede hacer con un array
    if($tipoArchivo != "jpg" && $tipoArchivo != "png" && $tipoArchivo != "jpeg"
        && $tipoArchivo != "gif" ) {
        echo "Lo siento, solo admite archivos de imagenes JPG, JPEG, PNG & GIF.";
        $uploadOk = 0;
    }

    // Si $uploadOk es 0 es porque hay un error
    if ($uploadOk == 0) {
        echo "Lo siento, tu archivo no se ha subido.";

    } else {//en caso contrario esta todo ok y sube el archivo
        echo "<br>";
        if (move_uploaded_file($_FILES["FileToUpLoad"]["tmp_name"], $fichero)) {
            echo "El archivo ". htmlspecialchars( basename( $_FILES["FileToUpLoad"]["name"])). " se ha subido con exito.";
            echo "<p><img width='20%' src='$fichero'></p>";
        } else {
            echo "Lo siento, ha ocurrido un error en la subida de tu archivo.";
        }
    }
    
}
?>