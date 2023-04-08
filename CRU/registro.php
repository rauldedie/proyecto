<?php
    header("content-type:text/html;charset=utf-8");
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
        if(!$_POST["nombre"])
        {
            $error.="<br>El nombre es requerido.";
        }
        if(!$_POST["email"])
        {
            $error.="<br>El correo electrónico es requerido.";
        }

        if ($error!="")
        {
            $error="<p>Hubo algun/os error/es en el formulario".$error."</p>";
        }else
        {
            
     
            /*$usu = mysqli_real_escape_string($enlace,$_POST["usuario"]);
            $pass = mysqli_real_escape_string($enlace,$_POST["password"]);
            $email = mysqli_real_escape_string($enlace,)*/
            
            //LEO EL FORMULARIO
            
            //BUSCO SI EL USUARIO EXISTE
            //include('conexion.php');
            /*$query = sprintf("SELECT nombre FROM usuarios WHERE username='%s'",$usu);
            $resultado = mysqli_query($enlace,$query);*/

            if (!$resultado)
            {
                //INSERTO EL NUEVO UUARIO
                header("Location: index.php");
                //mysqli_close($enlace); 

                //$fila = mysqli_fetch_array ($resultado);
                //$passh= md5(md5($fila["id"]).$pass);
                  
                /*if ($passh==$fila["password"])
                {
                    //echo "Bienvenido ". $fila["usuario"];
                    $_SESSION['id'] = $fila["id"];
                    if ($_POST["sesioniciada"]=='1')
                    {
                        //Tengo que ver si aqui es donde se usa el token
                        setcookie("id",$fila["id"],time()+60*60*24*60);
                    }*/
                    
                    
            }else
            {
                //SACAR VENTANA DE ALERTA Y LIMPIAR EL FORMULARIO
                echo "Lo siento, el usuario ya existe <br>";
                header("Location: registro.php");
                exit();
            }
            
        }    
            
            
    }
?>

<?php
    include("header.php");
?>
    <div class="container">
        <h1>Formulario de Registro</h1>
        <div id="error">
            <?php
            echo $error;
            ?>

        </div>
        <div>
            <p><h3>RELLENA LOS DATOS PARA UN NUEVO USUARIO</h3></p>
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
                <div class="form-group">
                    <label for="nombre">Nombre
                        <input type="text" name="nombre" aria-describedby="AyudaNombre" class="form-control" id="nombre" placeholder="Escribe tu nombre">
                        <small id="AyudaNombre" >Este campo es obligatorio.</small>
                    </label>
                </div>
                <div class="form-group">
                    <label for="apellidos">Nombre
                        <input type="text" name="apellidos" aria-describedby="AyudaApellidos" class="form-control" id="apellidos" placeholder="Escribe tus apellidos">
                        <small id="AyudaApellidos" >Este campo es obligatorio.</small>
                    </label>
                </div>
                <div class="form-group">
                    <label for="email">Nombre
                        <input type="email" name="email" aria-describedby="AyudaEmail" class="form-control" id="email" placeholder="Escribe tu correo electrónico">
                        <small id="AyudaEmail" >Este campo es obligatorio.</small>
                    </label>
                </div>
                <div class="form-group">
                    <label for="telefono">Nombre
                        <input type="text" name="telefono" aria-describedby="Ayudatelefono" class="form-control" id="tellefono" placeholder="Escribe tu telefono">
                        <small id="AyudaEmail" >Este campo es obligatorio.</small>
                    </label>
                </div>
                <!-- PONER UN DESPLEGABLE PARA EL ROL POR DEFECTO PROFESORADO -->
                <br><button type="submit" name="submit" class="btn btn-primary">Registrar Usuario</button>
                
            </form>

        </div>
    </div>

<?php
    include("footer.php");
?>