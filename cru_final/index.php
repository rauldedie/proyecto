<?php include ("include/cabecera.php") ?>

<div class="container">
    <h1>GESTIÓN INCIDENCIAS TÉCNICAS IES A. MACHADO</h1>
        
    <div>
        <p><h3>Introduce tu usuario y contraseña para entrar al sistema</h3></p>
        <form action="verificarlogin.php" method="POST">
            <div class="form-group">
                <div>
                    <img class="iconoayuda" id="ayuda" onclick="Ayuda()" src="iconos/ayuda.png" alt="ayuda">
                </div>
        
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
                <input type="checkbox" name="recuerdame" value=1 class="form-check-input" id="AyudaCheck">
                <label class="form-check-label" for="AyudaCheck">Mantener Sesión (la sesion durará 24 horas)</label>
            </div>

            <br><button type="submit" name="login" class="btn btn-primary">Login</button>
            <p><a href="include/recordar_contraseña.php" target="_blank">Recordar contraseña</a></p>               
        </form>
    </div>


    <div>
        <label class="error" id="aviso1" ></label>
    </div> 

    <div>
        <label class="error" id="aviso2" ></label>
    </div>
</div>  

<?php include ("include/pie.php") ?>