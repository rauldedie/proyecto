<?php
header("content-type:text/html;charset=utf-8");

//conectamos con BD
$servidor="sdb-53.hosting.stackcp.net";
$usuario="rauldedie";
$password="lince123";
$bd="bdpruebas-353030355619";

$enlace = mysqli_connect($servidor,$usuario,$password,$bd);

if(!$enlace)
{
    echo "Conexion fallida.";
}else
{
    //creamos la sentencia SQL
    $query="UPDATE usuarios SET username='papichulo' WHERE id=2 LIMIT 1";
    $resultado = mysqli_query($enlace,$query);
    
    if ($resultado)
    {
        echo "El campo username se ha modificado correctamente.";
    }else
    {
        echo "No se ha modificado el campo username. Error: ".mysqli_error($enlace);
    }
    myseqli_close($enlace);
}

?>