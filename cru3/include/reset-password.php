<?php
include('conexion.php');

if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) 
&& ($_GET["action"]=="reset") && !isset($_POST["action"]))
{
  $key = $_GET["key"];
  $email = $_GET["email"];
  include "encriptar.php";
  $emailc = openssl_encrypt($email, $metodo,$key, $options, $vectorcript);
  $curDate = date("Y-m-d H:i:s");
  $sql = "SELECT * FROM `password_reset_temp` WHERE `key`='".$key."' and `email`='".$email."';";
  //$sql = sprintf("SELECT * FROM `password_reset_temp` WHERE key='%s' AND email='%s';",$key,$email);
  $query = mysqli_query($bdcon,$sql);
  $row = mysqli_num_rows($query);
  if ($row==""){
  $error .= '<h2>Enlace inválido</h2>
    <p>El enlace es inválido bien porque has reseteado la password y lo usaste o bien porque ha pasado demasiado tiempo</p>
    <p><a href="https://http://practicasrdm.es/include/recordar_pass.php">
    Haz clic aqui</a> para restablecer la contraseña.</p>';
	}else
  {
    $row = mysqli_fetch_assoc($query);
    $expDate = $row['expDate'];
    if ($expDate >= $curDate)
    {
      ?>
      <br />
      <form method="post" action="" name="update">
        <input type="hidden" name="action" value="update" />
        <br /><br />
        <label><strong>Introduce nueva contraseña:</strong></label><br />
        <input type="password" name="pass1" maxlength="15" required />
        <br /><br />
        <label><strong>Repite nueva contraseña:</strong></label><br />
        <input type="password" name="pass2" maxlength="15" required/>
        <br /><br />
        <input type="hidden" name="email" value="<?php echo $email;?>"/>
        <input type="submit" value="Reset Password" />
      </form>
      <?php
    }else
    {
      $error .= "<h2>Enlace expirado</h2><p>El link ha expirado. Estás intentado usar un enlace caducado (solo es válido 24 horas desde que lo pediste).<br /><br /></p>";
    }
  }
  if($error!="")
  {
    echo "<div class='error'>".$error."</div><br />";
  }			
} // isset email key validate end


if(isset($_POST["email"]) && isset($_POST["action"]) &&($_POST["action"]=="update"))
{
  $error="";
  $pass1 = md5(mysqli_real_escape_string($bdcon, $_POST['pass1']));
  $pass2 = md5(mysqli_real_escape_string($bdcon, $_POST['pass2']));
  $email = $_POST["email"];
  $curDate = date("Y-m-d H:i:s");
  if ($pass1!=$pass2)
  {
    $error.= "<p>Las contraseñas no coinciden, asegúrate de introducir la misma en ambos campos.<br /><br /></p>";
  }
  if($error!="")
  {
    echo "<div class='error'>".$error."</div><br />";
  }else
  {

    $pass1 = md5(mysqli_real_escape_string($bdcon, $_POST['pass1']));
    mysqli_query($bdcon, "UPDATE usuarios SET contrasena='".$pass1."' WHERE email='".$emailc."';");

    mysqli_query($bdcon,"DELETE FROM `password_reset_temp` WHERE `email`='".$emailc."';");
	
    echo '<div class="error"><p>¡Enhorabuena! Tu contraseña ha sido actualizada con éxito.</p>
    <p><a href="http://practicasrdm.es/index.php">
    Clic aquí</a> para hacer Login.</p></div><br />';
	}		
}
?>