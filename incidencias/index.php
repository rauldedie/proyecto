<?php
    
    include("./cuerpos/sesioniniciada.php");
    include("./cabeceras/cabeceraindex.php");
     $error=0;   
    if (array_key_exists("login",$_POST))
    //if(isset($_POST["login"]))
    {       
            include('./cuerpos/conectar.php');
     
            $usu = mysqli_real_escape_string($enlace,$_POST["usuario"]);
            $pass = mysqli_real_escape_string($enlace,$_POST["password"]); 
            $query = sprintf("SELECT * FROM usuarios WHERE nombreusuario='%s'",$usu);
            $resultado = mysqli_query($enlace,$query);
            if ($resultado)
            {
                $fila = mysqli_fetch_array ($resultado);
                $passh= md5(md5($fila["idusuario"]).$pass);
                 
                if ($passh==$fila["pass"])
                {
                    //echo "Bienvenido ". $fila["usuario"];
                    $_SESSION['id'] = md5(md5($fila["id"]).$fila["pass"]);

                    if ($_POST["sesioniciada"]=='1')
                    {
                        setcookie("id",$_SESSION["id"],time()+60*60*24*30,true,true);
                        setcookie("rol",$fila["rol"],time()+60*60*24*30,true,true);
                        setcookie("usuario",$fila["usuario"],time()+60*60*24*30,true,true);

                    }else{
                        setcookie("id",$_SESSION["id"],time()+60*60,true,true);
                        setcookie("rol",$fila["rol"],time()+60*60,true,true);
                        setcookie("usuario",$fila["usuario"],time()+60*60,true,true);
                    }
                    //establecer los distintos tipos de panel de gestion segun roles
                    
                    if($fila["rol"]=="administrador")
                    {
                        include("cuerpos/gestionadmin.php");

                    }else if($fila["rol"]=="direccion")
                    {
                        include("cuerpos/gestioncireccion.php");

                    } else if ($fila["rol"]=="administrador")
                    {
                        include("cuerpos/gestionprofesor.php"); 
                    }

                    exit();

                }else
                {
                    echo "Lo siento, no eres usuario registrado<br>" . mysqli_error($enlace);
                }
            
            }    
            mysqli_close($enlace); 
            
        
    } 
    include("./pie/piegestion.php");

?>