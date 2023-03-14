<?php

$servidor="sdb-53.hosting.stackcp.net";
$usuario="rauldedie";
$passwd="lince123";
$bd="bdpruebas-353030355619";
    
$enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);
if (!$enlace)
{

    die("Conexion fallida: ".mysqli_connect_error());

}
?>

