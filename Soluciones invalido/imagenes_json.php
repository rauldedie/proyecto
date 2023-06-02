<?php
header('Content-Type: application/json');
include 'conexion.php';
$sql = "SELECT * FROM imagenes";
$result = mysqli_query($conn, $sql);
$imagenes = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $imagenes[] = $row;
    }   
}
echo json_encode($imagenes);
mysqli_close($conn);
?>