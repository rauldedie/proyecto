<?php
session_start();
session_unset();
session_destroy();
if (isset($_COOKIE['usuario_id']) && isset($_COOKIE['usuario_nombre'])) {
setcookie("usuario_id", "", time() - 3600, "/");
setcookie("usuario_nombre", "", time() - 3600, "/");
}
header("Location: login.php");
?>