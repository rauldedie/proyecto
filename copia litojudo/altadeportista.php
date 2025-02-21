<?php
session_start();
$tiempo_inactivo = 10 * 60;
if (!array_key_exists("usuario_id",$_SESSION))
{
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA
if (isset($_SESSION['inactivo']) && (time() - $_SESSION['inactivo']) > $tiempo_inactivo) 
{
    session_unset();
    session_destroy();

    //Redireccionamos el usuario a logout
    header("Location: logout.php");
    exit();
}else
{
    // Regenera nueva sesion y fija de nuevo el tiempo
    session_regenerate_id(true);

    // Update the last timestamp
    $_SESSION['inactivo'] = time();
}
$rolenuso = $_SESSION['usuario_rol'];
$idusuario = $_SESSION['usuario_id'];
$nombreusuario = $_SESSION['usuario_nombre'];
if(isset($_GET['dojo']))
{
    $iddojo = htmlspecialchars(stripslashes($_GET['dojo']));

}else $idojo = 1;

include "conexion.php";

$query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idusuario} and u.tipousuario=t.idtipo";
$fila = mysqli_fetch_array(mysqli_query($enlace,$query));

if (strcmp($fila['tipo'],"administrador")!=0)
{
    echo "<script>window.location='logout.php;</script>";
}

