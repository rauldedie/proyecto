<?php
session_start();
if (!array_key_exists("usuario_id",$_SESSION)){
    // Si no tenia la sesion iniciada
    header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA

include "conexion.php";
$idusuario = $_SESSION['usuario_id'];
$nombreusuario = $_SESSION['usuario_nombre'];

//crea una nueva incidencia 
  if(isset($_POST['crear'])) 
    {
        //$planta = htmlspecialchars($_POST['planta']);
        $idaula = htmlspecialchars($_POST['aula']);
        $descripcion = htmlspecialchars($_POST['descripcion']);
        $comentario = htmlspecialchars($_POST['comentario']);
        $fecha_alta = htmlspecialchars($_POST['fecha_alta']);

        if (isset($_POST['fecha_revision']))
        {
            $fecha_rev = date('Y-m-d');
        }else $fecha_rev="";

        if (isset($_POST['fecha_revision']))
        {
            $fecha_sol = date('Y-m-d');
        }else $fecha_resol="";
        
      //NECESITO SESION O COOKIE PARA PONER IDUSUARIO
      //REVISAR COMILLAS SIMPLES DE LA FECHA SE PONE...NO....????
        $query= "INSERT INTO incidencias2 (descripcion, comentario, idaula, idusuario, fecha_alta ) VALUES('{$descripcion}','{$comentario}',{$idaula},{$idusuario},'{$fecha_alta}')";
        $resultado = mysqli_query($enlace,$query);
        //echo $query;
    
          if (!$resultado) {
              echo "Algo ha ido mal añadiendo la incidencia: ". mysqli_error($enlace);
          }
          else
          {
            echo "<script type='text/javascript'>alert('¡Incidencia añadida con éxito!')</script>";
          }     
    }
    //mysqli_close($enlace); ?????
    include "cabecera.php";
?>
<h1 class="text-center">Panel de Gestión (CRU)-Añadir incidencia</h1>
<div>
    <p class="usuario"><?php echo "Usuario: ".$nombreusuario?></p>
</div>
  <div class="container">
    <form action="" method="post">
    <div class="form-group">
        <label>Planta</label>
        <select name="planta" id="planta" class="form-control">
            <option value="">Seleccione...</option>
            <option value="1">Baja</option>
            <option value="2">Primera</option> 
            <option value="3">Segunda</option>           
        </select>
      </div>
      <div class="form-group">
        <label for="aula">Aula</label>
        <select name="aula" id="aula" class="form-control">           
        </select> 
      <div class="form-group">
        <label for="descripcion" class="form-label">Descripcion</label>
        <input type="text" name="descripcion"  class="form-control">
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
