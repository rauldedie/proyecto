<?php
// Inicia la sesión si no está ya iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Use session_unset() para liberar todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Elimina todas las cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000,'/crud3');
    }
}

// Redirige al usuario a ../index.php
header("Location:../index.php");
exit;
?>