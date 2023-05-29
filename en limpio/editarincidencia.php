<?php
session_start();
if (!array_key_exists("usuario_id",$_SESSION)){
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA

include "conexion.php";
$idusuario = $_SESSION['usuario_id'];
$nombreusuario = $_SESSION['usuario_nombre'];
//LOS DATOS ESTAN PERO NO HACE EL UPDATE.
    $hoy = date("Y-m-d");
    //$hoy = date("Y-m-d H:i:s")

    if(isset($_GET['incidencia_id']))
    {
      $incidenciaid = htmlspecialchars($_GET['incidencia_id']); 
    }
      
        $query="SELECT * FROM incidencias2 WHERE idincidencias =".$incidenciaid;
        $vista_incidencias= mysqli_query($enlace,$query);

        $fila= mysqli_fetch_array($vista_incidencias);
      
        $id = $fila['idincidencias']; 
          
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

        //}
        //echo "esoty fuera de editar<br>";
      if(isset($_POST['editar'])) 
      {
        //echo "esoty dentro de editar<br>";
        $planta = (htmlspecialchars($_POST['planta']));
        $aula = (htmlspecialchars($_POST['aula']));
        $descripcion = htmlspecialchars($_POST['descripcion']);
        $comentario_mod = htmlspecialchars($_POST['comentario']);

        echo $aula."<br>";
        echo $aula_inci['idaula']."<br>";
        echo $planta."<br>";
        echo $comentario_mod."<br>";
       

        if(isset($_POST['fecha_revision'])==1)
        {
            //TENGO QUE ESTBLECER LAS FECHAS SI SE MARCAN LOS CHECK
            //HACER EL UPDATE CON LOS DATOS ESTABLECIDOS
            //AULA Y PLANTA DEPENDIENTES
            //SI SE MARCA EL CHECK DE FECHA SOLUCION ENVIAR MAIL AL USUARIO QUE DIO ALTA LA INCIDENCIA
          $fecha_rev = $hoy;

          //problelma con formato fecha. En la BD es un tipo date y aunque el date() devuelve un tipo date
          //no se si el problema esta ahí.
          //POSIBLE SOLUCION
          //declarar Las fechas comO string y usar :
          //$hoy   = new DateTime('2020-03-08');
          //fecha_erv = $hoy->format('Y-m-d');
          //y entonces creo que el udate valdria.

          $query = "UPDATE incidencias2 SET fecha_mod = '{$fecha_rev}' WHERE idincidencias = {$incidenciaid}";
          //echo $query."<br>";
          $fecha_revision_actualizada = msqli_query($enlace,$query);

          if (!$fecha_revision_actualizada)
            echo "Se ha producido un error al actualizar la fecha de revision.";
          else
            echo "<script type='text/javascript'>alert('¡Fecha revision actualizada!')</script><br>";
        } 
        if(isset($_POST['fecha_resolucion'])==1)
        {
          $fecha_sol = $hoy;
          //IDEM QUE EL ANTERIOR AQUI NO PONGO COMILLAS Y TAMPOCO VA
          //$query = "UPDATE incidencias2 SET fecha_resol = {$fecha_sol} WHERE idincidencias = {$incidenciaid}";
          //echo $query."<br>";
          //$fecha_solucion_actualizada = msqli_query($enlace,$query);

          if (!$incidencia_solucion_actualizada)
            echo "Se ha producido un error al actualizar la fecha de solcion.";
          else
            echo "<script type='text/javascript'>alert('¡Fecha solución actualizada!')</script><br>";
          //enviar un mail indicando resolucion incidencia al usuario que dio de lta la misma
        }else

        $query = "SELECT * FROM aulas WHERE aula ='{$aula}'";
        echo $query."<br>";
        $aula_mod =  mysqli_fetch_array(mysqli_query($enlace,$query));

        echo $aula_mod['idaula']."<br>";
        echo $aula_mod['aula']."<br>";
        echo $planta_mod['idplanta']."<br>";
        echo $planta_mod['planta']."<br>";
        //La planta no es necesario tratarla cambia el aula ya que no hay aulas repetidas en diferentes plantas  

        if($comentario_mod!="")
        {
          $query = "UPDATE incidencias2 SET descripcion = '{$descripcion}',comentario = '{$comentario_mod}', aula = {$aula_mod['idaula']} WHERE idincidencias = {$incidenciaid}";
          //$query = "UPDATE incidencias2 SET descripcion=".$descripcion.", comentario=".$comentario.", aula=".$aula_inc['idaula'].", idusuario=".$usuario_inci['idusuario']." WHERE idincidencias =".$idincidencias;
          echo $query."<br>";
          $incidencia_actualizada = mysqli_query($enlace, $query);
          //NO TERMINA DE HACER EL UPDATE NO SE ¿POR QUE?
          if (!$incidencia_actualizada)
            echo "Se ha producido un error al actualizar la incidencia.";
          else
            echo "<script type='text/javascript'>alert('¡Datos de la incidencia actualizados!')</script>";
        }else
        {
          $query = "UPDATE incidencias2 SET descripcion = '{$descripcion}' aula = {$aula_mod['idaula']} WHERE idincidencias = {$incidenciaid}";
          //$query = "UPDATE incidencias2 SET descripcion=".$descripcion.", comentario=".$comentario.", aula=".$aula_inc['idaula'].", idusuario=".$usuario_inci['idusuario']." WHERE idincidencias =".$idincidencias;
          echo $query."<br>";
          $incidencia_actualizada = mysqli_query($enlace, $query);
          //NO TERMINA DE HACER EL UPDATE NO SE ¿POR QUE?
          if (!$incidencia_actualizada)
            echo "Se ha producido un error al actualizar la incidencia.";
          else
            echo "<script type='text/javascript'>alert('¡Datos de la incidencia actualizados!')</script>";
        }

      }
      mysqli_close($enlace);          
      ?>
<?php include "cabecera.php"?>
<h1 class="text-center">Panel Gestión (CRU) - Actualizar incidencia</h1>
<div>
    <p><?php echo"Usuario: ".$nombreusuario; ?></p>
</div>
  <div class="container ">
    <form action="" method="post">
      <div>
        <label>Usuario</label>
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
          <option value="Secretaria">Secretaria</option>
          <option value="Conserjeria">Conserjeria</option>
          <option value="Primero de Bachillerato">Primero de Bachillerato</option> 
          <option value="Segundo de Bachillerato">Segundo de Bachillerato</option> 
          <option value="Primero Grado Superior">Primero Grado Superior</option> 
          <option value="Segundo Grado Superior">SEgundo Grado Superior</option>            
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
        <label for="comentario" >Comentario</label>
        <input type="text" name="comentario" class="form-control" value="<?php echo $comentario  ?>">
      </div>
      <div class="form-group">
        <input type="checkbox" name="fecha_revision" value=1 class="form-check-input" id="fechaRev">
        <label >Establecer fecha de revision de la incidencia.</label>
      </div>
      <div class="form-group">
        <input type="checkbox" name="fecha_resolucion" value=1 class="form-check-input" id="fechaResol">
        <label >Establecer fecha de resolción de la incidencia.</label>
        <label>Esto dará por solucionada la incidencia con fecha de hoy.</label>
      </div>
      <div class="form-group">
         <input type="submit"  name="editar" class="btn btn-primary mt-2" value="editar">
      </div>
    </form>    
  </div>

  <div class="container text-center mt-5">
    <a href="panelrol.php?usuario=<?php echo $idusuario?>" class="btn btn-warning mt-5"> Volver </a>
  </div>

<?php include "pie.php" ?>