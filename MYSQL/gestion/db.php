<?php
/*$host = 'sdb-w.hosting.stackcp.net';   
$user = 'gestion_incidencias-323133eda3';   
$pass = "en97j64z81";   
$database = 'gestion_incidencias-323133eda3';     
$conn = mysqli_connect($host,$user,$pass,$database);   
if (!$conn) {                                             
    die("Conexión fallida con base de datos: " . mysqli_connect_error());     
  }*/
$servidor="sdb-53.hosting.stackcp.net";
$usuario="rauldedie";
$passwd="lince123";
$bd="bdpruebas-353030355619";
$conn = mysqli_connect($servidor,$usuario,$passwd,$bd);
if (!$conn) {                                             
  die("Conexión fallida con base de datos: " . mysqli_connect_error());     
}

?>


