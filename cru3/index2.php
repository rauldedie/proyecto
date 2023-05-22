<?php
    include "bd.php";
    if ((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE['id'])){
        // Si ya tenia la sesion iniciada
        echo "<script>window.location='home.php';</script>";
    }
    session_start();
    if (isset($_POST["submit"])) {
        $usu = mysqli_real_escape_string($enlace,$_POST["usuario"]);
        $pass2 = mysqli_real_escape_string($enlace,$_POST["contrasena"]);
        $pass = md5($pass2);
        $query = sprintf("SELECT * FROM usuarios WHERE user='%s' AND passwd='%s'",$usu,$pass);
        $resultado = mysqli_query($enlace,$query);
        if ($resultado) {
            $fila = mysqli_fetch_array ($resultado);
            if (mysqli_num_rows($resultado)>0) {
                $_SESSION['id'] = "1";
                if ($_POST['mantener']=='1'){
                    setcookie("id",$fila['id'],time()+60*60*24*365);
                }
                echo "<script>window.location='home.php';</script>";
            }
            else {
                echo "Lo siento, no eres usuario registrado<br>" . mysqli_error($enlace);
                mysqli_close($enlace);
            }
        }
        
    }
    include "header.php";
?>
    <form action="index.php" method="post">
        <div class="area" >
            <ul class="circles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div class="context">
                <h2>Portal de Incidencias</h2><br>
                <p>Usuario: <br><input type="text" name="usuario"></p><br>
                <p>Contraseña: <br><input type="password" name="contrasena"><br><br><button class="css-button-arrow--yellow" name="submit">Entrar</button></p><br>
                <br><br><br>
                <p>Recordar Usuario <input type="checkbox" name="mantener" value="1"></p>
            </div>
        </div >
    </form>
<?php
    include "footer.php";
?>