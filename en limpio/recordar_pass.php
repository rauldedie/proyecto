<?php
include('conexion.php');

if(isset($_POST["usuario"]) && (!empty($_POST["usuario"])))
{
   $usuario = stripcslashes($_POST["usuario"]);
   $usuario = mysqli_real_escape_string($enlace,$usuario);

   if (!$usuario)
   {
      $error .="<p>Nombre de usuario invalido, por favor escriba los datos correctamente.</p>";
   }else
   {
      $sel_query = "SELECT * FROM usuarios2 WHERE nombreusuario='{$usuario}'";
      $results = mysqli_query($enlace,$sel_query);
      $row = mysqli_num_rows($results);

      if (mysqli_num_rows($results)==0)
      {
         $error .= "<p>¡No existe ese usuario!</p>";
      }
   }
   if($error!="")
   {
      echo "<div class='error'>".$error."</div>
      <br /><a href='javascript:history.go(-1)'>Go Back</a>";
   }else
   {
      //calculo token
      $expFormat = mktime(
      date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
      $expDate = date("Y-m-d H:i:s",$expFormat);
      $key = bin2hex(random_bytes(32));;
      $addKey = substr(md5(uniqid(rand(),1)),3,10);
      $key = $key . $addKey;

      // Insert Temp Table
      $query = "INSERT INTO `password_reset_temp` (`key`,expDate,nombreusuario) VALUES ('{$key}', '{$expDate}','{$usuario}')";
      $resultado = mysqli_query($enlace, $query);
      //Averiguo mail del usuario
      $query = "SELECT * FROM usuarios2 WHERE nombreusuario='{$usuario}'";
      $datosusuario = mysqli_fetch_array(mysqli_query($enlace,$query));
      $email = $datosusuario['mail'];

      //preparo datos del mail
      $output='<p>Estimado usuario,</p>';
      $output.='<p>Por favor haz click en el enlace de abajo para resetear tu contraseña.</p>';
      $output.='<p>-------------------------------------------------------------</p>';
      $output.='<p><a href="http://practicasrdm.es/reset_password.php?key='.$key.'&usuario='.$usuario.'&action=reset" target="_blank">http://http://practicasrdm.es/reset_password.php?key='.$key.'&usuario='.$usuario.'&action=reset</a></p>';		
      $output.='<p>-------------------------------------------------------------</p>';
      $output.='<p>Por favor, asegúrate de copiar el enlace completo en tu navegador. El enlace expirará después de un día por razones de seguridad.</p>';
      $output.='<p>Si no solicitaste la contraseña no es necesario que hagas nada.</p>';   	
      $output.='<p>Gracias,</p>';
      $body = $output; 
      $subject = "Recuperación de Password - practicasrdm.es";
      $email_to = $email;
      $fromserver = "noreply@practicasrdm.es"; 
      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      $headers .= 'From: <info@practicasrdm.es>' . "\r\n";
      if (mail($email_to,$subject,$body,$headers))
      {
         echo "<p class='error'>Hemos enviado un email con detalles sobre cómo restablecer la contraseña.</p>";
      }
   }
}else{
include "cabecera.php"; ?>
<h1>Gestión de incidencias (CRUD) - Recordar contraseña. </h1>
<div class="container">
   <form method="post" action="" name="reset"><br /><br />
      <label for="usuario"><strong>Introduce tu usuario:</strong></label><br /><br />
      <input type="text" name="usuario" class="form-control" placeholder="escriba el usuario que tiene registrado en la aplicación" />
      <br /><br />

      <input type="submit" name="resetpass" value="Reset Password"/>
   </form>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
</div>
<?php include "pie.php";} ?>