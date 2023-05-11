<?php
    
    //include("sesioniniciada.php");
    include("./cabeceras/cabeceraindex.php");
        
    if (array_key_exists("login",$_POST))
    //if(isset($_POST["login"]))
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
                echo $fila[password];
                echo $fila[username];
                $passh= md5(md5($fila["id"]).$pass);
                  
                /*if ($passh==$fila[password])
                {
                    //echo "Bienvenido ". $fila["usuario"];
                    session_start();
                    $_SESSION['id'] = $fila["id"];

                    if ($_POST["sesioniciada"]=='1')
                    {
                        //Tengo que ver si aqui es donde se usa el token
                        setcookie("id",$fila["id"],time()+60*60*24*30,true,true);
                        setcookie("rol",$fila["rol"],time()+60*60*24*30,true,true);
                        setcookie("usuario",$fila["usuario"],time()+60*60*24*30,true,true);

                    }else{
                        setcookie("id",$fila["id"],time()+60*60,true,true);
                        setcookie("rol",$fila["rol"],time()+60*60,true,true);
                        setcookie("usuario",$fila["usuario"],time()+60*60,true,true);
                    }
                    
                    include(gestion.php);                   
                    exit();

                }else
                {
                    echo "Lo siento, no eres usuario registrado<br>" . mysqli_error($enlace);
                }*/
            
            }    
            mysqli_close($enlace); 
            
        
    } 
    include("pie.php");

?>