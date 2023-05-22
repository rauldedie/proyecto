<?php include('cabecera.php');?>

<!--<form action="enviar_recordatorio.php" method="POST">
<label for="email">Correo electrónico:</label>
<input type="email" id="email" name="email" required>
<br>
<input type="submit" onclick="VerificarMail()" value="Enviar recordatorio">
</form>-->

<div class="container">
    <h1>GESTIÓN INCIDENCIAS TÉCNICAS IES A. MACHADO</h1>
        
    <div>
        <p><h3>Introduce tu usuario y contraseña para entrar al sistema</h3></p>
        <form action="enviar_recordatorio.php" method="POST">
            <div class="form-group">
                <div>
                    <img class="iconoayuda" id="ayuda" onclick="AyudaRecuperarPass()" src="recursos/ayuda.png" alt="ayuda">
                </div>
        
                <label for="email">Correo electrónico                        
                    <input type="email" name="email" class="form-control" id="email" aria-describedby="AyudaUsuario" required>
                    <label class="error" id="erroremail" ></label>
                    <small id="AyudaUsuario">Este campo es obligatorio.</small>
                </label>
            </div>

            <br><button type="submit" name="recordar" class="btn btn-primary">Enviar recordatorio</button>               
        </form>
    </div>


    <div>
        <label class="error" id="aviso1" ></label>
    </div> 

    <div>
        <label class="error" id="aviso2" ></label>
    </div>
</div>  

<?php include 'pie.php' ?>