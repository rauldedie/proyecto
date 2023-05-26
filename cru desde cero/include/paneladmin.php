<?php
//include "encriptar.php";//Datos de encriptacion y desencriptacion
if (isset($_GET['rol']))
{

    if(isset($_SESSION["timeout"]))
    {
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad)
        {
            session_destroy();
            header("Location: /include/logout.php");
        }
    }else
    {
        include "conexion.php";
        if(isset($_SESSION['idusuario']))
        {
            //segun el id busco el rol que le corresponde
            //$idusuario = $_SESSION['idusuario'];
            $query = "SELECT rol from usuarios2 WHERE idusuario = {$idusuario}";
            $resultado = mysqli_query($enlace,$query);
            echo $resultado;
            if(!$resultado)
            {
                session_destroy();
                header("Location: /include/logout.php");
                    
            }else
            {
                //cargo el panel de administracion correspondiente
                $rol = $resultado;
                include "header.php";
                echo "<div class='form-group'>";
                    echo "<a href='./acciones/createadmin.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Añadir Incidencia</a>";
                    if ($rol='administrador')
                    {
                        echo"<a href='./acciones/altausuario.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Añadir Usuario</a>";
                        echo"<a href='./acciones/bajausuario.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Eliminar Usuario</a>";
                        echo"<a href='./acciones/gestionaraulas.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Gestionar Aulas y Plantas</a>";
                    }
                    echo"<table class='table table-striped table-bordered table-hover'>";
                        echo"<thead class='table table-striped'>";
                            echo"<tr>";
                            
                                echo"<th class='table-dark' scope='col'>Usuario</th>";
                                echo"<th class='table-dark' scope='col'>Planta</th>";
                                echo"<th class='table-dark' scope='col'>Aula</th>";
                                echo"<th class='table-dark' scope='col'>Descripción</th>";
                                echo"<th class='table-dark' scope='col'>Fecha alta</th>";
                                echo"<th class='table-dark' scope='col'>Fecha revisión</th>";
                                echo"<th class='table-dark' scope='col'>Fecha solución</th>";
                                echo"<th class='table-dark' scope='col'>Comentario</th>";
                                echo"<th class='table-dark' scope='col' colspan='3' class='text-center'>Operaciones</th>"
                            echo"</tr>";  
                        echo"</thead>"
                    echo"<tbody>";
                    echo"<tr>";
                        $query = "SELECT * FROM incidencias";               
                        $vista_incidencias = mysqli_query($enlace,$query);

                        while($row = mysqli_fetch_assoc($vista_incidencias))
                        {

                            $id = $row['idincidencias'];
                           
                            $query = "SELECT * FROM usuarios2 WHERE idusuario =".$row['idusuario'];
                            //$query = sprintf("SELECT * FROM usuarios2 WHERE idusuario ='%i'",$row['idusuario']);
                            $usuario_inci = mysqli_fetch_array(mysqli_query($enlace,$query));                  
                            
                            $query = "SELECT * FROM aulas WHERE idaula =".$row['idaula'];
                            //$query = sprintf("SELECT * FROM aulas2 WHERE idaula ='%i'".$row['idaula']);
                            $aula_inci =  mysqli_fetch_array(mysqli_query($enlace,$query));
                            
                            $query = "SELECT * FROM plantas2 WHERE idplanta =".$aula_inci['idplanta'];
                            //$query = sprintf ("SELECT * FROM plantas2 WHERE idplanta ='%i'".$aula_inci['idplanta']);
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
                                echo " <td class='text-center'> <a href='./acciones/viewadmin.php?incidencia_id={$id}' class='btn btn-primary'> <i class='bi bi-eye'></i> Ver</a> </td>";
                                if($rol=='administrador' OR $rol=='direccion')
                                {
                                    echo " <td class='text-center' > <a href='./acciones/update.php?editar&incidencia_id={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
                                } 
                                if ($rol=='administrador')
                                {
                                    echo " <td class='text-center'>  <a href='./acciones/borrarincidencia.php?eliminar={$id}' class='btn btn-danger' > <i class='bi bi-trash'></i> Eliminar</a> </td>";
                                }                     
                            echo " </tr> ";
                        
                        }
                    echo "</tr>";  
                    echo"</tbody>";
                echo"</table>";
                echo"</div>";
                    echo"<div class='container text-center mt-5'>";
                    echo"<a href='logout.php' class='btn btn-warning mt-5'> Salir </a>";
                echo"</div>";               
                
            }
        }
    }
}     
include "footer.php"; 
?>
