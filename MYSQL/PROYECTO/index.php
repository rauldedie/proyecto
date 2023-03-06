<?php
    header("content-type:text/html;charset=utf-8");
    session_start();
    $error="";
    if (array_key_exists("Logout",$_GET))
    {
        //Viene de sesion iniciada
        session_unset();
        setcookie("id","",time()-60*60);
        $_COOKIE["id"]="";
    }else if ((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE['id']))
        {
            header ("Location: gestion.php");
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
            $servidor="sdb-53.hosting.stackcp.net";
            $usuario="rauldedie";
            $passwd="lince123";
            $bd="bdpruebas-353030355619";
    
            $enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);
        
            if(!$enlace)
            {
                echo "Conexion fallida: ".mysqli_connect_error();
    
            }else
            { 
                $usu = mysqli_real_escape_string($enlace,$_POST["usuario"]);
                $pass = mysqli_real_escape_string($enlace,$_POST["password"]);
        
                //$query = sprintf("SELECT * FROM usuarios WHERE username='%s' AND password='%s'",$usu,$pass);
                $query = sprintf("SELECT * FROM tecnicos WHERE usuario='%s'",$usu);
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
                            setcookie("id",$fila["id"],time()+60*60*24*60);
                        }
                        header("Location: gestion.php");
                        exit();
                    }else
                    {
                        echo "Lo siento, no eres usuario registrado<br>" . mysqli_error($enlace);
                    }
            
                }    
                mysqli_close($enlace); 
            }
        }


    }
?>

<?php
    include("header.php");
?>
    <div class="container">
        <h1>Formulario de Login</h1>
        <div id="error">
            <?php
            echo $error;
            ?>

        </div>
        <div>
            <p><h3>Introduce tu usuario y contraseña para entrar al sistema</h3></p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="form-group">
                    <label for="usuario">Nombre de Usuario
                        <input type="text" name="usuario" class="form-control" id="usuario" aria-describedby="AyudaUsuario" placeholder="Escribe tu usuario">
                        <small id="AyudaUsuario">Este campo es obligatorio.</small>
                    </label>
                </div>
                <div class="form-group">
                    <label for="Password">Password
                        <input type="password" name="password" aria-describedby="AyudaPasswd" class="form-control" id="Password" placeholder="Escribe tu Password">
                        <small id="AyudaPasswd" >Este campo es obligatorio.</small>
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="sesioniniciada" value=1 class="form-check-input" id="AyudaCheck">
                    <label class="form-check-label" for="AyudaCheck">Mantener Sesión</label>
                </div>
                    <br><button type="submit" name="submit" class="btn btn-primary">Login</button>

            </form>

        </div>
    </div>

<?php
    include("footer.php");
?>





