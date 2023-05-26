<?php include "header.php";

/*echo $_SESSION['rol']."<br>";
echo $_SESSION['usuario_id']."<br>";
echo $_SESSION['usuario_nombre']."<br>";
echo $_COOKIE['rol']."<br>";
echo $_COOKIE['usuario_id']."<br>";
echo $_COOKIE['usuario_nombre']."<br>";*/
?>


<!--NECESITO SESION O COOCKIE PARA SABER EL USUARIO PARA QUE CREAR LA INCIDENCIA CON EL ID DE USUARIO 
PARA INDICAR EL USUARIO QUE ESTA EN SESION Y PARA TIEMPO DESDE LA ULTIMA CONEXION
ADEMAS PARA NO REPTIR CODIGO YA QUE AL VOLVER TENDRIA QUE INDICAR A QUE PANEL VUELVE AL ADMIN, AL DIRECCION O AL PROFESORADO-->
    <div class="form-group">
        <h1 class="text-center" >Gestión de incidencias (CRUD). Panel General.</h1>
        <a href="./acciones/createadmin.php" class='btn btn-outline-dark mb-2'> <i class="bi bi-person-plus"></i> Añadir Incidencia</a>
        <a href="./acciones/altausuario.php" class='btn btn-outline-dark mb-2'> <i class="bi bi-person-plus"></i> Añadir Usuario</a>
        <a href="./acciones/bajausuario.php" class='btn btn-outline-dark mb-2'> <i class="bi bi-person-plus"></i> Eliminar Usuario</a>
        <a href="./acciones/gestionaraulas.php" class='btn btn-outline-dark mb-2'> <i class="bi bi-person-plus"></i> Gestionar Aulas y Plantas</a>
        <table class="table table-striped table-bordered table-hover">
            <thead class="table table-striped">
                <tr>
                    
                    <th class="table-dark" scope="col">Usuario</th>
                    <th class="table-dark" scope="col">Planta</th>
                    <th class="table-dark" scope="col">Aula</th>
                    <th class="table-dark" scope="col">Descripción</th>
                    <th class="table-dark" scope="col">Fecha alta</th>
                    <th class="table-dark" scope="col">Fecha revisión</th>
                    <th class="table-dark" scope="col">Fecha solución</th>
                    <th class="table-dark" scope="col">Comentario</th>
                    <th class="table-dark" scope="col" colspan="3" class="text-center">Operaciones</th>
                </tr>  
            </thead>
            <tbody>
                <tr>
 
                    <?php
                        //echo "Hola";
                        $query = "SELECT * FROM incidencias";               
                        $vista_incidencias = mysqli_query($enlace,$query);

                        //print_r($vista_incidencias);

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
                                echo " <td class='text-center' > <a href='./acciones/update.php?editar&incidencia_id={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
                                echo " <td class='text-center'>  <a href='./acciones/borrarincidencia.php?eliminar={$id}' class='btn btn-danger' > <i class='bi bi-trash'></i> Eliminar</a> </td>";
                            echo " </tr> ";
                            
                        }
                    //CIERRO CONEXION ?? mysqli_close($enlace);?>
                </tr>  
            </tbody>
        </table>
    </div>
    <div class="container text-center mt-5">
      <a href="../index.php?Logout=1" class="btn btn-warning mt-5"> Salir </a>
    </div>
<?php include "footer.php" ?>