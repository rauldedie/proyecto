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


include "conexion.php";
$nombreusuario = $_SESSION['usuario_nombre'];
$idenuso = $_SESSION['usuario_id'];
$rolenuso = $_SESSION['usuario_rol'];

$query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idenuso} and u.tipousuario=t.idtipo and u.estado='alta'";
$fila = mysqli_fetch_array(mysqli_query($enlace,$query));

if (strcmp($fila['tipo'],"administrador")!=0)
{
    echo "<script>window.location='logout.php;</script>";
}else
{
    if(isset($_GET['dojo']))
    {
        $iddojo = htmlspecialchars(stripslashes($_GET['dojo']));

    }else $iddojo = 1;

    if(isset($_GET['ord']))
    {
        $ord = htmlspecialchars(stripslashes($_GET['ord']));

    }else $ord = "desc";

    if(isset($_GET['campo']))
    {
        $campo = htmlspecialchars(stripslashes($_GET['campo']));

    }else $campo = "nombre";

    if(isset($_GET['mostrar']))
    {
        $mostrar = htmlspecialchars(stripslashes($_GET['mostrar']));

    }else $mostrar = "all";
  

    //Obtengo nombre dojo
    $query = "SELECT * FROM dojo WHERE iddojo={$iddojo}";

    $dojo = mysqli_fetch_array(mysqli_query($enlace,$query));
    
    $nombredojo = $dojo['nombre']; 
    if (isset($_GET['dia']) && isset($_GET['hora']))
    {
        $iddia = htmlspecialchars(stripslashes($_GET['dia']));
        $idhora = htmlspecialchars(stripslashes($_GET['hora']));

        include "cabecera.php";
        //Muestro menu de la pagina
        echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>";
            echo"<p><img class='logo' src='logolitho.jpg'></p>";
            echo "<label class='navbar-brand'><span class='text-light bg-dark'>GESTION CLASES</span></label>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav mr-auto'>

                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='gestionardojo.php?dojo={$iddojo}&&mostrar=all&&ord=desc&&campo=nombre&&usuario={$rolenuso}' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <span class='text-light bg-dark'>Gestionar Alumnos</span>
                        </a>
                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                            <a class='dropdown-item' href='gestionardojo.php?dojo={$iddojo}&&mostrar=all&&ord=desc&&campo=nombre&&usuario={$rolenuso}'>Gestionar alumnos</a>
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
                                <a class='dropdown-item' href='#'>Balance</a>
                            </div>
                        </div>
                    </li>
                    <li class='nav-item'>
                        <a class='navbar-brand' href='gestionardojo.php?dojo={$iddojo}&&usuario={$idenuso}'><span class='text-primary'>VOLVER</span></a>
                    </li>
                    <li class='nav-item'>
                        <a class='navbar-brand' href='logout.php'><span class='text-warning'>SALIR</span></a>
                    </li>
                </ul>    
            </div>
        </nav><br>";

        echo "<label class='nav-item'><h6>Usuario: ".$nombreusuario."</h6></label><br>";
        echo "<label class='nav-item'><h6>Dojo: ".$nombredojo."</h6></label><br>";

        $query = "SELECT iddojo FROM dojo where iddojo<>{$iddojo}";
        //echo $query;
        $resp = mysqli_fetch_array(mysqli_query($enlace,$query));
        $cambiodojo = $resp['iddojo'];

        echo "<a href='gestionarclases.php?dojo={$iddojo}&&dia={$iddia}&&hora={$idhora}&&usuario={$idusuario}&&mostrar=1' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Mostrar Federados</a>";
        echo "<a href='gestionarclases.php?dojo={$iddojo}&&dia={$iddia}&&hora={$idhora}&&usuario={$idusuario}&&mostrar=2' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Mostrar Judoliga</a>";
        echo "<a href='gestionarclases.php?dojo={$iddojo}&&dia={$iddia}&&hora={$idhora}&&usuario={$idusuario}&&mostrar=3' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Mostrar No Competición</a>";
        echo "<a href='gestionarclases.php?dojo={$iddojo}&&dia={$iddia}&&hora={$idhora}&&usuario={$idusuario}&&mostrar=all' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Mostrar Todos</a>";
        echo "<a href='gestionarclases.php?dojo={$cambiodojo}&&dia={$iddia}&&hora={$idhora}' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Cambiar Dojo</a>"; 

        //Obtengo el dia y la hora correspondiente en texto
        $query = "SELECT diaclase FROM diasclases
        WHERE iddiaclase={$iddia}";
        //echo $query."<br>";
        $diaclase = mysqli_fetch_array(mysqli_query($enlace,$query));
        
        $query = "SELECT hora FROM horasclases
        WHERE idhoraclase={$idhora}";
        //echo $query."<br>";
        $horaclase = mysqli_fetch_array(mysqli_query($enlace,$query));
        
        
        //Miro que clase es el dia y la hora y el entrenador
        $query = "SELECT * FROM clases   
        WHERE iddiaclase={$iddia} and idhoraclase={$idhora} and iddojo={$iddojo}";
        //echo $query."<br>";
        $clase = mysqli_fetch_array(mysqli_query($enlace,$query));

        $query = "SELECT u.nombre from usuarios u, entrenadores e
        where e.identrenador = {$clase['identrenador']} and
        u.idusuario = e.idusuario";
        //echo $query."<br>";
        $entrenador =  mysqli_fetch_array(mysqli_query($enlace,$query));

        //Vemos que la clase no esta vacia
        $query = "SELECT * FROM alumnos
        WHERE idclase={$clase['idclase']} and estado='alta'";
        //echo $query."<br>";
        $alumnos =  mysqli_fetch_array(mysqli_query($enlace,$query));

        if (strcmp($alumnos['idalumno'],"")==0)
        {
            echo "<p>En la clase ".$diaclase['diaclase']." de ".$horaclase['hora']." no hay alumnos.</p>";

        }else
        {
            //Obtengo listado de la clase
            if(strcmp($mostrar,"all")==0)
            {
                $query = "SELECT *
                FROM alumnos a
                WHERE a.idclase={$clase['idclase']} and iddojo={$iddojo} and estado='alta'
                order by '{$campo}' '{$ord}'";
            }else
            {
                $query = "SELECT *
                FROM alumnos a
                WHERE a.idclase={$clase['idclase']} and competicion={$mostrar} and iddojo={$iddojo} and estado='alta'
                order by '{$campo}' '{$ord}'";                
            }


            //echo $query."<br>";
            $resp = mysqli_query($enlace,$query);


            echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<thead class='table table-striped'>";
                echo "<tr>";
                    echo "<th class='table-dark' scope='col'>Alumnos clase {$diaclase['diaclase']} de {$horaclase['hora']} con {$entrenador['nombre']}</th>";
                    echo "<th class='table-dark' scope='col'>Poner Faltas</th>";
                    echo "<th class='table-dark' scope='col'>Competición</th>";
                    echo "<th class='table-dark' scope='col'>Kyu</th>";
                    echo "<th class='table-dark' scope='col'>Categoría</th>";
                echo "</tr>";  
            echo "</thead>";
            echo "<tbody>";

            while ($lista = mysqli_fetch_assoc($resp))
            {
                //muestro listado de la clase
                $nombre = $lista['nombre']." ".$lista['apellido1']." ".$lista['apellido2'];
                $idclase = $lista['idclase'];
                $idalumno = $lista['idalumno'];
                echo "<tr>";

                    //Escribo el nombre del alumno
                    echo " <td>{$nombre}</td>";
                    //echo " <td>{$idalumno}</td>";

                    //Pongo el boton de faltas
                    echo " <td class='table-dark'> <a href='ponerfalta.php?clase={$idclase}&&falta=1&&alumno={$idalumno}&&dia={$iddia}&&hora={$idhora}&&dojo={$iddojo}&&usu={$idenuso}' class='btn btn-primary'> <i class='bi-check-circle-fill'></i> FALTAS ASISTENCIA </a> </td>";

                    //averiguo la competicion del alumno
                    $query = "SELECT * from competiciones where idcompeticion={$lista['competicion']}";
                    $comp = mysqli_fetch_array(mysqli_query($enlace,$query));
                    $competicion = $comp['competicion'];
                    echo " <td class='table-dark'>{$competicion}</td>";

                    //averiguo kyu del alumno
                    $query = "SELECT * from nivel where idnivel={$lista['idnivel']}";
                    //echo $query."<br>";
                    $nivel = mysqli_fetch_array(mysqli_query($enlace,$query));
                    
                    $kyu = $nivel['color'];

                    echo " <td class='table-dark'>{$kyu}</td>";

                    //averiguo categoria
                    $fechaentera = strtotime($lista['dateborn']);
                    $anio = date("Y",$fechaentera);                        
                    $diferencia = $hoy-$anio;
                    if ($diferencia < 9) $categoria = "Prebenjamín";
                    else if ( $diferencia<11 ) $categoria = "Benjamín";
                    else if ($diferencia<13) $categoria = "Alevín";
                    else if ($diferencia<15) $categoría = "Infantil";
                    else if ($diferencia<18) $categoria = "Cadete";
                    else if ($diferencia<21) $categoria = "Junior";
                    else $categoria = "Senior";

                    echo " <td class='table-dark'>{$categoria}</td>";     
                echo "</tr>";
                //$i++;
            }
                //echo "<input hidden value={$i} name='filastotal'>";
                //echo " <tr> <td class='text-center' colspan='6'> <button type='submit' class='btn btn-warning' name='cambioclase'><i class='bi bi-pencil'></i>Confirmar cambios de clase</button> </td></tr>";
                echo "</tbody>";
                echo "</table>";
            echo "</form>";
        }
 
        include "pie.php";
    }
    mysqli_close($enlace);
    
}

?>