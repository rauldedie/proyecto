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
$error="";

include "conexion.php";
//verifico rol (AÑADIR ENTRENADOR Y OFICINA)
$query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idusuario} and u.tipousuario=t.idtipo";
$fila = mysqli_fetch_array(mysqli_query($enlace,$query));

if (strcmp($fila['tipo'],"administrador")!=0)
{
    echo "<script>window.location='logout.php;</script>";
}

if (isset($_GET['idalumno']))
{
    if(isset($_GET['dojo']))
    {
        $iddojo = htmlspecialchars(stripslashes($_GET['dojo']));

    }else $iddojo=1;
    
    $idelto = htmlspecialchars(stripslashes($_GET['idalumno']));
//Recupero los datos del alumno
    $query = "SELECT *
    FROM alumnos 
    WHERE idalumno={$idelto}";
    //echo $query;
    $alumno = mysqli_fetch_array(mysqli_query($enlace,$query));
    

//averiguo dia, hora de su clase correspondiente
    $query ="SELECT  iddiaclase,idhoraclase FROM  clases WHERE idclase = {$alumno['idclase']} ";
    //echo $query;
    $clase = mysqli_fetch_array(mysqli_query($enlace,$query));
    $query = "SELECT * from diasclases where iddiaclase={$clase['iddiaclase']}";
    $dia_clase = mysqli_fetch_array(mysqli_query($enlace,$query));
    $query = "SELECT * from horasclases where idhoraclase={$clase['idhoraclase']}";
    $hora_clase = mysqli_fetch_array(mysqli_query($enlace,$query));

//Averiguo dojo, competicion y kyu del alumno
    $query = "SELECT * FROM dojo WHERE iddojo = {$alumno['iddojo']}";
    $dojo = mysqli_fetch_array(mysqli_query($enlace,$query));

    $query = "SELECT * FROM competiciones WHERE idcompeticion = {$alumno['competicion']}";
    $competicion = mysqli_fetch_array(mysqli_query($enlace,$query));

    $query = "SELECT * FROM nivel WHERE idnivel = {$alumno['idnivel']}";
    $kyu = mysqli_fetch_array(mysqli_query($enlace,$query));


 //Asigno datos actuales
    $nombre = $alumno['nombre'];
    $apellido1 = $alumno['apellido1'];
    $apellido2 = $alumno['apellido2'];
    $idalumno = $alumno['idalumno'];
    $dateborn = $alumno['dateborn'];
    $telefono = $alumno['telefono'];
    $email = $alumno['email'];
    $inscrito = $competicion['competicion'];
    $color = $kyu['color'];
    $nombredojo = $dojo['nombre'];
    $padre = $alumno['padre'];
    $madre = $alumno['madre'];
    $urgencias1 = $alumno['urgencias1'];
    $urgencias2 = $alumno['urgencias2'];
    $dni = $alumno['dni'];
    $diaclase = $dia_clase['diaclase'];
    $horaclase = $hora_clase['hora'];
    $idhoraclase = $hora_clase['idhoraclase'];
    $iddiaclase = $dia_clase['iddiaclase'];
    $idclase = $dia_clase['idclase'];

    //Recojo los cambios y actualizo las tablas
    if (isset($_POST['editaralumno']))
    {
    
        $nombremod = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['nombre']))));
        $apellido1mod = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['apellido1']))));
        $apellido2mod = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['apellido2']))));
        $datebornmod = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['dateborn']))));

        $email = strtolower(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['email']))));
        //$email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $emailmod = filter_var($email, FILTER_VALIDATE_EMAIL);

        $telefonomod = htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['telefono'])));
        $kyumod = htmlspecialchars(mysqli_real_escape_string($enlace,stripcslashes($_POST['kyu'])));
        $iddojomod = htmlspecialchars(mysqli_real_escape_string($enlace,stripcslashes($_POST['dojo'])));

        $competicionmod =  htmlspecialchars(mysqli_real_escape_string($enlace,stripcslashes($_POST['competicion'])));
        
        $urgencias1mod = htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['urgencias1'])));
        $urgencias2mod = htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['urgencias2'])));
        $padremod = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['padre']))));
        $madremod = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['madre']))));
        $dnimod = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['dni']))));

        $diaclasemod = htmlspecialchars(mysqli_real_escape_string($enlace,stripcslashes($_POST['diaclase'])));
        $horaclasemod =  htmlspecialchars(mysqli_real_escape_string($enlace,stripcslashes($_POST['horaclase'])));
        
        if(empty($diaclasemod))
        {
            $sinclases=1;
        }else
        {
            $sinclases=0;
        }


        $query = "UPDATE alumnos set nombre='{$nombremod}', apellido1='{$apellido1mod}',apellido2='{$apellido2mod}',
        dateborn='{$datebornmod}', email='{$emailmod}', telefono='{$telefonomod}',padre='{$padremod}',madre='{$madremod}',
        urgencias1='{$urgencias1mod}',urgencias2='{$urgencias2mod}',dni='{$dnimod}',idnivel={$kyumod},competicion={$competicionmod},
        iddojo={$iddojomod} where idalumno={$idalumno}";
        //echo $query;
        $resp = mysqli_query($enlace,$query);

        if ($resp)
        {

            if($sinclases==0)
            {
                $query = "SELECT idclase FROM clases WHERE iddiaclase={$diaclasemod} and
                idhoraclase={$horaclasemod} and iddojo = {$iddojomod}";
                //echo $query;
                $clasemod = mysqli_fetch_array(mysqli_query($enlace,$query));
    
                $query = "UPDATE alumnos set idclase={$clasemod['idclase']} where idalumno={$idalumno}";    
                //echo $query;
                $respuesta = mysqli_query($enlace,$query);
                if($respuesta)
                {
                        
                    echo "<script type='text/javascript'>alert('Alumno actualizado correctamente')</script>";  
                    //echo "<script>window.location='verelemento.php?idelemento={$idelto}</script>";   
                
                }else
                {
                    $error.= "Error al actualizar el alumno.".mysqli_error($enlace)."<br>";
                }
            }else
            {
                echo "<script type='text/javascript'>alert('Alumno actualizado correctamente a falta de asignarle clases')</script>";
            }

        }else
        {
            $error.= "Error al actualizar el alumno.".mysqli_error($enlace)."<br>";
        }



    }
}
//echo "Error contiene: ".$error;
mysqli_close($enlace);
if($error=="")
{
    echo "<script>window.location='verelemento.php?idelemento={$idelto}</script>";
}

