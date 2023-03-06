<?php
header("content-type:text/html;charset=utf-8");
//SOLO CREAMOS LAS COLUMNAS PERO NO LES DAMOS VALORES

//Conectamos con la base de datos

$servidor="sdb-53.hosting.stackcp.net";
$usuario="rauldedie";
$password="lince123";
$bd="bdpruebas-353030355619";

$enlace = mysqli_connect($servidor,$usuario,$password,$bd);

if(!$enlace)
{
    echo "Conexion fallida: ".mysqli_connect_error();

}else
{
    //Generamos las ordendes SQL
    $query1="ALTER TABLE usuarios ADD fullname varchar(50)";
    $query2="ALTER TABLE usuarios ADD mail varchar(50)";

    //insertamos la primera columna
    $resultado1 = mysqli_query($enlace,$query1);
    if ($resultado1)
    {
        //Si todo va bien insertamos la segunda
        $resultado2 = mysqli_query($enlace,$query2);
        if ($resultado2)
        {
            echo "Se han añadido las columnas correcctamente.";

        }else
        {
            echo "Lo siento, ha ocurrido un error en el proceso.<br>" . mysqli_error($enlace);
        }  

    }else
    {
        echo "Lo siento, ha ocurrido un error en el proceso.<br>" . mysqli_error($enlace);
    }   
     
    mysqli_close($enlace);   
}


?>