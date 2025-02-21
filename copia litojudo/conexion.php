<?php
$servername = "217.76.150.73";
$username = "qahz716";
$password = "k@s10p2a1973";
$dbname = "qahz716";

$enlace = mysqli_connect($servername, $username, $password, $dbname);
if (!$enlace) {
die("Conexión fallida: " . mysqli_connect_error());
}
?>