if(isset($_POST['nuevoalumno'])) 
{
    $nombre = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['nombre']))));
    $apellido1 = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['apellido1']))));
    $apellido2 = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['apellido2']))));
    $dateborn = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['dateborn']))));

    $email = strtolower(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['email']))));
    //$email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    $telefono = htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['telefono'])));
    $kyu = htmlspecialchars(mysqli_real_escape_string($enlace,stripcslashes($_POST['kyu'])));
    $iddojo = htmlspecialchars(mysqli_real_escape_string($enlace,stripcslashes($_POST['dojo'])));

    $competicion = htmlspecialchars(mysqli_real_escape_string($enlace,stripcslashes($_POST['competicion'])));
    
    $urgencias1 = htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['urgencias1'])));
    $urgencias2 = htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['urgencias2'])));
    $padre = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['padre']))));
    $madre = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['madre']))));
    $dni = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['dni']))));
    $diaclase = htmlspecialchars(mysqli_real_escape_string($enlace,stripcslashes($_POST['diaclase'])));
    $horaclase = htmlspecialchars(mysqli_real_escape_string($enlace,stripcslashes($_POST['horaclase'])));
    $estado = "alta";
    $error = "";

    $cuenta1 = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['ccc1']))));
    $cuenta2 = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['ccc2']))));
    $cuenta3 = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['ccc3']))));
    $cuenta4 = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['ccc4']))));
    $cuenta5 = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['ccc5']))));
    $cuenta = $cuenta1.$cuenta2.$cuenta3.$cuenta4.$cuenta5;

    /*if (!empty($cuenta))
    {
        if (!checkIBAN($cuenta))
        {
            $error.="cuenta incorrecta";
        }
    } */
    echo $nombre;

    //busco que no exista ya en la BD
    $query = "SELECT nombre,apellido1,apellido2,estado FROM alumnos 
    WHERE nombre = '{$nombre}' and apellido1 = '{$apellido1}' and apellido2 = '{$apellido2}'";
    //echo $query;
    $resultado = mysqli_query($enlace,$query);
    
    if(mysqli_num_rows($resultado)>0)
    {
        $fila = mysqli_fetch_array($resultado);
        if(strcmp($fila['estado'],"baja")==0)
        {
            echo "<script type='text/javascript'>alert('Este alumno apararece de baja, puedes pasarlo a estado activo en reactivar usuario')</script>";  
        }else
        {
            echo "<script type='text/javascript'>alert('Este alumno ya esta dado de alta')</script>";  
        } 
        
    }else
    {
        
        //EL usuario no existe encriptamos e insertamos los datos en la tabla alumnos";
        $query = "INSERT INTO alumnos (nombre,apellido1,apellido2,dateborn,urgencias1,urgencias2,padre,madre,idnivel,competicion,iddojo,telefono,email,dni,estado,cuenta) 
        VALUES ('{$nombre}','{$apellido1}','{$apellido2}','{$dateborn}','{$urgencias1}','{$urgencias2}','{$padre}','{$madre}',{$kyu},{$competicion},{$iddojo},'{$telefono}','{$email}','{$dni}','{$estado}','{$cuenta}')";
        //echo $query."<br>";
        $resultado = mysqli_query($enlace,$query);

        $ultimo_id = mysqli_insert_id($enlace);
        //echo $ultimo_id;

        if($resultado)
        {
            $query = "SELECT idclase FROM clases 
            WHERE iddiaclase = {$diaclase} and idhoraclase = {$horaclase} and iddojo = {$iddojo}";
            //echo $query."<br>";
            $clase = mysqli_fetch_array(mysqli_query($enlace,$query));

            $query = "UPDATE alumnos SET  idclase={$clase['idclase']} WHERE idalumno={$ultimo_id}";
            //echo $query."<br>";
            $resp = mysqli_query($enlace,$query);
            if (!$resp)
            {
                $error.="Error al actualizar clase".mysqli_error($enlace)."<br>";
            }
            

        }else
        {
            $error.="Error al dar de alta alumno".mysqli_error($enlace)."<br>";
        }         
    }

    if($error=="")
    {
        echo "<script type='text/javascript'>alert('¡Alumno Añadido!')</script>";
    }
       
}
mysqli_close($enlace);
include "cabecera.php";
?>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <p><img class='logo' src="logolitho.jpg"></p>
    <label class="navbar-brand"><span class="text-light bg-dark">ALTA NUEVA</span></label>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <span class='text-light bg-dark'>Añadir Alumnos</span></a>

                <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                    <a class='dropdown-item' href='gestionardojo.php?dojo=<?php echo $iddojo ?>&&mostrar=all&&ord=desc&&campo=nombre&&usuario=<?php echo $rolenuso?>'>Gestionar alumnos</a>
                </div>
            </li>
            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <span class='text-light bg-dark'>Gestionar Clases</span></a>
                <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                    <a class='dropdown-item' href='gestionarclases.php?dia=1&&hora=1'>Clase lunes-miércoles (16:30-17:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=1&&hora=2'>Clase lunes-miércoles (17:30-18:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=1&&hora=3'>Clase lunes-miércoles (18:30-19:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=1&&hora=4'>Clase lunes-miércoles (19:30-20:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=1&&hora=5'>Clase lunes-miércoles (20:30-22:00)</a>
                    <div class='dropdown-divider'></div>
                    <a class='dropdown-item' href='gestionarclases.php?dia=2&&hora=1'>Clase martes-jueves (16:30-17:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=2&&hora=2'>Clase martes-jueves (17:30-18:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=2&&hora=3'>Clase martes-jueves (18:30-19:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=2&&hora=4'>Clase martes-jueves (19:30-20:30)</a>
                    <a class='dropdown-item' href='gestionarclases.php?dia=2&&hora=5'>Clase martes-jueves (20:30-22:00)</a>
                    <div class='dropdown-divider'></div>
                    <a class='dropdown-item' href='cambiarentrenador.php?clase=all'>Cambios de entrenador en clases</a>
                    <div class='dropdown-divider'></div>
                    <a class='dropdown-item' href='#'>Nueva Clase</a>
                </div>
            </li>
            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <span class='text-light bg-dark'>Gestionar Usuarios</span></a>
                <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                    <a class='dropdown-item' href='#'>Nuevo Usuario</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-light bg-dark">Tesorería</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Ingresos</a>
                    <a class="dropdown-item" href="#">Gastos</a>
                    <div class='dropdown-divider'></div>
                                
                        <a class='dropdown-item' href='gestionbancaria.php?usuario={$rolenuso}&&ord={$ord}&&campo=nombre&&mostrar=all'>Comprobacion Cuentas</a>
                                
                    </div>
                </div>
            </li>
            <li class='nav-item'>
                <a class='navbar-brand' href="gestionardojo.php?dojo=<?php echo $iddojo ?>&&mostrar=all&&ord=desc&&campo=nombre&&usuario=<?php echo $idusuario?>"><span class='text-primary'>VOLVER</span></a>
            </li>
            <li class='nav-item'>
                <a class='navbar-brand' href='avisolegal.php'><span class='text-warning'>AVISO LEGAL</span></a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand" href="logout.php"><span class="text-warning">Salir</span></a>
            </li>
        </ul>
    </div>
</nav>
<label class='nav-item'><h6>Usuario: <?php echo " ".$nombreusuario?></h6></label>
<p><h1 class="mb-3">Lithojudo - Gestión Deportistas - Alta Alumno.</h1></p>
<p><h4 class="mb-3">Facilita los datos del nuevo alumno. Los campos con (*) son obligatorios.</h4></p>

<form  name="altadeportista" action="" method="POST">
    <div class="row g-2">
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom01" class="form-label"><span class="obligado">Nombre del alumno (*)</span></label>
                <input type="text" class="form-control" id="validationCustom01" name="nombre" placeholder="Nombre" required>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label"><span class="obligado">Primer apellido (*)</span></label>
                <input type="text" class="form-control" id="validationCustom02" name="apellido1" placeholder="Primer apellido" required>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom03" class="form-label"><span class="obligado">Segundo apellido (*)</span></label>
                <input type="text" class="form-control" id="validationCustom03" name="apellido2" placeholder="Segundo apellido" required>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
    </div>

    <div class="row g-2">
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom04" class="form-label"><span class="obligado">Correo electrónico</span></label>
                <input type="email" class="form-control" name="email" id="validationCustom04" placeholder="name@example.com">
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom05" class="form-label"><span class="obligado">Teléfono (*)</span></label>
                <input type="text" class="form-control" name="telefono" id="validationCustom05" placeholder="telefono" required>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom06" class="form-label"><span class="obligado">DNI</span></label>
                <input type="text" class="form-control" name="dni" id="fvalidationCustom06" placeholder="DNI">
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
    </div>

    <div class="row g-2">
        <div class="col-md">
            <div class="mb-3">
                <label for="floatingInputEmail"><span class="obligado">Fecha de nacimiento (*)</span></label>
                <input type="date" class="form-control" name="dateborn" id="floatingInputDateborn" required>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="floatingSelectGridEscuela"><span class="obligado">Selecciona Escuela (*)</span></label>
                <select name='dojo' class="form-select" id="floatingSelectGridEscuela">
                    <?php
                        include "conexion.php";
                        $query = "SELECT * from dojo";
                        $respuesta = mysqli_query($enlace,$query);
                        while ($dojo = mysqli_fetch_assoc($respuesta))
                        {
                            echo "<option value={$dojo['iddojo']}>".$dojo['nombre']."</option>";
                        }
                    mysqli_close($enlace);
                    ?>
                </select>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="floatingSelectGridKyu"><span class="obligado">Selecciona nivel kyu (*)</span></label>
                <select class="form-select" name='kyu' id="floatingSelectGridKyu">
                    <?php
                        include "conexion.php";
                        $query = "SELECT * from nivel";
                        $respuesta = mysqli_query($enlace,$query);
                        while ($nivel = mysqli_fetch_assoc($respuesta))
                        {
                            echo "<option value={$nivel['idnivel']}>".$nivel['color']."</option>";
                        }
                    mysqli_close($enlace);
                    ?>
                </select>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
    </div>

    <div class="row g-2">
    <div class="col-md">
            <div class="mb-3">
                <label for="floatingSelectGridCompeticion"><span class="obligado">Selecciona Competicion (*)</span></label>
                <select name='competicion' class="form-select" id="floatingSelectGridcompeticion">
                    <?php
                        include "conexion.php";
                        $query = "SELECT * from competiciones";
                        $respuesta = mysqli_query($enlace,$query);
                        while ($compe = mysqli_fetch_assoc($respuesta))
                        {
                            echo "<option value={$compe['idcompeticion']}>".$compe['competicion']."</option>";
                        }
                    mysqli_close($enlace);
                    ?>
                </select>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
            <div class="mb-3">
                <label for="floatingSelectGridDiaClases"><span class="obligado">Selecciona Dia Clase (*)</span></label>
                <select name='diaclase' class="form-select" id="floatingSelectGridDiaClases">
                    <?php
                        include "conexion.php";
                        $query = "SELECT * from diasclases";
                        $respuesta = mysqli_query($enlace,$query);
                        while ($diasclases = mysqli_fetch_assoc($respuesta))
                        {
                            echo "<option value={$diasclases['iddiaclase']}>".$diasclases['diaclase']."</option>";
                        }
                    mysqli_close($enlace);
                    ?>
                </select>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
            <div class="mb-3">
                <label for="floatingSelectGridHoraClase"><span class="obligado">Selecciona Hora Clase (*)</span></label>
                <select name='horaclase' class="form-select" id="floatingSelectGridHoraClase">
                    <?php
                        include "conexion.php";
                        $query = "SELECT * from horasclases";
                        $respuesta = mysqli_query($enlace,$query);
                        while ($horasclases = mysqli_fetch_assoc($respuesta))
                        {
                            echo "<option value={$horasclases['idhoraclase']}>".$horasclases['hora']."</option>";
                        }
                    mysqli_close($enlace);
                    ?>
                </select>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom07" class="form-label"><span class="obligado">Nombre padre.</span></label>
                <input type="text" class="form-control" id="validationCustom07" name="padre" placeholder="Nombre padre">
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom08" class="form-label"><span class="obligado">Nombre madre.</span></label>
                <input type="text" class="form-control" id="validationCustom08" name="madre" placeholder="Nombre madre">
                <div id="madreHelpBlock" class="form-text">
                    <span class="obligado">Al menos uno de los progenitores es obligatorio en caso de menores (*).</span>
                </div>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
    </div>

    <div class="row g-2">
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom09" class="form-label"><span class="obligado">Teléfono de emergencias(*).</span></label>
                <input type="text" class="form-control" id="validationCustom09" name="urgencias1" placeholder="Telefono urgencias" required>               
                <div id="urgencias1HelpBlock" class="form-text">
                    <span class="obligado">Al menos un telefóno de emergencia distinto al personal (*).</span>
                </div>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom09" class="form-label"><span class="obligado">Teléfono de emergencias.</span></label>
                <input type="text" class="form-control" id="validationCustom10" name="urgencias2" placeholder="Telefono urgencias">        
                <div id="urgencias2HelpBlock" class="form-text">
                    <span class="obligado">Al menos un telefóno de emergencia distinto al personal (*).</span>
                </div>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <label for="validationCustom10" class="form-label"><span class="obligado">Cuenta Bancaria.</span></label>
            <table>
                <tr>
                    <td>
                        <div class="mb-3">                
                            <input type="text" class="form-control" id="validationCustom10" name="ccc1" size="4ch" maxlength="4" placeholder="ESxx">
                            <div class="valid-feedback">
                                ¡Correcto!
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="mb-3">                
                            <input type="text" class="form-control" id="validationCustom11" name="ccc2" size="5ch" maxlength="5" placeholder="xxxxx">
                            <div class="valid-feedback">
                                ¡Correcto!
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="mb-3">                
                            <input type="text" class="form-control" id="validationCustom12" name="ccc3" size="5ch" maxlength="5" placeholder="xxxxx">
                            <div class="valid-feedback">
                                ¡Correcto!
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="mb-3">                
                            <input type="text" class="form-control" id="validationCustom13" name="ccc4" size="5ch" maxlength="5" placeholder="xxxxx">
                            <div class="valid-feedback">
                                ¡Correcto!
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="mb-3">                
                            <input type="text" class="form-control" id="validationCustom14" name="ccc5" size="5ch" maxlength="5" placeholder="xxxxx">
                            <div class="valid-feedback">
                                ¡Correcto!
                            </div>
                        </div>
                    </td>

                </tr>
            </table>
        </div>
    </div>


    <div  class="container text-center mt-5">
        <button type="submit" name="nuevoalumno" class="btn btn-primary">Alta alumno</button>
    </div>

</form>


<?php include "pie.php";


 // Función para verificar si una cuenta IBAN es correcta
 // @param string $iban
 // @return boolean
 
function checkIBAN($iban) {
    // Eliminar espacios en blanco
    $iban = str_replace(' ', '', $iban);
    
    // Mover los cuatro primeros caracteres al final de la cadena
    $iban = substr($iban, 4) . substr($iban, 0, 4);
    
    // Reemplazar cada letra por su valor numérico
    $iban = str_replace(
        range('A', 'Z'),
        range(10, 35),
        $iban
    );
    
    // Convertir la cadena en un número entero y calcular el módulo 97
    $modulo = intval(substr($iban, 0, 1));
    for ($i = 1; $i < strlen($iban); $i++) {
        $modulo = ($modulo * 10 + intval(substr($iban, $i, 1))) % 97;
    }
    
    // Si el resultado es 1, el IBAN es válido
    if ($modulo==1)
    {
        return 1;
    }else
    {
        return 0;
    }
    
}

?>

