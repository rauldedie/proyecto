

<?php include ("include/login.php") ?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!--No necesito poner ../estilos/incidencias porque al usar include es como si pegara esta parte en index
    y por tanto no me encuentro dentro de cabeceras

    ESTO ERA PARA  LA VENTANA EMERGENTE PERO NO ME SALIA Y CON TODO LO DEMAS NO ME HE PUESTO
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script>
      $(document).ready(function(){
        $('#open').on('mouseover', function(){
          $('#popup').fadeIn('slow');
          $('.popup-overlay').fadeIn('slow');
          $('.popup-overlay').height($(window).height());
        return false;
      });
 
      $('#close').on('click', function(){
        $('#popup').fadeOut('slow');
        $('.popup-overlay').fadeOut('slow');
        return false;
      });
      });
    </script>-->
    <script src="js/incidencias.js"></script>
    <link rel="stylesheet" href="estilos/gestion.css">
    <link rel="stylesheet" href="estilos/incidencias.css">
    <title>Portal de entrada</title>
  </head>
  <body>