include "cabecera.php";
?>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <p><img class='logo' src="logolitho.jpg"></p>
    <label class="navbar-brand"><span class="text-light bg-dark">GESTION ALUMNOS</span></label>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <span class='text-light bg-dark'>Editar Alumno</span></a>

                <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                    <a class='dropdown-item' href='gestionardojo.php?mostrar=all&&ord=desc&&campo=nombre&&usuario=<?php echo $rolenuso?>'>Gestionar alumnos</a>
                    <a class='dropdown-item' href='altadeportista.php'>Añadir nuevo alumno</a>
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
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Balance</a>
                    </div>
                </div>
            </li>
            <li class='nav-item'>
                <a class='navbar-brand' href="gestionardojo.php?dojo=<?php echo $iddojo?>&&mostrar=all&&ord=desc&&campo=nombre&&usuario=<?php echo $idusuario?>"><span class='text-primary'>VOLVER</span></a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand" href="logout.php"><span class="text-warning">Salir</span></a>
            </li>
        </ul>
        
    </div>
</nav>

<label class='nav-item'><h6>Usuario:<?php echo " ".$nombreusuario ?></h6></label><br>


<p class="encabezado"><h1 class="mb-3">Lithojudo - Gestión Deportistas - Editar Alumno.</h1></p>

