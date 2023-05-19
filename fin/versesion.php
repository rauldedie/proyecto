<?php
  session_start();
  $error="";
  if(array_key_exists('Logout',$_GET))
  {
    //viene de la pagina sesion iniciada. Limpiamos todas las sesiones
    session_unset();
    //evitar que me usen la cookie para recuperar la sesion que he limpiado
    setcookie('id',"",time()-60*60,true,true);
    $_COOKIE['id']="";
    $_COOKIE['rol']="";
  }
  else if ((array_key_exists('id',$_SESSION) AND $_SESSION['id']) OR (array_key_exists('id',$_COOKIE) AND $_COOKIE['id']))
  {
    //ya tendría la sesion iniciada y no hacemos que se autentique de nuevo
    header("Location:include/sesioniniciada.php");
        
  }
  ?>