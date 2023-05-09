

<?php
    
    include("sesioniniciada.php");
    include("./cabeceras/cabeceraindex.php");

    if (!array_key_exists("id",$_SESSION) || !$_SESSION['id'])
    {
        session_start();
        setcookie("id",$_SESSION['id'],time()+84600,true,true);
        
    }
        
    if (array_key_exists("submit",$_POST))
    //if(isset($_POST["submit"]))
    {       
        if(!$_POST["usuario"])
        {
            $error.="<br>El usuario es requerido.";
        }
        if(!$_POST["password"])
        {
            $error.="<br>El password es requerido.";
        }
        if ($error!="")
        {
            $error="<p>Hubo algun/os error/es en el formulario".$error."</p>";
        }else
        {
            include('conexion.php');
     
            $usu = mysqli_real_escape_string($enlace,$_POST["usuario"]);
            $pass = mysqli_real_escape_string($enlace,$_POST["password"]);
        
            //$query = sprintf("SELECT * FROM usuarios WHERE username='%s' AND password='%s'",$usu,$pass);
            $query = sprintf("SELECT * FROM usuarios WHERE username='%s'",$usu);
            $resultado = mysqli_query($enlace,$query);

            if ($resultado)
            {
                $fila = mysqli_fetch_array ($resultado);
                $passh= md5(md5($fila["id"]).$pass);
                  
                if ($passh==$fila["password"])
                {
                    //echo "Bienvenido ". $fila["usuario"];
                    $_SESSION['id'] = $fila["id"];
                    if ($_POST["sesioniciada"]=='1')
                    {
                        //Tengo que ver si aqui es donde se usa el token
                        setcookie("id",$fila["id"],time()+60*60*24*60);
                    }
                    //header("Location: gestion.php"); NO FUNCIONA
                    exit();
                }else
                {
                    echo "Lo siento, no eres usuario registrado<br>" . mysqli_error($enlace);
                }
            
            }    
            mysqli_close($enlace); 
            
        }
    } 
    include("pie.php");

?>