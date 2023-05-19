<?php

$servidor="217.76.150.73";
//$servidor="ldk368.piensasolutions.com";
$usuario="qahx080";
$passwd="1smer1l10N";
$bd="qahx080";
    
$enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);

if ($enlace)
{

    die("Conexion fallida: ".mysqli_connect_error());

}
?>