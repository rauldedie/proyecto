<?php
include('conexion.php');
if(isset($_POST["email"]) && (!empty($_POST["email"]))){
$email = $_POST["email"];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$email) 
{
   $error .="<p>Dirección invalida de correo, por favor escriba una dirección válida.</p>";
}else
{
   $sel_query = "SELECT * FROM usuarios2 WHERE mail='{$email}'";
   $results = mysqli_query($enlace,$sel_query);
   $row = mysqli_num_rows($results);

   if (mysqli_num_rows($results)==0)
   {
      $error .= "<p>¡No existe un usuario asociado a ese correo!</p>";
   }
  }
   if($error!=""){
   echo "<div class='error'>".$error."</div>
   <br /><a href='javascript:history.go(-1)'>Go Back</a>";
   }else{
   $expFormat = mktime(
   date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
   $expDate = date("Y-m-d H:i:s",$expFormat);
   $key = bin2hex(random_bytes(32));;
   $addKey = substr(md5(uniqid(rand(),1)),3,10);
   $key = $key . $addKey;
    // Insert Temp Table
    $query = "INSERT INTO `password_reset_temp` (`key`, email, expDate) VALUES ('{$key}', '{$email}', '{$expDate}')";
    $resultado = mysqli_query($enlace, $query);
    $output='<p>Estimado usuario,</p>';
    $output.='<p>Por favor haz click en el enlace de abajo para resetear tu contraseña.</p>';
    $output.='<p>-------------------------------------------------------------</p>';
    $output.='<p><a href="http://practicasrdm.es/cambiar_pass.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">http://http://practicasrdm.es/cambiar-pass.php?key='.$key.'&email='.$email.'&action=reset</a></p>';		
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
      <label for="email"><strong>Introduce tu dirección de email:</strong></label><br /><br />
      <input type="email" name="email" class="form-control" placeholder="escriba el correo que tiene registrado en la aplicación" />
      <br /><br />
      <input type="submit" value="Reset Password"/>
   </form>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
</div>
<?php include "pie.php";} ?>