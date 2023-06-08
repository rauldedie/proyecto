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
$idusuario = $_SESSION['usuario_id'];
$nombreusuario = $_SESSION['usuario_nombre'];

//crea una nueva incidencia 
  if(isset($_POST['crear'])) 
    {
      //$planta = htmlspecialchars($_POST['planta']);
      $idaula = stripslashes($_POST['aula']);
      $idaula = mysqli_real_escape_string($enlace,$idaula);
      $descripcion = stripslashes($_POST['descripcion']);
      $descripcion = mysqli_real_escape_string($enlace,$descripcion);
      $comentario = stripslashes($_POST['comentario']);
      $comentario = mysqli_real_escape_string($enlace,$comentario);
      $fecha_alta = stripslashes($_POST['fecha_alta']);
      $fecha_alta = mysqli_real_escape_string($enlace,$fecha_alta);
      $idplanta = stripslashes($_POST['planta']);
      $idplanta = mysqli_real_escape_string($enlace,$idplanta);
      $error = "";
      $nohacer = 1;

      if($idplanta=="")
      {
        $error.="No se puede dar de alta una incidencia sin indicar planta.<br>";
        $nohacer = 0;
      }else if ($idaula=="")
      {
        $error.="No se puede dar de alta una incidencia sin indicar aula.<br>";
        $nohacer = 0;
      }else if ($descripcion=="")
      {
        $error.="Indicque alguna descripcion de la averia para poder resolverla.<br>";
        $nohacer = 0;
      }

      if ($nohacer==0)
      {
        echo $error;
      }else
      {
      
        $query= "INSERT INTO incidencias2 (descripcion, comentario, idaula, idusuario, fecha_alta ) VALUES('{$descripcion}','{$comentario}',{$idaula},{$idusuario},'{$fecha_alta}')";
        //echo $query."<br>";
        $resultado = mysqli_query($enlace,$query);
    
        if (!$resultado) {
            echo "Algo ha ido mal añadiendo la incidencia: ". mysqli_error($enlace);
        }
        else
        {
          echo "<script type='text/javascript'>alert('¡Incidencia añadida con éxito!')</script>";
        }    
      } 
    }
    //mysqli_close($enlace); ?????
    include "cabecera.php";
?>
<h1 class="text-center">Gestión de incidencias (CRUD). Panel Administrador - Añadir incidencia</h1>
<div>
    <p class="usuario"><?php echo "Usuario: ".$nombreusuario?></p>
</div>
  <div class="container">
    <form action="" method="post">
    <div class="form-group">
        <label>Planta</label>
        <select name="planta" id="planta" class="form-control" required>
            <option value="">Seleccione...</option>
            <option value="1">Baja</option>
            <option value="2">Primera</option> 
            <option value="3">Segunda</option>           
        </select>
      </div>
      <div class="form-group">
        <label for="aula">Aula</label>
        <select name="aula" id="aula" class="form-control" required>           
        </select> 
      <div class="form-group">
        <label for="descripcion" class="form-label">Descripcion</label>
        <input type="text" name="descripcion"  class="form-control" required>
      </div>
      <div class="form-group">
        <label for="fecha_alta" class="form-label">Fecha Alta</label>
        <input type="date"  name="fecha_alta" class="form-control" 
        value="<?php echo $hoy = date('Y-m-d'); ?>" min="<?php echo $hoy = date('Y-m-d'); ?>" 
        max="<?php echo $hoy = date('Y-m-d'); ?>">
      </div><br>
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
