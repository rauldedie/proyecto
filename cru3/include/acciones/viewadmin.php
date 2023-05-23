<?php  include 'header.php';?>

<h1 class="text-center">Detalles de incidencia</h1>
  <div class="container">
    <table class="table table-striped table-bordered table-hover">
      <thead class="table-dark">
        <tr>
              <th scope="col">Usuario</th>
              <th  scope="col">Planta</th>
              <th  scope="col">Aula</th>
              <th  scope="col">Descripción</th>
              <th  scope="col">Fecha alta</th>
              <th  scope="col">Fecha revisión</th>
              <th  scope="col">Fecha solución</th>
              <th  scope="col">Comentario</th>
        </tr>  
      </thead>
        <tbody>
          <tr>
               
            <?php
            
              if (isset($_GET['incidencia_id'])) 
              {
                  $incidenciaid = htmlspecialchars($_GET['incidencia_id']);

                  //$query="SELECT * FROM incidencias2 WHERE idincidencias =". $incidenciaid;
                  $query="SELECT * FROM incidencias2 WHERE idincidencias =".$incidenciaid;  
                  $vista_incidencias= mysqli_query($enlace,$query);
                  //echo $incidenciaid;
                  //print_r($vista_incidencias);
                  $fila=mysqli_fetch_array($vista_incidencias);            

                  //while($row = mysqli_fetch_assoc($vista_incidencias))
                  //{

                    $id = $fila['idincidencias'];
                    echo $id;
                    $query = "SELECT * FROM usuarios2 WHERE idusuario =".$id;
                    $usuario_inci = mysqli_fetch_array(mysqli_query($enlace,$query));                  
                    
                    $query = "SELECT * FROM aulas WHERE idaula =".$fila['idaula'];
                    $aula_inci =  mysqli_fetch_array(mysqli_query($enlace,$query));
                    
                    $query = "SELECT * FROM planta WHERE idplanta =".$aula_inci['idplanta'];
                    $planta_inci = mysqli_fetch_array(mysqli_query($enlace,$query));

                    $usuario = $usuario_inci['nombre']." ".$usuario_inci['apellidos'];
                    $aula = $aula_inci['aula'];
                    $planta = $planta_inci['planta'];      
                    $descripcion = $fila['descripcion'];        
                    $fecha_alta = $fila['fecha_alta'];        
                    $fecha_rev = $fila['fecha_mod'];        
                    $fecha_sol = $fila['fecha_resol'];        
                    $comentario = $fila['comentario'];

                        echo "<tr >";
                        echo " <td >{$usuario}</td>";
                        echo " <td > {$planta}</td>";
                        echo " <td > {$aula}</td>";
                        echo " <td >{$descripcion} </td>"; 
                        echo " <td >{$fecha_alta} </td>";
                        echo " <td >{$fecha_rev} </td>";
                        echo " <td >{$fecha_sol} </td>";
                        echo " <td >{$comentario} </td>";
                        echo " </tr> ";
                    //}
                }
            ?>
          </tr>  
        </tbody>
    </table>
  </div>

  <div class="container text-center mt-5">
    <a href="../administrador.php" class="btn btn-warning mt-5"> Volver </a>
  </div>

<?php include "footer.php" ?>