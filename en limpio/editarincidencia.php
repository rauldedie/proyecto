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

include "conexion.php";
$idusuarioenuso = $_SESSION['usuario_id'];
$nombreusuario = $_SESSION['usuario_nombre'];
$rolenuso = $_SESSION['usuario_rol']; 
$hoy = date("Y-m-d");
//$hoy = date("Y-m-d H:i:s")
$fecha_rev_mod = $fecha_sol_mod = $idaula_mod = $descripcion_mod = $comentario_mod =0;

if(isset($_GET['incidencia_id']))
{
  $incidenciaid = htmlspecialchars($_GET['incidencia_id']); 
}
 
  $query="SELECT * FROM incidencias2 WHERE idincidencia =".$incidenciaid;
  $vista_incidencias= mysqli_query($enlace,$query);

  $fila= mysqli_fetch_array($vista_incidencias);

  $id = $fila['idincidencia']; 
    
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
  $error_edicion = "";

  if(isset($_POST['editar'])) 
  {
    //$planta_mod = (htmlspecialchars($_POST['planta']));
    $planta_mod = stripslashes($_POST['planta']);
    $planta_mod = mysqli_real_escape_string($enlace,$planta_mod);
    //$idaula_mod = (htmlspecialchars($_POST['aula']));
    $idaula_mod = stripslashes($_POST['aula']);
    $idaula_mod = mysqli_real_escape_string($enlace,$idaula_mod);
    //$descripcion_mod = htmlspecialchars($_POST['descripcion']);
    $descripcion_mod = stripslashes($_POST['descripcion']);
    $descripcion_mod = mysqli_real_escape_string($enlace,$descripcion_mod);
    //$comentario_mod = htmlspecialchars($_POST['comentario']);
    $comentario_mod = stripslashes($_POST['comentario']);
    $comentario_mod = mysqli_real_escape_string($enlace,$comentario_mod);
    
    if($_POST['fecha_revision']==1)
    {
      $fecha_rev_mod = $hoy;
    }
    if($_POST['fecha_resolucion']==1)
    {
      $fecha_sol_mod = $hoy;
    }  
    
    if(strcmp($idaula_mod,"")==0)
      {
        $idaula_mod=0;
      }

    if ($idaula_mod!=0) 
    { 
      if($fecha_rev_mod!=0)
      {
        if($fecha_sol_mod!=0)
        {
          $query = "UPDATE incidencias2 SET idaula={$idaula_mod}, descripcion='{$descripcion_mod}',comentario='{$comentario_mod}',fecha_mod='{$fecha_rev_mod}',fecha_resol='{$fecha_sol_mod}' WHERE idincidencia={$incidenciaid}";
          //echo $query."<br>";
          $incidencia_actualizada = mysqli_query($enlace,$query);

          if (!$incidencia_actualizada)
          {
            $error_edicion = "Error en la actualizacion de la incidencia<br>";
          }
        }else
        {
          $query = "UPDATE incidencias2 SET idaula={$idaula_mod}, descripcion='{$descripcion_mod}',comentario='{$comentario_mod}',fecha_mod='{$fecha_rev_mod}' WHERE idincidencia={$incidenciaid}";
          //echo $query."<br>";
          $incidencia_actualizada = mysqli_query($enlace,$query);

          if (!$incidencia_actualizada)
          {
            $error_edicion = "Error en la actualizacion de la incidencia<br>";
          }
        }
      }else if ($fecha_sol_mod!=0)
      {
        $query = "UPDATE incidencias2 SET idaula={$idaula_mod}, descripcion='{$descripcion_mod}',comentario='{$comentario_mod}',fecha_resol='{$fecha_sol_mod}' WHERE idincidencia={$incidenciaid}";
        //echo $query."<br>";
        $incidencia_actualizada = mysqli_query($enlace,$query);

        if (!$incidencia_actualizada)
        {
          $error_edicion = "Error en la actualizacion de la incidencia<br>";
        }
      }else
      {
        $query = "UPDATE incidencias2 SET idaula={$idaula_mod}, descripcion='{$descripcion_mod}',comentario='{$comentario_mod}' WHERE idincidencia={$incidenciaid}";
        //echo $query."<br>";
        $incidencia_actualizada = mysqli_query($enlace,$query);

        if (!$incidencia_actualizada)
        {
          $error_edicion = "Error en la actualizacion de la incidencia<br>";
        }
      }
    }else if ($fecha_rev_mod!=0)
    {
      if ($fecha_sol_mod!=0)
      {
        $query = "UPDATE incidencias2 SET descripcion='{$descripcion_mod}',comentario='{$comentario_mod}',fecha_mod='{$fecha_rev_mod}',fecha_resol='{$fecha_sol_mod}' WHERE idincidencia={$incidenciaid}";
        //echo $query."<br>";
        $incidencia_actualizada = mysqli_query($enlace,$query);

        if (!$incidencia_actualizada)
        {
          $error_edicion = "Error en la actualizacion de la incidencia<br>";
        }
      }else
      {
        $query = "UPDATE incidencias2 SET descripcion='{$descripcion_mod}',comentario='{$comentario_mod}',fecha_mod='{$fecha_rev_mod}' WHERE idincidencia={$incidenciaid}";
        //echo $query."<br>";
        $incidencia_actualizada = msyqli_query($enlace,$query);

        if (!$incidencia_actualizada)
        {
          $error_edicion = "Error en la actualizacion de la incidencia<br>";
        }
      }
    }else if ($fecha_sol_mod!=0)
    {
      $query = "UPDATE incidencias2 SET descripcion='{$descripcion_mod}',comentario='{$comentario_mod}',fecha_resol='{$fecha_sol_mod}' WHERE idincidencia={$incidenciaid}";
      //echo $query."<br>";
      $incidencia_actualizada = mysqli_query($enlace,$query);

      if (!$incidencia_actualizada)
      {
        $error_edicion = "Error en la actualizacion de la incidencia<br>";
      }

    }else
    {
      $query = "UPDATE incidencias2 SET descripcion='{$descripcion_mod}',comentario='{$comentario_mod}' WHERE idincidencia={$incidenciaid}";
      //echo $query."<br>";
      
      $incidencia_actualizada = mysqli_query($enlace,$query);

      if (!$incidencia_actualizada)
      {
        $error_edicion = "Error en la actualizacion de la incidencia<br>";
      }
    }
    if(strcmp($error_edicion,"")==0)
    {
      echo "<script type='text/javascript'>alert('¡Datos de la incidencia actualizados!')</script>";
      if($fecha_sol_mod!=0)
      {
        $output='<p>Estimado usuario, '.$usuario_inci['nombreusuario'].' no tiene que responder este mensaje.</p>';
        $output.='<p>Su incidencia registrada con nºincidencia: '.$id.', '.$fila['descripcion'].' acaba de ser resuelta por el equipo técnico del IES A. Machado.</p>';
        $output.='<p>Gracias por su colaboración.</p>';   	
        $body = $output; 
        $subject = "Equipo técnico IES A. Machado.";
        $email_to = $usuario_inci['mail'];
        $fromserver = "info@practicasrdm.es"; 
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <info@practicasrdm.es>' . "\r\n";
        if (mail($email_to,$subject,$body,$headers))
        {
          echo "<script type='text/javascript'>alert('¡Se ha enviado un mail al usuario!')</script>";
        }
      }
    }
    else
      echo "Se ha producido un error al actualizar la incidencia.";
    
  }
