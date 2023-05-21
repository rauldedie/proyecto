<?php
//session_start();
//include "versesion.php";
include 'conexion.php';
include "encriptar.php";

$usuario = mysqli_real_escape_string($bdcon, $_POST['usuario']);
$pass = mysqli_real_escape_string($bdcon, $_POST['password']);
$pass2 = md5(mysqli_real_escape_string($bdcon, $_POST['password']));

$usuarioc = openssl_encrypt($usuario, $metodo,$key, $options, $vectorcript);

$sql = "SELECT * FROM usuarios WHERE nombreusuario = '$usuarioc'";
//echo $sql;
$resultado = mysqli_query($bdcon, $sql);

if (mysqli_num_rows($result) > 0) 
{
    $row = mysqli_fetch_assoc($resultado);
    $passh = md5(md5($row["idusuario"]).$pass);

    if ($passh == row['idusuario'])
    {
        //echo "Usuario iniciado con éxito...";
        $_SESSION['usuario_id'] = $row['id'];
        $nombre = openssl_decrypt($row['nombre'], $metodo,$key, $options, $vectorcript);
        $rol = openssl_decrypt($row['rol'], $metodo,$key, $options, $vectorcript);
        $_SESSION['usuario_nombre'] = $nombre;
        $_SESSION['rol'] = $rol;

        if (isset($_POST['recuerdame'])) 
        {
            setcookie("usuario_id", $row['id'], time() + 86400,true,true, "/"); // 86400 = 1 día
            setcookie("usuario_nombre", $nombre, time() + 86400,true,true, "/");
            setcookie("rol", $rol, time() + 86400,true,true, "/");
            $fecha = date('Y-m-d H:i:s');
            $idusuario = $row['id'];
            //$sql = sprintf ("INSERT INTO accesos (idusuario, fecha) VALUES ('%i','%s')",$idusuario,$fecha);
            //$sql = "INSERT INTO accesos (idusuario, fecha) VALUES ('$idusuario', '$fecha')"; // Historial de accesos
            //mysqli_query($bdcon, $sql);
        }
        //header("Location:/include/panelgestion.php?rol={$rol}");
        switch ($rol)
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
} else
{
    echo "Correo electrónico o contraseña incorrecta.";
}
mysqli_close($bdcon);
?>