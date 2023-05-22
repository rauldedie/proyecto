<?php include "../header.php"?>

<?php
    $hoy = date("Y-m-d");
    //$hoy = date("Y-m-d H:i:s"

    if(isset($_GET['incidencia_id']))
    {
      $incidenciaid = htmlspecialchars($_GET['incidencia_id']); 
    }
      
        $query="SELECT * FROM incidencias2 WHERE idincidencias =".$incidenciaid;
        //$query="SELECT * FROM incidencias WHERE idincidencias = {$incidenciaid} LIMIT 1";
        $vista_incidencias= mysqli_query($enlace,$query);

        $fila= mysqli_fetch_array($vista_incidencias);
      


        //while($row = mysqli_fetch_assoc($vista_incidencias))
        //{
        $id = $fila['id']; 
          
        $query = "SELECT * FROM usuarios2 WHERE idusuario =".$fila['idusuario'];
        $usuario_inci = mysqli_fetch_array(mysqli_query($enlace,$query)); 

        $query = "SELECT * FROM aulas2 WHERE idaula =".$fila['idaula'];
        $aula_inci =  mysqli_fetch_array(mysqli_query($enlace,$query));

        $query = "SELECT * FROM plantas2 WHERE idplanta =".$aula_inci['idplanta'];
        $planta_inci = mysqli_fetch_array(mysqli_query($enlace,$query));

        $usuario = $usuario_inci['nombre']." ".$usuario_inci['apellidos'];

        $planta = $planta_inci['planta'];         
        $aula = $aula_inci['aula'];        
        $descripcion = $fila['descripcion'];        
        $fecha_alta = $fila['fecha_alta'];        
        $fecha_rev = $fila['fecha_mod'];        
        $fecha_sol = $fila['fecha_resol'];        
        $comentario = $fila['comentario'];

        echo $fila['descripcion']."<br>";
        echo $aula_inci['aula']."<br>";
        echo $planta_inci['planta']."<br>";
        echo $usuario."<br>";

        //}
 
      if(isset($_POST['editar'])) 
      {
        $planta = htmlspecialchars($_POST['planta']);
        $aula = htmlspecialchars($_POST['aula']);
        $descripcion = htmlspecialchars($_POST['descripcion']);
        //$fecha_alta = htmlspecialchars($_POST['fecha_alta']);
        $fecha_rev = $hoy;
        $fecha_sol = $hoy;
        $comentario = htmlspecialchars($_POST['comentario']);
        $query = "UPDATE incidencias2 SET descripcion = '{$descripcion}',comentario = '{$comentario}', aula = '{$aula_inc['idaula']}' , idusuario = {$usuario_inci['idusuario']} WHERE idincidencias = {$idincidencias}";
        $incidencia_actualizada = mysqli_query($enlace, $query);
        if (!$incidencia_actualizada)
          echo "Se ha producido un error al actualizar la incidencia.";
        else
          echo "<script type='text/javascript'>alert('¡Datos de la incidencia actualizados!')</script>";
      }             
      ?>

<h1 class="text-center">Actualizar incidencia</h1>
  <div class="container ">
    <form action="" method="post">
      <div>
        <label>Usuario</label><br>
        <label class="form-control" ><?php echo $usuario ?></label>
      </div>
      <div class="form-group">
        <label>Planta</label>
        <select name="planta" class="form-control">
          <option value="<?php echo $planta ?>" selected><?php echo $planta?></option>
          <option value="Baja">Baja</option>
          <option value="Primera">Primera</option> 
          <option value="Segunda">Segunda</option>           
        </select> 
      </div>
      <div class="form-group">
        <label for="aula">Aula</label>
        <select name="aula" class="form-control">
          <option value="<?php echo $aula?>" selected><?php echo $aula?></option>
          <option value="Sala de Profesores">Sala de Profesores</option>
          <option value="Biblioteca">Biblioteca</option>
          <option value="Secretaría">Secretaría</option>
          <option value="Conserjería">Conserjería</option>
          <option value="1º de Bachillerato">1º de Bachillerato</option> 
          <option value="2º de Bachillerato">2º de Bachillerato</option> 
          <option value="1º Grado Superior">1º Grado Superior</option> 
          <option value="2º Grado Superior">2º Grado Superior</option>            
        </select> 
      </div>
      <div class="form-group">
        <label for="descripcion" >Descripción</label>
        <input type="text" name="descripcion" class="form-control" value="<?php echo $descripcion  ?>">
      </div>
      <div class="form-group">
        <label >Fecha Alta</label>
        <label class="form-control" ><?php echo $fecha_alta?></label>
      </div>
      <div class="form-group">
        <label for="fecha_rev" >Fecha revisión</label>
        <input type="date" name="fecha_rev" class="form-control" value="<?php echo $fecha_rev  ?>">
      </div>
      <div class="form-group">
        <label for="fecha_sol" >Fecha solución</label>
        <input type="date" name="fecha_sol" class="form-control" value="<?php echo $fecha_sol  ?>">
      </div>
      <div class="form-group">
        <label for="comentario" >Comentario</label>
        <input type="text" name="comentario" class="form-control" value="<?php echo $comentario  ?>">
      </div>
      <div class="form-group">
         <input type="submit"  name="editar" class="btn btn-primary mt-2" value="editar">
      </div>
    </form>    
  </div>

  <div class="container text-center mt-5">
    <a href="../administrador.php" class="btn btn-warning mt-5"> Volver </a>
  </div>

<?php include "../footer.php" ?>