mysqli_close($enlace);     
include "cabecera.php";
?>

<h1 class="text-center">Gestión de incidencias (CRUD). Panel Administrador  - Actualizar incidencia</h1>
<div>
    <p class="usuario"><?php echo"Usuario en uso: ".$nombreusuario; ?></p>
</div>
<div class="container2">
<div class="container">
  <p class="edicion"><h3 class="edicion"> Datos actuales de la incidencia:</h3></p>
  <p class="edicion">Usuario que registró la incidencia: <?php echo $usuario ?> </p>
  <p class="edicion">Planta: <?php echo $planta?></p>
  <p class="edicion">Aula: <?php echo $aula?></p>
  <p class="edicion">Descripción: <?php echo $descripcion?></p>
  <p class="edicion">Comentario: <?php echo $comentario?></p>
  <p class="edicion">Fecha Alta: <?php echo $fecha_alta?> </p>        
  <p class="edicion">Fecha Revisión: <?php echo $fecha_rev?></p>       
  <p class="edicion">Fecha Solución: <?php echo $fecha_sol?></p>       
</div>

<div class="container ">
  <form action="" method="post">
    <div class="form-group">
      <p><h3>Datos modificables de la incidencia.</h3></p>
      <label>Planta</label>
      <select name="planta" id="planta" class="form-control">
        <option value="<?php echo $planta ?>" selected><?php echo $planta?></option>
        <option value="1">Baja</option>
        <option value="2">Primera</option> 
        <option value="3">Segunda</option>           
      </select> 
      <label for="aula">Aula</label>
      <select name="aula" id="aula" class="form-control">           
      </select> 
      <label for="descripcion" >Descripción</label>
      <input type="text" name="descripcion" class="form-control" value="<?php echo $descripcion  ?>">
      <label for="comentario" >Comentario</label>
      <input type="text" name="comentario" class="form-control" value="<?php echo $comentario  ?>">
      <input type="checkbox" name="fecha_revision" value=1 class="form-check-input" id="fechaRev">
      <label >Establecer fecha de revision de la incidencia.</label><br>
      <input type="checkbox" name="fecha_resolucion" value=1 class="form-check-input" id="fechaResol">
      <label >Establecer fecha de resolción de la incidencia.</label>
      <label>Esto dará por solucionada la incidencia con fecha de hoy.</label>
    </div>

    <div class="form-group">
        <input type="submit"  name="editar" class="btn btn-primary mt-2" value="editar">
    </div>
  </form>    
</div>
</div>

<div class="container text-center mt-5">
  <a href="panelgestion.php?usuario=<?php echo $idusuario?>" class="btn btn-warning mt-5"> Volver </a>
</div>
        <!--Llamada al evento Change del selector Plantas-->
        <script>
        $(document).ready(function(){
            $("#planta").on('change', function () 
            {
                $("#planta option:selected").each(function () 
                {
                    plantaelegida=$(this).val();
                    $.post("buscaraulas.php", { plantaelegida: plantaelegida }, function(data)
                    {
                        $("#aula").html(data);
                    });         
                });
            });
        });
    </script>

<?php include "pie.php" ?>