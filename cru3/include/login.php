<?php 
include 'include/conexion.php';
//include ("include/versesion.php");
$error =" ";

//include "/include/encriptar.php";
//Encriptacion
/*$metodo = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($metodo);
$options = 0;
$vectorcript = '102938475601928374651234567890';
$key = "K1s10p2A";*/

/*$servername = "217.76.150.73";
$username = "qahx080";
$password = "1smer1l10N";
$dbname = "qahx080";

$enlace = mysqli_connect($servername, $username, $password, $dbname);

if (!$enlace) 
{
    die("Conexión fallida: " . mysqli_connect_error());
}*/

session_start();
if (isset($_POST["login"]))
{

    $usuario = mysqli_real_escape_string($enlace, $_POST['usuario']);
    $pass = mysqli_real_escape_string($enlace, $_POST['password']);

    if (empty($usuario))
    {
        $error.= "El campo usuario no puede quedar vacío."."\n";

    }else if (empty($pass))
    {
        $error.="El campo contraseña no puede quedar vacío.\n";
    }else
    {
        //$usuarioc = openssl_encrypt($usuario, $metodo,$key, $options, $vectorcript);

        //$sql = "SELECT * FROM usuarios2 WHERE nombreusuario = '$usuarioc'";
        $sql = "SELECT * FROM usuarios2 WHERE nombreusuario = '$usuario'";
        $resultado = mysqli_query($enlace, $sql);    

        if (mysqli_num_rows($resultado) > 0) 
        {
            $row = mysqli_fetch_array($resultado);

            $passh = md5(md5($row["idusuario"]).$pass);

            if (/*$passh*/$pass == $row['pass'])
            {
                //echo "Usuario iniciado con éxito...";
                
                //$usuario = openssl_decrypt($row['nombreusuario'], $metodo,$key, $options, $vectorcript);
                //$rol = openssl_decrypt($row['rol'], $metodo,$key, $options, $vectorcript);
                $rol = $row['rol'];
                $_SESSION['usuario_id'] = $row['idusuario'];
                $_SESSION['usuario_nombre'] = $usuario;
                $_SESSION['rol'] = $rol;

                /*echo "guardo sesion";
                echo $_SESSION['rol']."<br>";
                echo $_SESSION['usuario_id']."<br>";
                echo $_SESSION['usuario_nombre']."<br>";*/

                if (isset($_POST['recuerdame'])) 
                {//NO FUNCIONAN LAS SESIONES NI LAS COOKIES
                    setcookie("usuario_id", $row['idusuario'], time() + 86400,true,true, "/"); // 86400 = 1 día
                    setcookie("usuario_nombre", $usuario, time() + 86400,true,true, "/");
                    setcookie("rol", $rol, time() + 86400,true,true, "/");
                    $fecha = date('Y-m-d H:i:s');
                    $idusuario = $row['id'];
                    //$sql = sprintf ("INSERT INTO accesos (idusuario, fecha) VALUES ('%i','%d')",$idusuario,$fecha);
                    $sql = "INSERT INTO accesos (idusuario, fecha) VALUES ('$idusuario', '$fecha')"; // Historial de accesos
                    mysqli_query($enlace, $sql);
                }
                
                header("Location:/include/paneladmin.php?rol={$rol}");
                //echo "<script>window.location='/include/paneladmin.php';</scrip>";
                        

            }else
            {
                echo "(1)Usuario o contraseña incorrectos.";
            }       
        }else
        {
            echo "(2)Usuario o contraseña incorrectos.";
        }  
    }


}
mysqli_close($enlace);
?>