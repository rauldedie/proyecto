<?php
/*session_start();
if (!isset($_SESSION['usuario_id'])) {
header("Location: index.php");
exit();
}*/
include "cabecera.php";?>
<h1>Cambiar contraseña</h1>
<div class="container">
    <form action="actualizar_pass.php" method="POST">
        <label for="contraseña_actual">Contraseña actual:</label>
        <input type="password" id="contrasena_actual" name="contrasena_actual" required class="form-control">
        <br>
        <label for="nueva_contraseña">Nueva contraseña:</label>
        <input type="password" id="nueva_contrasena" name="nueva_contrasena" required class="form-control">
        <br>
        <label for="confirmar_contraseña">Confirmar nueva contraseña:</label>
        <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required class="form-control">

        <br>
        <input type="submit" value="Cambiar contraseña">
    </form>
</div>
<?php include "pie.php";?>