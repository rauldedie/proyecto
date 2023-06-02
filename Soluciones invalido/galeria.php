<!-- galeria.php -->
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Galería de imágenes</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
.imagen {
margin: 10px;
border: 1px solid #ccc;
padding: 10px;
display: inline-block;
text-align: center;
}
</style>


</head>
<body>
<h1>Galería de imágenes</h1>
<div id="galeria"></div>
<script>
$(document).ready(function() {
$.getJSON('http://recuperacionraul-com.stackstaging.com/ejercicios/imagenes_json.php', function(data) {
    $.each(data, function(index, imagen) {
        $("#galeria").append('<div class="imagen"><h3>' + imagen.nombre + '</h3><img src="' + imagen.url +'" alt="' + imagen.descripcion +'"><p>' + imagen.descripcion +'</p></div>');
    });
    });
    });
</script>
</body>
</html>