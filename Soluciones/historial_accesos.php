<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
header("Location: login.php");

exit();
}
include 'conexion.php';
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT fecha FROM accesos WHERE usuario_id = '$usuario_id' ORDER BY fecha DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Historial de accesos</title>
</head>
<body>
<h1>Historial de accesos</h1>
<table>
<thead>
<tr>
<th>Fecha</th>
</tr>
</thead>
<tbody>
<?php
while ($row = mysqli_fetch_assoc($result)) {
echo "<tr><td>" . $row['fecha'] . "</td></tr>";
}
?>
</tbody>
</table>
</body>
</html>
<?php
mysqli_close($conn);