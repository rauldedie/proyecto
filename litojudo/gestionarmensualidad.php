<?php
session_start();
$tiempo_inactivo = 10 * 60;
if (!array_key_exists("usuario_id",$_SESSION)){
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA
if (isset($_SESSION['inactivo']) && (time() - $_SESSION['inactivo']) > $tiempo_inactivo) {
    session_unset();
    session_destroy();

    //Redireccionamos el usuario a logout
    header("Location: logout.php");
    exit();
  }else{
    // Regenera nueva sesion y fija de nuevo el tiempo
    session_regenerate_id(true);

    // Update the last timestamp
    $_SESSION['inactivo'] = time();
  }

$nombreusuario = $_SESSION['usuario_nombre'];
$idenuso = $_SESSION['usuario_id'];
$rolenuso = $_SESSION['usuario_rol'];
$rol=$rolenuso;

include "conexion.php"; 
include "cabecera.php";

if (isset($_GET['usuario']))
{
    $idusuario = htmlspecialchars(stripslashes($_GET['usuario']));

    if (isset($_GET['dojo']))
    {
        $iddojo = htmlspecialchars(stripslashes($_GET['dojo']));

    }else $iddojo = 1;

    if($idusuario == $idenuso && $rolenuso==1)
    {
      $query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idenuso} and u.tipousuario=t.idtipo and u.estado='alta'";
      $fila = mysqli_fetch_array(mysqli_query($enlace,$query));
      if (strcmp($fila['tipo'],"administrador")!=0)
      {
        echo "<script>window.location='logout.php;</script>";
      }
    }else
    {
      echo "<script>window.location='logout.php;</script>";
    }

    if(isset($_GET['estado']))
    {
        $estado = htmlspecialchars(stripslashes($_GET['estado']));

    }else $estado='alta';

    if(isset($_GET['mostrar']))
    {
        $mostrar = htmlspecialchars($_GET['mostrar']);
    
    }else $mostrar='all';
    //echo $mostrar;
    //establezco campo y ordenacion 
    //la primera vez, al hacer login viene establecido, el resto segun decida el usuario
    //de vuelta de otra pagina el orden siempre sera asc y por el campo nombre
    if(isset($_GET['ord']))
    {
        $ord = htmlspecialchars($_GET['ord']);
    }else
    {
        $ord = "asc";
    }
    if(isset($_GET['campo']))
    {
        $campo = htmlspecialchars($_GET['campo']);
    }else
    {
        $campo = "nombre";
    }
    
    $query = "SELECT tipousuario from tipo_usuario WHERE idtipo={$idusuario}";
    $fila = mysqli_fetch_array(mysqli_query($enlace,$query));
    $rolenuso = $fila['tipousuario'];

    /*$query = "SELECT nombre FROM dojo WHERE iddojo={$iddojo}";
    $nombredojo = mysqli_fetch_array(mysqli_query($enlace,$query));
    $dojo = $nombredojo['nombre'];*/

    echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>
    <p><img class='logo' src='logolitho.jpg'></p>
    <label class='navbar-brand'><span class='text-light bg-dark'>PANEL PRINCIPAL</span></label>
        <div class='collapse navbar-collapse' id='navbarSupportedContent'>
            <ul class='navbar-nav mr-auto'>
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <span class='text-light bg-dark'>Gestionar Escuela</span></a>
                    <div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
                    $query = "SELECT * FROM dojo ";
                    $respuesta = mysqli_query($enlace,$query);
                    while ($dojo = mysqli_fetch_assoc($respuesta))
                    {
                        echo "<a class='dropdown-item' href='gestionardojo.php?dojo={$dojo['iddojo']}&&usuario={$idusuario}'>{$dojo['nombre']}</a>";
                        echo "<div class='dropdown-divider'></div>";
                    }
                    echo "<a class='dropdown-item' href='#'>Nuevo Dojo</a>
                    </div>
                </li>
                <li></li>
                <li></li>
                <li class='nav-item'>
                    <a class='navbar-brand' href='panelprincipal.php?rol={$rol}&&usuario={$idenuso}'><span class='text-primary'>VOLVER</span></a>
                </li>
                <li class='nav-item'>
                    <a class='navbar-brand' href='avisolegal.php'><span class='text-warning'>AVISO LEGAL</span></a>
                </li>
                <li class='nav-item'>
                    <a class='navbar-brand' href='logout.php'><span class='text-warning'>SALIR</span></a>
                </li>

            </ul>

        </div>
    </nav>";




    
    /*echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>";
        echo"<p><img class='logo' src='logolitho.jpg'></p>";
        echo "<label class='navbar-brand'><span class='text-light bg-dark'>GESTION CUOTAS MENSUALES</span></label>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav mr-auto'>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <span class='text-light bg-dark'>Gestionar Alumnos</span></a>

                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'> 
                            <a class='dropdown-item' href='altadeportista.php?dojo={$iddojo}'>Añadir nuevo alumno</a>                           
                        </div>
                    </li>

                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <span class='text-light bg-dark'>Gestionar Clases</span></a>
                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                            <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=1&&hora=1'>Clase lunes-miércoles (16:30-17:30)</a>
                            <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=1&&hora=2'>Clase lunes-miércoles (17:30-18:30)</a>
                            <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=1&&hora=3'>Clase lunes-miércoles (18:30-19:30)</a>
                            <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=1&&hora=4'>Clase lunes-miércoles (19:30-20:30)</a>
                            <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=1&&hora=5'>Clase lunes-miércoles (20:30-22:00)</a>
                            <div class='dropdown-divider'></div>
                            <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=2&&hora=1'>Clase martes-jueves (16:30-17:30)</a>
                            <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=2&&hora=2'>Clase martes-jueves (17:30-18:30)</a>
                            <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=2&&hora=3'>Clase martes-jueves (18:30-19:30)</a>
                            <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=2&&hora=4'>Clase martes-jueves (19:30-20:30)</a>
                            <a class='dropdown-item' href='gestionarclases.php?dojo={$iddojo}&&dia=2&&hora=5'>Clase martes-jueves (20:30-22:00)</a>
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

                            <a class='dropdown-item' href='gestionarusuarios.php?usuario={$idusuario}&&dojo={$iddojo}&&mostrar=all&&ord=desc&&campo=nombre'>Gestionar Usuarios</a>
                            <a class='dropdown-item' href='#'>Nuevo Usuario</a>
                        </div>
                    </li>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <span class='text-light bg-dark'>Tesorería</span></a>
                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                            <a class='dropdown-item' href='#'>Ingresos</a>
                            <a class='dropdown-item' href='#'>Gastos</a>
                        
                            <div class='dropdown-divider'></div>
                                
                                <a class='dropdown-item' href='gestionbancaria.php?usuario={$rolenuso}&&ord={$ord}&&campo=nombre&&mostrar=all'>Comprobacion Cuentas</a>
                                
                            </div>
                        </div>
                    </li>
                    

                </ul>

            </div>
        </nav>";**/
    
    echo "<div class='form-group'>";
    echo "<br>";
    echo "<label class='nav-item'><h6>Usuario: ".$nombreusuario."</h6></label><br>"; 
    
        if(strcmp($rolenuso,"administrador")==0)//añadir oficina
        {   
            /*ESTA PARA EN EL FUTURO GESTIONAR MENSUALIDADES DE GENTE DE BAJA
            if($estado=="alta")
            {
                echo " <a href='gestionardojo.php?dojo={$iddojo}&&usuario={$idusuario}&&estado=baja' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Alumnos de baja</a>";
                //echo "<a href='gestionarusuario.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Gestionar Clases</a>";

            }
            ESTO ES PARA GESTIONAR POR DOJO LAS MENSUALIDADES AHORA SE HACEN TODOS JUNTOS
            $query = "SELECT iddojo FROM dojo where iddojo<>{$iddojo}";
            //echo $query;
            $resp = mysqli_fetch_array(mysqli_query($enlace,$query));
            $cambiodojo = $resp['iddojo'];*/

            echo "<a href='cuotasmes.php?' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> AÑADIR CUOTAS DEL MES</a>";
           
            echo "<a href='gestionbancaria.php?usuario={$rolenuso}&&ord={$ord}&&campo=nombre&&mostrar=all' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Comprobacion Cuentas</a>";

            
            
        }
        if (strcmp($ord,"desc")==0)
        {
            $ord="asc";
        }else
        {
            $ord="desc";
        }   
        
        echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<thead class='table table-striped'>";
                echo "<tr>";                   
                    echo "<th class='table-dark' scope='col'colspan='3'><a href='gestionarmensualidad.php?dojo={$iddojo}&&usuario={$idusuario}&&ord={$ord}&&campo=nombre' class='btn btn-secondary'>Alumno</a></th>";
                    //echo "<th class='table-dark' scope='col'><a href='gestionardojo.php?dojo={$iddojo}&&usuario={$idusuario}&&ord={$ord}&&campo=idnivel' class='btn btn-secondary'>Nivel (Kyu)</a></th>";
                    echo "<th class='table-dark' scope='col'>mes cuota</th>";
                    echo "<th class='table-dark' scope='col'>año</th>";
                    echo "<th class='table-dark' scope='col'>estado</th>";
                    echo "<th class='table-dark' scope='col' colspan='3' class='text-center'>Operaciones</th>";
                echo "</tr>";  
            echo "</thead>";
            echo "<tbody>";
                echo "<tr>";
                    //SELECT DEPORTISTAS
                    $mesActual = date("m");
                    $anioActual = date("Y");



                    $query = "SELECT idalumno,a.nombre nombre,apellido1,apellido2, c.estado,c.mes
                    from alumnos a, cuotas c
                    WHERE a.idalumno=c.idlumno and c.mes={$mesActual} and c.anio={$anioActual} ORDER BY {$campo} {$ord}";
                    //echo $query;
                    $respuesta = mysqli_query($enlace,$query);
                    
                    while($row = mysqli_fetch_assoc($respuesta))
                    {

                        $id = $row['idalumno'];
                        $usuario = $row['nombre']." ".$row['apellido1']." ".$row['apellido2'];
                        $mes = $row['mes'];
                        $anio = $row['anio'];

                        if ($row['estado'] == 1)
                        {
                            $estado = "Pagado" ;
                        }else
                        {
                            $estado = "Pendiente" ;
                        }
                        

                        echo "<tr >";
                            echo " <th scope='row' colspan='3'>{$usuario}</th>";
                            echo " <td> {$mes}</td>";
                            echo " <td class='table-dark'> {$anio}</td>";
                            echo " <td class='table-dark'>{$estado} </td>";
                            
                            if ($row['estado'] == 0)
                            {
                                echo " <td class='text-center'> <a href='pagarcuotas.php?idelemento={$id}&&idrol={$idenuso}' class='btn btn-primary'> <i class='bi bi-eye'></i> Pagar Mes </a> </td>";
                            }
                            echo " <td class='text-center' > <a href='historicocuotas.php?idalumno={$id}&&idrol={$idenuso}' class='btn btn-secondary' ><i class='bi bi-pencil'></i>Ver histórico coutas</a> </td>";

                            
                        echo " </tr> ";
                           
                    }
                    
                echo "</tr>";  
            echo "</tbody>";
        echo "</table>";
    echo "</div>";
    mysqli_close($enlace);
     
}

