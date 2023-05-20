<?php include('header.php');?>

<form method="post" action="" method="post">
    <label for="usuario">Dime nombre de usuario</label>
    <input type="text" name="usuario"><br><br>
    <label for="passwd">Dime la contraseña</label>
    <input type="password" name="passwd"><br><br>
    <input type="submit" name="submit"><br><br>
</form>  
<?php include ('login.php'); ?>
<?php include('pie.php');?>