<form  name="editar" action="" method="POST">
    <div class="row g-2">
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom01" class="form-label"><span class="obligado">Nombre del alumno</span></label>
                <input type="text" class="form-control" id="validationCustom01" name="nombre" value="<?php echo $nombre ?>">
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label"><span class="obligado">Primer apellido</span></label>
                <input type="text" class="form-control" id="validationCustom02" name="apellido1" value="<?php echo $apellido1 ?>">
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom03" class="form-label"><span class="obligado">Segundo apellido</span></label>
                <input type="text" class="form-control" id="validationCustom03" name="apellido2" value="<?php echo $apellido2 ?>">
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
                <input type="email" class="form-control" name="email" id="validationCustom04" value="<?php echo $email ?>">
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom05" class="form-label"><span class="obligado">Teléfono</span></label>
                <input type="text" class="form-control" name="telefono" id="validationCustom05" value="<?php echo $telefono ?>">
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom06" class="form-label"><span class="obligado">DNI</span></label>
                <input type="text" class="form-control" name="dni" id="fvalidationCustom06" value="<?php echo $dni ?>">
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
    </div>

    <div class="row g-2">
        <div class="col-md">
            <div class="mb-3">
                <label for="floatingInputEmail"><span class="obligado">Fecha de nacimiento</span></label>
                <input type="date" class="form-control" name="dateborn" id="floatingInputDateborn" value="<?php echo $dateborn ?>">
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="floatingSelectGridEscuela"><span class="obligado">Selecciona Escuela</span></label>
                <select name='dojo' class="form-select" id="floatingSelectGridEscuela">
                    <?php
                        include "conexion.php";
                        $query = "SELECT * from dojo";
                        $respuesta = mysqli_query($enlace,$query);
                        echo "<option value={$alumno['iddojo']} selected>".$nombredojo."</option>";
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
                <label for="floatingSelectGridKyu"><span class="obligado">Selecciona nivel kyu</span></label>
                <select class="form-select" name='kyu' id="floatingSelectGridKyu">
                    <?php
                        include "conexion.php";
                        $query = "SELECT * from nivel";
                        $respuesta = mysqli_query($enlace,$query);
                        echo "<option value={$alumno['idnivel']} selected>".$color."</option>";
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
                <label for="floatingSelectGridCompeticion"><span class="obligado">Selecciona Competicion</span></label>
                <select name='competicion' class="form-select" id="floatingSelectGridcompeticion">
                    <?php
                        include "conexion.php";
                        $query = "SELECT * from competiciones";
                        $respuesta = mysqli_query($enlace,$query);
                        echo "<option value={$alumno['competicion']} selected>".$inscrito."</option>";
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
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom07" class="form-label"><span class="obligado">Nombre padre.</span></label>
                <input type="text" class="form-control" id="validationCustom07" name="padre" value="<?php echo $padre ?>">
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom08" class="form-label"><span class="obligado">Nombre madre.</span></label>
                <input type="text" class="form-control" id="validationCustom08" name="madre" value="<?php echo $madre ?>">
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
                <label for="validationCustom09" class="form-label"><span class="obligado">Teléfono de emergencias.</span></label>
                <input type="text" class="form-control" id="validationCustom09" name="urgencias1" value="<?php echo $urgencias1 ?>">               
                <div id="urgencias1HelpBlock" class="form-text">
                    <span class="obligado">Al menos un teléfono de emergencia distinto al personal (*).</span>
                </div>
                <div class="valid-feedback">
                    ¡Correcto!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="validationCustom09" class="form-label"><span class="obligado">Teléfono de emergencias.</span></label>
                <input type="text" class="form-control" id="validationCustom10" name="urgencias2" value="<?php echo $urgencias2 ?>">        
                <div id="urgencias2HelpBlock" class="form-text">
                    <span class="obligado">Al menos un teléfono de emergencia distinto al personal (*).</span>
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
                <label for="floatingSelectGridDiaclase"><h4><span class="obligado">Dias de clases</span></h4></label>
                    <select name='diaclase' class="form-select" id="floatingSelectDiaclase">
                        <option value='<?php echo $iddiaclase ?>' selected><?php echo $diaclase ?></option>;
                        <?php
                            include "conexion.php";
                            $query = "SELECT * from diasclases";
                            $respuesta = mysqli_query($enlace,$query);
                            while ($fila = mysqli_fetch_assoc($respuesta))
                            {
                                echo "<option value={$fila['iddiaclase']}>".$fila['diaclase']."</option>";
                            }
                            mysqli_close($enlace);
                        ?>
                    </select>

            </div>
        </div>
        <div class="col-md">
            <div class="mb-3">
                <label for="floatingSelectGridDiaclase"><h4><span class="obligado">Horas de clases</span></h4></label>
                <select name='horaclase' class="form-select" id="floatingSelectHoraclase">
                    <option value='<?php echo $idhoraclase ?>' selected><?php echo $horaclase ?></option>
                    <?php
                        include "conexion.php";
                        $query = "SELECT * from horasclases";
                        $respuesta = mysqli_query($enlace,$query);
                        while ($fila = mysqli_fetch_assoc($respuesta))
                        {
                            echo "<option value={$fila['idhoraclase']}>".$fila['hora']."</option>";
                        }
                        mysqli_close($enlace);
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div  class="container text-center mt-5">
        <button type="submit" name="editaralumno" class="btn btn-primary">Editar alumno</button>
    </div>

</form>
<?php include "pie.php"?>