include "pie.php";
/* PARA GESTIONAR ROLES
if(strcmp($rolenuso,"administrador")==0)
{
    /*PARA GESTIONAR ALUMNOS EN BAJA
    if (strcmp($estado,"baja")==0)
    {
        echo " <td class='text-center'> <a href='verelemento.php?dojo={$iddojo}&&idelemento={$id}&&estado=baja' class='btn btn-primary'> <i class='bi bi-eye'></i> Pagar </a> </td>";
        echo " <td class='text-center' > <a href='bajaalumno.php?dojo={$iddojo}&&alta={$id}' class='btn btn-danger' ><i class='bi bi-pencil'></i> Volver dar Alta</a> </td>";
    }else
    {
        echo " <td class='text-center'> <a href='verelemento.php?dojo={$iddojo}&&idelemento={$id}&&estado=alta' class='btn btn-primary'> <i class='bi bi-eye'></i> Ver</a> </td>";
        echo " <td class='text-center' > <a href='editaralumno.php?dojo={$iddojo}&&idalumno={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
        echo " <td class='text-center'>  <a href='bajaalumno.php?dojo={$iddojo}&&eliminar={$id}' class='btn btn-danger' > <i class='bi bi-trash'></i> Dar de Baja</a> </td>";
    }*/
    

/*}else if(strcmp($rolenuso,"entrenador")==0)
{
    echo " <td class='text-center' > <a href='editarincidencia.php?editar&incidencia_id={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
}*/
                    /* POR SI QUIERO SELECCIONA MOSTRAR POR FEDERADOS, NO FEDERADOS ETC
if(strcmp($mostrar,"all") == 0)
{
    $query = "SELECT idalumno,a.nombre nombre,apellido1,apellido2, c.estado,c.mes
    from alumnos a, cuotas c
    WHERE a.idalumno=c.idlumno and c.mes={$mesActual} and c.anio={$anioActual} ORDER BY {$campo} {$ord}";

}                
else
{
    $query = "SELECT idalumno,a.nombre nombre,apellido1,apellido2,dateborn,a.telefono telefono,c.competicion,color,n.idnivel idnivel,urgencias1
    from alumnos a,nivel n, competiciones c 
    WHERE a.idnivel=n.idnivel and a.iddojo={$iddojo} and a.competicion={$mostrar} and c.idcompeticion=a.competicion and estado='{$estado}'  ORDER BY {$campo} {$ord}";

}*/
?>