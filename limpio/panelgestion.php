<?php
session_start();
if (!array_key_exists("usuario_id",$_SESSION)){
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA

$nombreusuario = $_SESSION['usuario_nombre'];
$idenuso = $_SESSION['usuario_id'];
$rolenuso = $_SESSION['usuario_rol'];

include "conexion.php";
include "cabecera.php";

if (isset($_GET['usuario']))
{
    
    $idusuario = htmlspecialchars($_GET['usuario']);
    
    echo "<div class='form-group'>";

        echo "<h1 class='text-center' >Gestión de incidencias (CRUD). Panel Administrador.</h1>";
        echo "<div>";
            echo "<p class='usuario'>Usuario: ".$nombreusuario."</p>";
        echo "</div>";
        echo "<a href='creaincidencia.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Añadir Incidencia</a>";
        if(strcmp($rolenuso,"administrador"))
        {
            echo " <a href='crearusuario.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Añadir Usuario</a>";
            echo "<a href='bajausuario.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Eliminar Usuario</a>";
            echo "<a href='gestionaraulas.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Gestionar Aulas y Plantas</a>";
        }     
        
        echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<thead class='table table-striped'>";
                echo "<tr>";
                    
                    echo "<th class='table-dark' scope='col'>Usuario</th>";
                    echo "<th class='table-dark' scope='col'>Planta</th>";
                    echo "<th class='table-dark' scope='col'>Aula</th>";
                    echo "<th class='table-dark' scope='col'>Descripción</th>";
                    echo "<th class='table-dark' scope='col'>Fecha alta</th>";
                    echo "<th class='table-dark' scope='col'>Fecha revisión</th>";
                    echo "<th class='table-dark' scope='col'>Fecha solución</th>";
                    echo "<th class='table-dark' scope='col'>Comentario</th>";
                    echo "<th class='table-dark' scope='col' colspan='3' class='text-center'>Operaciones</th>";
                echo "</tr>";  
            echo "</thead>";
            echo "<tbody>";
                echo "<tr>";
                    //SELECT DE INCIDENCIAS no resueltas Y MOSTRARLAS
                    $query = "SELECT * FROM incidencias2 WHERE fecha_resol is null";               
                    $vista_incidencias = mysqli_query($enlace,$query);

                    while($row = mysqli_fetch_assoc($vista_incidencias))
                    {

                        $id = $row['idincidencia'];
                          
                        $query = "SELECT * FROM usuarios2 WHERE idusuario =".$row['idusuario'];
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
                            echo " <td class='text-center'> <a href='../acciones/verincidencia.php?incidencia_id={$id}' class='btn btn-primary'> <i class='bi bi-eye'></i> Ver</a> </td>";

                            if(strcmp($rolenuso,"administrador"))
                            {
                                echo " <td class='text-center' > <a href='editarincidencia.php?editar&incidencia_id={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
                                echo " <td class='text-center'>  <a href='borrarincidencia.php?eliminar={$id}' class='btn btn-danger' > <i class='bi bi-trash'></i> Eliminar</a> </td>";
                            
                            }else if(strcmp($rolenuso,"direccion"))
                            {
                                echo " <td class='text-center' > <a href='editarincidencia.php?editar&incidencia_id={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
                            }
                            
                        echo " </tr> ";
                           
                    }
                echo "</tr>";  
            echo "</tbody>";
        echo "</table>";
        echo "<div class='form-group'>";
            include "conexion.php";
            $query = "SELECT count(*) numero from incidencias2 WHERE fecha_resol is not null";
            $resultado = mysqli_query($enlace,$query);
            $sinresolver = mysqli_fetch_array($resultado);
            $numsinres = count($sinresolver);

            $query = "SELECT count(*) numero from incidencias2 WHERE fecha_resol is null";
            $resultado = mysqli_query($enlace,$query);
            $resueltas = mysqli_fetch_array($resultado);
            $numresu = count($resueltas);

                echo "<p class='edicion'>Incidencias resueltas: ". $numresu." incidencias </p>";
                echo "<p class='edicion'>Incidencias pendientes de resolver: ".$numsinres." incidencias </p>";
        echo "</div>";
    echo "</div>";
    mysqli_close($enlace);
    echo "<div class='container text-center mt-5'>";
      echo "<a href='logout.php' class='btn btn-warning mt-5'> Salir </a>";
    echo "</div>";
     
}

include "pie.php";
?>