<?php
    session_start();
    $error="";
    if(array_key_exists('Logout',$_GET))
    {
        //viene de algun logout. Limpiamos todas las sesiones
        session_unset();
        //evitar que me usen la cookie para recuperar la sesion que he limpiado
        setcookie("usuario_id", '', time() - 86400,true,true, "/"); // 86400 = 1 día
        setcookie("usuario_nombre", '', time() - 86400,true,true, "/");
        setcookie("rol", '', time() - 86400,true,true, "/");
    }
    else if ((array_key_exists('usuario_id',$_SESSION) AND $_SESSION['usuario_id']) OR (array_key_exists('usuario_id',$_COOKIE) AND $_COOKIE['usuario_id']))
    {
        //ya tendría la sesion iniciada y no hacemos que se autentique de nuevo
        //redireccionamos al panel que el corresponde.
        switch ($_COOKIE['rol'])
        {
            case 'administrador':
                {
                    header("Location: panelgestionadmin.php");
                    break;
                }
            case 'direccion':
                {
                    header("Location: panelgestiondirec.php");
                    break;
                }
            case 'profesorado':
                {
                    header("Location: panelgestionprof.php");
                    break;
                }              
        }
    }

?>