<?php
  session_start();
  $error="";
  if(array_key_exists('Logout',$_GET))
  {
    //viene de algun logout. Limpiamos todas las sesiones
    session_unset();
    //evitar que me usen la cookie para recuperar la sesion que he limpiado
    setcookie('id',"",time()-60*60,true,true);
    $_COOKIE['id']="";
    $_COOKIE['rol']="";
  }
  else if ((array_key_exists('id',$_SESSION) AND $_SESSION['id']) OR (array_key_exists('id',$_COOKIE) AND $_COOKIE['id']))
  {
    //ya tendría la sesion iniciada y no hacemos que se autentique de nuevo
    //redireccionamos al panel que el corresponde.
    if ($_COOKIE['rol']=="administrador")
    {
        header("Location:paneladmin.php");
    }
    if ($_COOKIE['rol']=="direccion")
    {
        header("Location:paneldirec.php");
    }
    if ($_COOKIE['rol']=="profesorado")
    {
        header("Location:panelprofe.php");
    }
    
        
  }
  ?>