<?php
$servername = "217.76.150.73";
$username = "qahx080";
$password = "1smer1l10N";
$dbname = "qahx080";

$enlace = mysqli_connect($servername, $username, $password, $dbname);
if (!$enlace) {
die("Conexión fallida: " . mysqli_connect_error());
}
?>
