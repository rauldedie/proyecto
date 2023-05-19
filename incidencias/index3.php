<?php
//$servidor="ldk368.piensasolutions.com";
$servidor="217.76.150.73";
$usuario="qahx080";
$passwd="1smer1l10N";
$bd="qahx080";
    
$enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);
if (!$enlace)
{

    die("Conexion fallida: ".mysqli_connect_error());

}
$query = "SELECT * FROM usuarios";
$resultado = mysqli_query($enlace,$query);
if($resultado)
{
    while($fila = mysqli_fetch_assoc ($resultado))
    {
        echo $fila['idusuario']."<br>";
        echo $fila['nombre']."<br>";
        echo $fila['apellidos']."<br>";
        echo $fila['telefono']."<br>";
        echo $fila['mail']."<br>";
        echo $fila['nombreusuario']."<br>";
        echo $fila['pass']."<br>";
        echo $fila['rol']."<br>";
        echo "-------------------------------------------------------------<br>";
    }

}else{
    echo "Lo siento, ha ocurrido un error<br>" . mysqli_error($enlace);
}
mysqli_close($enlace);

?>