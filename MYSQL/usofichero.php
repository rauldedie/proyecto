<?php

include ("conexion2.php");

// Cremos la conexión con el servidor de datos
$conn = new mysqli($servidor, $usuario, $password, $nombrebd);
// Verificamos la conexión con el servidor MySQL
if ($conn->connect_error) {
    die("la conexión ha fallado: " . $conn->connect_error);
}else
{
    $creo_tabla = file_get_contents("creatabla.sql");

    // Condicional PHP que creará la tabla
    if (mysqli_query($conn, $creo_tabla)) {
        // Mostramos mensaje si la tabla ha sido creado correctamente!
            echo "Tabla usuarios creada correctamente";
        } else {
            // Mostramos mensaje si hubo algún error en el proceso de creación
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }
} 



// Cerramos la conexión
$conn->close();

?>