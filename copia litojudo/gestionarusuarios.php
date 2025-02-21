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
//echo "estoy aqui";
if (isset($_GET['usuario']))
{
    $idusuario = htmlspecialchars(stripslashes($_GET['usuario']));
   //echo $idenuso;
    if (isset($_GET['dojo']))
    {
        $iddojo = htmlspecialchars(stripslashes($_GET['dojo']));

    }else $iddojo = 1;

    if($idusuario == $idenuso && $rolenuso==1)
    {
      $query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idenuso} and u.tipousuario=t.idtipo and u.estado='alta'";
      //echo $query."<br>";
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

    $query = "SELECT tipousuario from tipo_usuario WHERE idtipo={$idenuso}";
    //echo $query."<br>";
    $fila = mysqli_fetch_array(mysqli_query($enlace,$query));
    $rolenuso = $fila['tipousuario'];

    $query = "SELECT nombre FROM dojo WHERE iddojo={$iddojo}";
    //echo $query."<br>";
    $nombredojo = mysqli_fetch_array(mysqli_query($enlace,$query));
    $dojo = $nombredojo['nombre'];
    
    echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>";
        echo"<p><img class='logo' src='logolitho.jpg'></p>";
        echo "<label class='navbar-brand'><span class='text-light bg-dark'>GESTION DEPORTISTAS</span></label>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav mr-auto'>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <span class='text-light bg-dark'>Gestionar Alumnos</span></a>

                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'> 
                        <a class='dropdown-item' href='gestionardojo.php?usuario={$idenuso}&&dojo={$iddojo}&&mostrar=all&&ord=desc&&campo=nombre'>Gestionar alumnos</a>
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
                            <a class='dropdown-item' href='altausuario.php?usuario={$idenuso}'>Nuevo Usuario</a>
                        </div>
                    </li>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <span class='text-light bg-dark'>Tesorería</span></a>
                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                            <a class='dropdown-item' href='#'>Ingresos</a>
                            <a class='dropdown-item' href='#'>Gastos</a>
                        
                            <div class='dropdown-divider'></div>
                                <a class='dropdown-item' href='#'>Balance</a>
                            </div>
                        </div>
                    </li>
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
    
    echo "<div class='form-group'>";
    echo "<br>";
    echo "<label class='nav-item'><h6>Usuario: ".$nombreusuario."</h6></label><br>";
    echo "<label class='nav-item'><h6>Dojo: ".$dojo."</h6></label><br>";

    //compruebo que el usuario sea administrador u oficina
    //muestro los entrenadores y otros usuarios que tiene el centro
    if(strcmp($rolenuso,"administrador")==0)//añadir oficina
    {
        $query = "SELECT iddojo FROM dojo where iddojo<>{$iddojo}";
        //echo $query;
        $resp = mysqli_fetch_array(mysqli_query($enlace,$query));
        $cambiodojo = $resp['iddojo'];
    
        if($estado=="alta")
        {
            echo " <a href='gestionardojo.php?dojo={$iddojo}&&usuario={$idusuario}&&estado=baja' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Usuarios de baja</a>";
            //echo "<a href='gestionarusuario.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Gestionar Clases</a>";

        }
        //echo "<a href='gestionardojo.php?dojo={$iddojo}&&usuario={$idusuario}&&ord={$ord}&&campo=nombre&&mostrar=1' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Mostrar Federados</a>";
        //echo "<a href='gestionardojo.php?dojo={$iddojo}&&usuario={$idusuario}&&ord={$ord}&&campo=nombre&&mostrar=2' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Mostrar Judoliga</a>";
        //echo "<a href='gestionardojo.php?dojo={$iddojo}&&usuario={$idusuario}&&ord={$ord}&&campo=nombre&&mostrar=3' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Mostrar No Competición</a>";
        //echo "<a href='gestionardojo.php?dojo={$iddojo}&&usuario={$idusuario}&&ord={$ord}&&campo=nombre&&mostrar=all' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Mostrar Todos</a>";
        echo "<a href='gestionarusuarios.php?dojo={$cambiodojo}&&usuario={$idusuario}&&ord={$ord}&&campo=nombre&&mostrar=all' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Cambiar Dojo</a>";
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
                echo "<th class='table-dark' scope='col'colspan='3'><a href='gestionarusuarios.php?dojo={$iddojo}&&usuario={$idusuario}&&ord={$ord}&&campo=nombre' class='btn btn-secondary'>Usuario</a></th>";
                echo "<th class='table-dark' scope='col'>Teléfono</th>";
                echo "<th class='table-dark' scope='col'>Email</th>";
                echo "<th class='table-dark' scope='col'> <a href='gestionardojo.php?dojo={$iddojo}&&usuario={$idusuario}&&ord={$ord}&&campo=dateborn' class='btn btn-secondary'>Tipo de Usuario</a></th>";
                echo "<th class='table-dark' scope='col' colspan='6' class='text-center'><center>Operaciones</center></th>";
            echo "</tr>";  
        echo "</thead>";
        echo "<tbody>";
            echo "<tr>";
                //SELECT USUARIOS DEL DOJO EN CUESTION.
                $query = "SELECT * FROM usuarios WHERE estado='{$estado}' ORDER BY {$campo} {$ord}";
                //echo $query."<br>";
                $respuesta = mysqli_query($enlace,$query);
                //print_r($respuesta);
                while ($row = mysqli_fetch_assoc($respuesta))
                {
                    $query = "SELECT * FROM tipo_usuario WHERE idtipo={$row['tipousuario']}";
                    //echo $query."<br>";
                    $tipo = mysqli_fetch_array(mysqli_query($enlace,$query));
                    $id = $row['idusuario'];
                    $usuario = $row['nombre']." ".$row['apellido1']." ".$row['apellido2'];
                    $telefono = $row['telefono'];     
                    $email = $row['email'];
                    $tipousuario = $tipo['tipousuario'];
                    echo "<tr >";
                    echo " <th scope='row' colspan='3'>{$usuario}</th>";
                    echo " <td> {$telefono}</td>";
                    echo " <td class='table-dark'>{$email} </td>";
                    echo " <td class='table-dark'>{$tipousuario} </td>";                   

                    if(strcmp($rolenuso,"administrador")==0)
                    {
                        if (strcmp($estado,"baja")==0)
                        {
                            echo " <td class='text-center'> <a href='verelemento.php?dojo={$iddojo}&&idelemento={$id}&&estado=baja' class='btn btn-primary'> <i class='bi bi-eye'></i> Ver</a> </td>";
                            echo " <td class='text-center' > <a href='bajaalumno.php?dojo={$iddojo}&&alta={$id}' class='btn btn-danger' ><i class='bi bi-pencil'></i> Volver dar Alta</a> </td>";
                        }else
                        {
                            echo " <td class='text-center'> <a href='verelemento.php?dojo={$iddojo}&&idelemento={$id}&&estado=alta' class='btn btn-primary'> <i class='bi bi-eye'></i> Ver</a> </td>";
                            echo " <td class='text-center' > <a href='editaralumno.php?dojo={$iddojo}&&idalumno={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
                            echo " <td class='text-center'>  <a href='bajaalumno.php?dojo={$iddojo}&&eliminar={$id}' class='btn btn-danger' > <i class='bi bi-trash'></i> Dar de Baja</a> </td>";
                        }
                    
                
                    }/*else if(strcmp($rolenuso,"entrenador")==0)
                    {
                        echo " <td class='text-center' > <a href='editarincidencia.php?editar&incidencia_id={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
                    }*/
                    echo " </tr> ";
                    
                }
                echo "</tr>";  
            echo "</tbody>";
        echo "</table>";
        echo "</div>";

    }

}

mysqli_close($enlace);
include "pie.php";
?>