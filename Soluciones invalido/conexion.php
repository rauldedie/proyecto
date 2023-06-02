<?php
$servername = "sdb-55.hosting.stackcp.net";
$username = "ejercicios-353031316f57";
$password = "wn8wr9h2tu";
$dbname = "ejercicios-353031316f57";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
die("Conexión fallida: " . mysqli_connect_error());
}
?>