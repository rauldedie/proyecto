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
$tiempo = $_SESSION['tiempo_ultima_conexion'];

include "conexion.php"; 
include "cabecera.php";

if (isset($_GET['usuario']))
{
    if(isset($_GET['mostrar']))
    {
        $mostrar = htmlspecialchars($_GET['mostrar']);
        if (strcmp($mostrar,'resueltas')==0)
        {
            $mostrar = "not null";
        }

    }else
    {
        $mostrar = "null";
    }

    //establezco campo y ordenacion 
    //la primera vez, al hacer login viene establecido, el resto segun decida el usuario
    //de vuelta de otra pagina el orden siempre sera asc y por el campo idincidencia
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
    
    $idusuario = htmlspecialchars($_GET['usuario']);

    
    echo "<div class='form-group'>";

        echo "<h1 class='text-center' >Gestión de incidencias (CRUD). Panel Administrador.</h1>";
        echo "<div>";
            echo "<p class='usuario'>Usuario: ".$nombreusuario."</p>";
            echo "<p class='usuario'>Tiempo desde última conexión: ".$tiempo;
        echo "</div>";
        echo "<a href='creaincidencia.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-bullseye'></i> Añadir Incidencia</a>";
        echo "<a href='cambiarpass.php?idusuario={$idenuso}' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Cambiar mi Contraseña</a>";
        if(strcmp($rolenuso,"administrador")==0)
        {
            //echo " <a href='crearusuario.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Añadir Usuario</a>";
            echo "<a href='gestionarusuario.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Gestionar Usuario</a>";
            echo "<a href='gestionaraulas.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-building'></i> Gestionar Aulas y Plantas</a><br>";
            echo " <a href='panelgestion.php?usuario={$idusuario}&&mostrar=resueltas' class='btn btn-outline-dark mb-2'> <i class='bi bi-calendar-plus'></i> Mostrar Incidencias Resueltas</a>";
            echo " <a href='panelgestion.php?usuario={$idusuario}' class='btn btn-outline-dark mb-2'> <i class='bi bi-calendar-minus'></i> Mostrar Incidencias Pendientes</a>";
        }
        if (strcmp($ord,"asc")==0)
        {
            $ord="desc";
        }else
        {
            $ord="asc";
        }   
        
        echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<thead class='table table-striped'>";
                echo "<tr>";
                    
                    echo "<th class='table-dark' scope='col'><a href='panelgestion.php?usuario={$idusuario}&&ord={$ord}&&campo=nombre' class='btn btn-secondary'>Usuario</a></th>";
                    echo "<th class='table-dark' scope='col'><a href='panelgestion.php?usuario={$idusuario}&&ord={$ord}&&campo=planta' class='btn btn-secondary'>Planta</a></th>";
                    echo "<th class='table-dark' scope='col'><a href='panelgestion.php?usuario={$idusuario}&&ord={$ord}&&campo=aula' class='btn btn-secondary'>Aula</a></th>";
                    echo "<th class='table-dark' scope='col'>Descripción</th>";
                    echo "<th class='table-dark' scope='col'> <a href='panelgestion.php?usuario={$idusuario}&&ord={$ord}&&campo=fecha_alta' class='btn btn-secondary'>Fecha alta</a></th>";
                    echo "<th class='table-dark' scope='col'><a href='panelgestion.php?usuario={$idusuario}&&ord={$ord}&&campo=fecha_mod' class='btn btn-secondary'>Fecha revisión</a></th>";
                    echo "<th class='table-dark' scope='col'><a href='panelgestion.php?usuario={$idusuario}&&ord={$ord}&&campo=fecha_resol' class='btn btn-secondary'>Fecha solución</a></th>";
                    echo "<th class='table-dark' scope='col'>Comentario</th>";
                    echo "<th class='table-dark' scope='col' colspan='3' class='text-center'>Operaciones</th>";
                echo "</tr>";  
            echo "</thead>";
            echo "<tbody>";
                echo "<tr>";
                    //SELECT DE INCIDENCIAS no resueltas Y MOSTRARLAS
                    $query = "SELECT nombre,apellidos,idincidencia,planta,aula,descripcion,fecha_alta,fecha_mod,fecha_resol,comentario 
                    from incidencias2 i,usuarios2 u,plantas2 p,aulas2 a 
                    WHERE u.idusuario=i.idusuario AND a.idaula=i.idaula AND p.idplanta=a.idplanta and i.fecha_resol is {$mostrar} ORDER BY {$campo} {$ord}";
                    //$query = "SELECT * FROM incidencias2 WHERE fecha_resol is {$mostrar} order by {$campo} {$ord} ";              
                    $vista_incidencias = mysqli_query($enlace,$query);
                    
                    while($row = mysqli_fetch_assoc($vista_incidencias))
                    {

                        $id = $row['idincidencia'];
                          
                        /*$query = "SELECT * FROM usuarios2 WHERE idusuario =".$row['idusuario'];
                        $usuario_inci = mysqli_fetch_array(mysqli_query($enlace,$query));                  
                        
                        $query = "SELECT * FROM aulas WHERE idaula =".$row['idaula'];                        
                        $aula_inci =  mysqli_fetch_array(mysqli_query($enlace,$query));
                            
                        $query = "SELECT * FROM plantas2 WHERE idplanta =".$aula_inci['idplanta'];                            
                        $planta_inci = mysqli_fetch_array(mysqli_query($enlace,$query));

                        $usuario = $usuario_inci['nombre']." ".$usuario_inci['apellidos'];
                        $aula = $aula_inci['aula'];
                        $planta = $planta_inci['planta'];      
                        $descripcion = $row['descripcion'];        
                        $fecha_alta = $row['fecha_alta'];        
                        $fecha_rev = $row['fecha_mod'];        
                        $fecha_sol = $row['fecha_resol'];        
                        $comentario = $row['comentario'];*/
                        $usuario = $row['nombre']." ".$row['apellidos'];
                        $aula = $row['aula'];
                        $planta = $row['planta'];
                        $descripcion = $row['descripcion'];        
                        $fecha_alta = $row['fecha_alta'];        
                        $fecha_rev = $row['fecha_mod'];        
                        $fecha_sol = $row['fecha_resol'];        
                        $comentario = $row['comentario'];

                        echo "<tr >";
                            echo " <th scope='row' >{$usuario}</th>";
                            echo " <td > {$planta}</td>";
                            echo " <td > {$aula}</td>";
                            echo " <td >{$descripcion} </td>";
                            echo " <td >{$fecha_alta} </td>";
                            echo " <td >{$fecha_rev} </td>";
                            echo " <td >{$fecha_sol} </td>";
                            echo " <td >{$comentario} </td>";
                            echo " <td class='text-center'> <a href='verincidencia.php?incidencia_id={$id}' class='btn btn-primary'> <i class='bi bi-eye'></i> Ver</a> </td>";

                            if(strcmp($rolenuso,"administrador")==0)
                            {
                                echo " <td class='text-center' > <a href='editarincidencia.php?editar&incidencia_id={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
                                echo " <td class='text-center'>  <a href='borrarincidencia.php?eliminar={$id}' class='btn btn-danger' > <i class='bi bi-trash'></i> Eliminar</a> </td>";
                            
                            }else if(strcmp($rolenuso,"direccion")==0)
                            {
                                echo " <td class='text-center' > <a href='editarincidencia.php?editar&incidencia_id={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
                            }
                            
                        echo " </tr> ";
                           
                    }
                echo "</tr>";  
            echo "</tbody>";
        echo "</table>";
        echo "<div class='form-group'>";

            $query = "SELECT count(idincidencia) numero from incidencias2 WHERE fecha_resol is not null";
            $resueltas = mysqli_fetch_array(mysqli_query($enlace,$query));

            $query = "SELECT count(idincidencia) numero from incidencias2 WHERE fecha_resol is null";
            $inresolver = mysqli_fetch_array(mysqli_query($enlace,$query));
            $total = $inresolver['numero']+$resueltas['numero'];

            echo "<p class='edicion'>Incidencias resueltas: ". $resueltas['numero']." incidencias.<br>";
            echo "Incidencias pendientes de resolver: ".$inresolver['numero']." incidencias.<br>";
            echo "Total Incidencias : ". $total." incidencias </p>";
        echo "</div>";
    echo "</div>";
    mysqli_close($enlace);
    echo "<div class='container text-center mt-5'>";
      echo "<a href='logout.php' class='btn btn-warning mt-5'> Salir </a>";
    echo "</div>";
     
}

include "pie.php";
?>