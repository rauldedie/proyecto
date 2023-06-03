<?php
include('conexion.php');

if (isset($_GET["key"]) && isset($_GET['usuario']) && isset($_GET["action"]) 
&& ($_GET["action"]=="reset") && !isset($_POST["action"]))
{
  $key = $_GET["key"];
  $usuario = $_GET["usuario"];
  $curDate = date("Y-m-d H:i:s");

  $query = mysqli_query($enlace,"SELECT * FROM `password_reset_temp` WHERE `key`='{$key}' and nombreusuario='{$usuario}';");
  $row = mysqli_num_rows($query);

  if ($row=="")
  {
    $error .= '<h2>Enlace inválido</h2>
    <p>El enlace es inválido bien porque has reseteado la password y lo usaste o bien porque ha pasado demasiado tiempo</p>
    <p><a href="https://http://practicasrdm.es/recordar_pass.php">
    Haz clic aqui</a> para restablecer la contraseña.</p>';
	}else
  {
    $row = mysqli_fetch_assoc($query);
    $expDate = $row['expDate'];
    if ($expDate >= $curDate)
    {
      include "cabecera.php";
      ?>
        
        <h1>Gestión de incidencias (CRUD) - Cambiar contraseña. </h1>
        <div class="container">
          <form method="post" action="" name="update">
            <input type="hidden" name="action" value="update" />
            <br /><br />
            <label><strong>Introduce nueva contraseña:</strong></label><br />
            <input type="password" name="pass1" maxlength="15" required />
            <br /><br />
            <label><strong>Repite nueva contraseña:</strong></label><br />
            <input type="password" name="pass2" maxlength="15" required/>
            <br /><br />
            <input type="hidden" name="usuario" value="<?php echo $usuario;?>"/>

            <input type="submit" value="Reset Password" />
          </form>
        </div>

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


if(isset($_POST['usuario']) && isset($_POST["action"]) && ($_POST["action"]=="update"))
{
  $error="";
  $pass1 = md5(mysqli_real_escape_string($enlace, $_POST['pass1']));
  $pass2 = md5(mysqli_real_escape_string($enlace, $_POST['pass2']));
  $email = $_POST["email"];
  $usuario = $_POST['usuario'];
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
    $pass1 = md5(mysqli_real_escape_string($enlace, $_POST['pass1']));
    $query = "UPDATE usuarios2 SET pass='{$pass1}' WHERE nombreusuario='{$usuario}'";
    //echo $query."<br>";
    mysqli_query($enlace,$query);
    $query = "DELETE FROM `password_reset_temp` WHERE nombreusuario='{$usuario}'";
    //echo $query."<br>";
    mysqli_query($enlace,$query);
    
    echo "<div class='error'><p>¡Enhorabuena! Tu contraseña ha sido actualizada con éxito.</p>
    <p><a href='http://practicasrdm.es/index.php'>
    Clic aquí</a> para hacer Login.</p></div><br />";
  }		
}
include "pie.php";?>