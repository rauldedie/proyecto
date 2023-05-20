<?php include "header.php"?>

    <div class="container">
        <h1 class="text-center" >Gestión de incidencias (CRUD)</h1>
        <a href="create.php" class='btn btn-outline-dark mb-2'> <i class="bi bi-person-plus"></i> Añadir incidencia</a>
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <!--<th  scope="col">ID</th>-->
                    <th  scope="col">Usuario</th>
                    <th  scope="col">Planta</th>
                    <th  scope="col">Aula</th>
                    <th  scope="col">Descripción</th>
                    <th  scope="col">Fecha alta</th>
                    <th  scope="col">Fecha revisión</th>
                    <th  scope="col">Fecha solución</th>
                    <th  scope="col">Comentario</th>
                    <th  scope="col" colspan="3" class="text-center">Operaciones</th>
                </tr>  
            </thead>
            <tbody>
                <tr>
 
                    <?php
                        $query = "SELECT * FROM incidencias2";               
                        $vista_incidencias = mysqli_query($enlace,$query);

                        while($row = mysqli_fetch_assoc($vista_incidencias))
                        {
                            $id=ro['idincidencia'];
                            $queryIncidencia = printf("SELECT nombre FROM usuarios2 WHERE idnombre='%s'",$row['idusuario']);
                            $usuario_incidencia = mysqli_query($enlace,$queryIncidencia);
                            $queryIncidencia = printf("SELECT idplanta, aula FROM aulas2 WHERE idaula='%s'",$row['idaula']);
                            $consultaAula =  mysqli_fetch_array(mysqli_query($enlace,$queryIncidencia));
                            $queryIncidencia = printf("SELECT planta FROM plantas2 WHERE idplanta='%s'",$consultaAula['idplanta']);               
                            $planta = mysqli_query($enlace,$queryIncidencia);    
                            $aula = $consultaAula['aula'];      
                            $descripcion = $row['descripcion'];        
                            $fecha_alta = $row['fecha_alta'];        
                            $fecha_rev = $row['fecha_mod'];        
                            $fecha_sol = $row['fecha_sol'];        
                            $comentario = $row['comentario']; 
                            echo "<tr >";
                                echo " <th scope='row' >{$usuario_incidencia}</th>";
                                echo " <td > {$planta}</td>";
                                echo " <td > {$aula}</td>";
                                echo " <td >{$descripcion} </td>";
                                echo " <td >{$fecha_alta} </td>";
                                echo " <td >{$fecha_rev} </td>";
                                echo " <td >{$fecha_sol} </td>";
                                echo " <td >{$comentario} </td>";
                                echo " <td class='text-center'> <a href='view.php?incidencia_id={$id}' class='btn btn-primary'> <i class='bi bi-eye'></i> Ver</a> </td>";
                                echo " <td class='text-center' > <a href='update.php?editar&incidencia_id={$id}' class='btn btn-secondary'><i class='bi bi-pencil'></i> Editar</a> </td>";
                                echo " <td class='text-center'>  <a href='delete.php?eliminar={$id}' class='btn btn-danger'> <i class='bi bi-trash'></i> Eliminar</a> </td>";
                            echo " </tr> ";
                        }  
                    ?>
                </tr>  
            </tbody>
        </table>
    </div>
    <div class="container text-center mt-5">
      <a href="index.php?Logout=1" class="btn btn-warning mt-5"> Salir </a>
    <div>
<?php include "pie.php" ?>