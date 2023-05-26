<?php
    include("/include/header.php");
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
    include("/include/footer.php");
?>