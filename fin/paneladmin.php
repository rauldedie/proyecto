<?php 
    include ("cabecerapanel.php");

    $servidor = "217.76.150.73";
    $usuario = "qahx080"; 
    $passwd = "1smer1l10N"; 
    $bd = "qahx080"; 
    $enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);

    if(!$enlace)
    {
        echo "Conexion fallida: ".mysqli_connect_error();

    }

    ?>

    <div class="container">
        <h1 class="text-center" >Gestión de incidencias (CRUD)</h1>
        <div>
        <a href="create.php" class='btn btn-outline-dark mb-2'> <i class="bi bi-person-plus"></i> Añadir incidencia</a>
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    
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

                        $query = sprintf("SELECT * FROM incidencias2");               
                        $vista_incidencias = mysqli_query($enlace,$query);
                        $row=mysqli_fetch_array($vista_incidencias);
                        
                        while($row = mysqli_fetch_assoc($vista_incidencias))
                        {
                            $id = $row['idincidencias'];
                            
                            $query2 = sprintf("SELECT * FROM usuarios2 WHERE idusuario='%s'",$row['idusuario']);
                            $usuario = mysqli_fetch_array(mysqli_query($enlace,$query2));

                            $query2 = sprintf("SELECT * FROM aulas2 WHERE idaula='%s'",$row['idaula']);
                            $aula =  mysqli_fetch_array(mysqli_query($enlace,$query2));

                            $query2 = sprintf("SELECT * FROM plantas2 WHERE idplanta='%s'",$aula['idplanta']);               
                            $planta = mysqli_fetch_array(mysqli_query($enlace,$query2));

                            $aula_inc = $aula['aula'];
                            $planta_inc = $planta['planta'];
                            $usuario_inc = $usuario['nombre'];      
                            $descripcion = $row['descripcion'];        
                            $fecha_alta = $row['fecha_alta'];        
                            $fecha_rev = $row['fecha_mod'];        
                            $fecha_sol = $row['fecha_resol'];        
                            $comentario = $row['comentario']; 

                            echo "<tr >";
                                echo " <th scope='row' >{$usuario_inc}</th>";
                                echo " <td > {$planta_inc}</td>";
                                echo " <td > {$aula_inc}</td>";
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
    </div>
 <?php include ("piepanel.php") ?>