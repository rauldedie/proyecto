<?php include "header.php" ?>
<div>
    <?php
        echo $error;
    ?>
</div>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="form-group">
        <div><img class="iconoayuda" id="ayuda"  src="recursos/ayuda.png" alt="ayuda"></div>
        <label for="usuario">Nombre de Usuario                        
            <input type="text" name="usuario" class="form-control" id="usuario" aria-describedby="AyudaUsuario" placeholder="Escribe tu usuario">
            <label class="error" id="errorusuario" ></label>
            <small id="AyudaUsuario">Este campo es obligatorio.</small>
        </label>
    </div>
    <div class="form-group">
        <label for="Password">Password
            <input type="password" name="password" aria-describedby="AyudaPasswd" class="form-control" id="password" placeholder="Escribe tu Password">
            <label class="error" id="errorpasswd" ></label>
            <small id="AyudaPasswd" >Este campo es obligatorio.</small>
        </label><br>
        <small id="AyudaPasswd2" >Longitud mínima 8 caracteres, ha de contener al menos un numero y una mayúscula.</small>
    </div>
    <div class="form-check">
        <input type="checkbox" name="sesioniniciada" value=1 class="form-check-input" id="AyudaCheck">
        <label class="form-check-label" for="AyudaCheck">Mantener Sesión (la sesion durará 24 horas)</label>
    </div>
   
    <br><button type="submit" name="login" class="btn btn-primary">Login</button>
                    
</form>
<?php include "footer.php" ?>