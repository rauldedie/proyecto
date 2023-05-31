<?php
session_start();
if (!array_key_exists("usuario_id",$_SESSION)){
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA

include "conexion.php";
$idusuario = $_SESSION['usuario_id'];
$nombreusuario = $_SESSION['usuario_nombre'];
//echo "id=".$idusuario."<br>";
//crea una nueva incidencia 
if(isset($_POST['registro'])) 
{

}

?>

<?php include "cabecera.php"?>
<p class="encabezado"><h1 class="text-center" >Gestión de incidencias (CRUD). Panel Administrador.</h1></p>
<p class="encabezado"><h4 class="text-center">Facilita los datos del nuevo usuario.</h4></p>
<div class="container">  
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div>
            <label for="usuario">Nombre de Usuario                        
                <input type="text" name="usuario" class="form-control" id="usuario" aria-describedby="AyudaUsuario" placeholder="Escribe tu usuario">
                <label class="error" id="errorusuario" > </label>
                <small id="AyudaUsuario">Este campo es obligatorio.</small>
            </label>
        </div>

        <div class="form-group">
            <label for="Password">Password
                <input type="password" name="password" aria-describedby="AyudaPasswd" class="form-control" id="password" placeholder="Escribe tu Password">
                <label class="error" id="errorpasswd" ></label>
                <small id="AyudaPasswd" >Este campo es obligatorio.</small>
            </label><br>
            <small id="AyudaPasswd2" >Longitud mínima 8 caracteres.</small>
        </div>

        <div class="form-group">
            <label for="Password">Repite Password
                <input type="password" name="password2" aria-describedby="AyudaPasswd" class="form-control" id="password2" placeholder="Repite tu Password">
                <label class="error" id="errorpasswd2" ></label>
                <small id="AyudaPasswd" >Este campo es obligatorio.</small>
            </label><br>
            <small id="AyudaPasswd2" >Longitud mínima 8 caracteres.</small>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre
                <input type="text" name="nombre" aria-describedby="Ayudanombre" class="form-control" id="nombre" placeholder="Escribe tu nombre">
                <small id="Ayudanombre" >Este campo es obligatorio.</small>
                <label class="error" id="errornombre" ></label>
            </label>
        </div>

        <div class="form-group">
            <label for="apellidos">Apellidos
                <input type="text" name="apellidos" aria-describedby="AyudaApellidos" class="form-control" id="apellidos" placeholder="Escribe tus apellidos">
                <small id="AyudaApellidos" >Este campo es obligatorio.</small>
                <label class="error" id="errorapellidos" ></label>
            </label>
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico
                <input type="email" name="email" aria-describedby="AyudaEmail" class="form-control" id="email" placeholder="Escribe tu correo electrónico">
                <small id="AyudaEmail" >Este campo es obligatorio.</small>
                <label class="error" id="errormail" ></label>
            </label>
        </div>

        <div class="form-group">
            <label for="telefono">Telefono
                <input type="text" name="telefono" aria-describedby="Ayudatelefono" class="form-control" id="telefono" placeholder="Escribe tu telefono">
                <label class="error" id="errortelefono" ></label>
            </label>
        </div>

        <div class="form-group">
            <label>Rol del usuario.</label>
            <select name="rol" id="rol">
                <option value="administrador">administrador</option>
                <option value="direccion">direccion</option>
                <option value="profesorado" selected>profesorado</option>
            </select>
        </div>
        
        <br><button type="submit" name="registro" class="btn btn-primary">Alta usuario</button>
        <a href="gestionarusuario.php" class="btn btn-primary"> Volver </a>
                          
    </form>
        
</div>
<div>
<?php include "pie.php"?>