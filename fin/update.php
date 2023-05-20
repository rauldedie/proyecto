<?php include "cabecerapanel.php"?>
<?php
    $servidor = "217.76.150.73";
    $usuario = "qahx080"; 
    $passwd = "1smer1l10N"; 
    $bd = "qahx080"; 
    $enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);
    
    if(!$enlace)
    {
        echo "Conexion fallida: ".mysqli_connect_error();
    
    }

    if(isset($_GET['incidencia_id']))
    {
        $incidenciaid = htmlspecialchars($_GET['incidencia_id']); 
    }
    $id=$incidenciaid;

    $query = sprintf("SELECT * FROM incidencias2 WHERE idincidencias ='%s'",$incidenciaid);
    $vista_incidencias= mysqli_query($enlace,$query);
    $fila = mysqli_fetch_array(mysqli_query($enlace,$query));

    while($row = mysqli_fetch_assoc($vista_incidencias))
    {
        $id = $row['id'];

        $query2 = sprintf("SELECT * FROM aulas2 WHERE idaula='%s'",$fila['idaula']);
        $aula =  mysqli_fetch_array(mysqli_query($enlace,$query2));
        $aula_inc = $aula['aula'];

        $query2 = sprintf("SELECT * FROM plantas2 WHERE idplanta='%s'",$aula['idplanta']);               
        $planta = mysqli_fetch_array(mysqli_query($enlace,$query2));
        $planta_inc = $planta['planta'];     

        $descripcion = $row['descripcion'];        
        $fecha_alta = $row['fecha_alta'];        
        $fecha_rev = $row['fecha_mod'];        
        $fecha_sol = $row['fecha_resol'];        
        $comentario = $row['comentario'];
    }

    /*$query="SELECT * FROM incidencias2 WHERE id = $incidenciaid ";
    $row= mysqli_fetch_array(mysqli_query($enlace,$query));

    $query2 = sprintf("SELECT * FROM aulas2 WHERE idaula='%s'",$row['idaula']);
    $aula =  mysqli_fetch_array(mysqli_query($enlace,$query2));
    $aula_inc = $aula['aula'];

    $query2 = sprintf("SELECT * FROM plantas2 WHERE idplanta='%s'",$aula['idplanta']);               
    $planta = mysqli_fetch_array(mysqli_query($enlace,$query2));
    $planta_inc = $planta['planta'];
    echo $planta_inc;*/
    
//NO FUNCIONA POR EL MISMO PROBLEMA NECESITO EL PHP DESPUES DE LOS FORM SI VAN ANTES NO FUNCIONAN Y 
//SI NO EJECUTO ANTES NO SE LOS VALORES QUE NECESITO EN EL FORMULACIONDE ACTUALIZACION

?>
<h1 class="text-center">Actualizar incidencia</h1>
    <div class="container ">
        <form action="" method="post">
            <div class="form-group">
                <label for="planta" >Planta</label>
                <select name="planta" class="form-control">
                    <option value="<?php echo $planta_inc?>" selected><?php echo $planta_inc;?></option>
                    <option value="Baja">Baja</option>
                    <option value="Primera">Primera</option>
                    <option value="Segunda">Segunda</option>
                </select>
            </div>
            <div class="form-group">
                <label for="aula" >Aula</label>
                <select name="aula" class="form-control">
                    <option value="<?php echo $aula_inc  ?>" selected><?php echo $aula_inc;?></option>
                    <option value="Sala Profesores">Sala Profesores</option>
                    <option value="Secretaría">Secretaría</option>
                    <option value="Conserjería">Conserjería</option>
                    <option value="Biblioteca">Biblioteca</option>
                    <option value="1º Bachillerato">1º Bachillerato</option>
                    <option value="2º Bachillerato">2º Bachillerato</option>
                    <option value="1º Grado Superior">1º Grado Superior</option>
                    <option value="2º Grado Superior">2º Grado Superior</option>
                </select>
            </div>
            <div class="form-group">
                <label for="descripcion" >Descripción</label>
                <input type="text" name="descripcion" class="form-control" value="<?php echo $descripcion  ?>">
            </div>
            <div class="form-group">
                <label for="fecha_alta" >Fecha alta</label><br>
                <label class="form_control"><?php echo $fecha_alta?></label>
                <!--<input type="date" name="fecha_alta" class="form-control" value="<?php //echo $fecha_alta  ?>">-->
            </div>
            <div class="form-group"><!--poner un label y un boton que establezca la fecha de hoy-->
                <label for="fecha_rev" >Fecha revisión</label>
                <input type="date" name="fecha_rev" class="form-control" value="<?php echo $fecha_rev  ?>">
            </div>
            <div class="form-group"><!--poner un label y un boton que establezca la fecha de hoy-->
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
    <a href="paneladmin.php" class="btn btn-warning mt-5"> Volver </a>
</div>
<?php



    /*if(isset($_GET['incidencia_id']))
    {
        $incidenciaid = htmlspecialchars($_GET['incidencia_id']); 
    }
      
    $query="SELECT * FROM incidencias2 WHERE idincidencias = $incidenciaid ";
    $vista_incidencias= mysqli_query($enlace,$query);
    $fila = mysqli_fetch_array($vista_incidencias);
    echo $fila['idaula']."<br>";

    while($row = mysqli_fetch_assoc($vista_incidencias))
    {
        $id = $row['id'];

        $query2 = sprintf("SELECT * FROM plantas2 WHERE idplanta='%s'",$aula['idplanta']);               
        $planta = mysqli_fetch_array(mysqli_query($enlace,$query2));
        $planta_inc = $planta['planta'];
        
        $query2 = sprintf("SELECT * FROM aulas2 WHERE idaula='%s'",$row['idaula']);
        $aula =  mysqli_fetch_array(mysqli_query($enlace,$query2));
        $aula_inc = $aula['aula'];

        $descripcion = $row['descripcion'];        
        $fecha_alta = $row['fecha_alta'];        
        $fecha_rev = $row['fecha_mod'];        
        $fecha_sol = $row['fecha_resol'];        
        $comentario = $row['comentario'];
    }*/
 
    if(isset($_POST['editar'])) 
    {
        $planta = htmlspecialchars($_POST['planta']);
        $aula = htmlspecialchars($_POST['aula']);
        $descripcion = htmlspecialchars($_POST['descripcion']);
        $fecha_alta = htmlspecialchars($_POST['fecha_alta']);
        $fecha_rev = htmlspecialchars($_POST['fecha_rev']);
        $fecha_sol = htmlspecialchars($_POST['fecha_sol']);
        $comentario = htmlspecialchars($_POST['comentario']);
        $query = "UPDATE incidencias2 SET planta = '{$planta}' , aula = '{$aula}' , descripcion = '{$descripcion}', fecha_mod = '{$fecha_rev}', fecha_resol = '{$fecha_sol}', comentario = '{$comentario}' WHERE idincidencias = {$incidenciaid}";
        $incidencia_actualizada = mysqli_query($enlace, $query);

        if (!$incidencia_actualizada)
        {
            echo "Se ha producido un error al actualizar la incidencia.";
        }else
        {
            echo "<script type='text/javascript'>alert('¡Datos de la incidencia actualizados!')</script>";
        }
    }             
?>



<?php include "piepanel.php" ?>