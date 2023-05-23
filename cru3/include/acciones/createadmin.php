<?php  include "header.php" ?>
<?php
    $hoy = date("Y-m-d");
  if(isset($_POST['crear'])) 
    {
        $planta = htmlspecialchars($_POST['planta']);
        $aula = htmlspecialchars($_POST['aula']);
        $descripcion = htmlspecialchars($_POST['descripcion']);
        $comentario = htmlspecialchars($_POST['comentario']);
        $fecha_alta = htmlspecialchars($_POST['fecha_alta']);
        $fecha_rev = "";
        $fecha_sol = "";
      
        $query= "INSERT INTO incidencias(descripcion, comentario, idaula, idusuario, fecha_alta, fecha_mod, fecha_resol ) VALUES('{$descripcion}','{$comentario}','{$idaula}','{$idusuario}','{$fecha_alta}','{$fecha_rev}','{$fecha_sol}')";
        $resultado = mysqli_query($enlace,$query);
    
          if (!$resultado) {
              echo "Algo ha ido mal añadiendo la incidencia: ". mysqli_error($enlace);
          }
          else
          {
            echo "<script type='text/javascript'>alert('¡Incidencia añadida con éxito!')</script>";
          }         
    }
?>
<h1 class="text-center">Añadir incidencia</h1>
  <div class="container">
    <form action="" method="post">
    <div class="form-group">
        <label>Planta</label>
        <select name="planta" class="form-control">
          <option value="Baja" selected>Baja</option>
          <option value="Primera">Primera</option> 
          <option value="Segunda">Segunda</option>           
        </select> 
      </div>
      <div class="form-group">
        <label for="aula">Aula</label>
        <select name="aula" class="form-control">
          <option value="Sala de Profesores" selected>Sala de Profesores</option>
          <option value="Biblioteca">Biblioteca</option>
          <option value="Secretaría">Secretaría</option>
          <option value="Conserjería">Conserjería</option>
          <option value="1º de Bachillerato">1º de Bachillerato</option> 
          <option value="2º de Bachillerato">2º de Bachillerato</option> 
          <option value="1º Grado Superior">1º Grado Superior</option> 
          <option value="2º Grado Superior">2º Grado Superior</option>            
        </select> 
      <div class="form-group">
        <label for="descripcion" class="form-label">Descripcion</label>
        <input type="text" name="descripcion"  class="form-control">
      </div>
      <div class="form-group">
        <label for="fecha_alta" class="form-label">Fecha Alta</label>
        <input type="date" name="fecha_alta" disable class="form-control" value="<?php $hoy ?>">
      </div>
      <!--<div class="form-group">
        <label for="fecha_rev" class="form-label">Fecha Revisión</label>
        <input type="date" name="fecha_rev"  class="form-control">
      </div>
      <div class="form-group">
        <label for="fecha_sol" class="form-label">Fecha Solución</label>
        <input type="date" name="fecha_sol"  class="form-control">
      </div>-->
      <div class="form-group">
        <label for="comentario" class="form-label">Comentario</label>
        <input type="text" name="comentario"  class="form-control">
      </div>
      <div class="form-group">
        <input type="submit"  name="crear" class="btn btn-primary mt-2" value="Añadir">
      </div>
    </form> 
  </div>
  <div class="container text-center mt-5">
    <a href="home.php" class="btn btn-warning mt-5"> Volver </a>
  <div>
<?php include "footer.php" ?>