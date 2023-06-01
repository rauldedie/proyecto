<?php
session_start();
if (!array_key_exists("usuario_id",$_SESSION))
{
  // Si no tenia la sesion iniciada
  header("Location:logout.php");
}//DE ESTA FORMA FUNCIONA

include "conexion.php";

$idusuarioenuso = $_SESSION['usuario_id'];
$nombreusuario = $_SESSION['usuario_nombre'];
$rolenuso = $_SESSION['usuario_rol']; 
$creada = 0;

if(isset($_GET['aula_id']))
{
    $aulaid = htmlspecialchars($_GET['aula_id']); 

    $query="SELECT * FROM aulas2 WHERE idaula =".$aulaid;
    $vista_aulas= mysqli_query($enlace,$query);

    $aula= mysqli_fetch_array($vista_aulas);

    $query = "SELECT * FROM plantas2 WHERE idplanta =".$aula['idplanta'];
    $planta = mysqli_fetch_array(mysqli_query($enlace,$query));

    $planta_actual = $planta['planta'];         
    $aula_actual = $aula['aula'];
    $idaula_actual = $aula['idaula'];

    if(isset($_POST['editar'])) 
    {
        $idplanta_mod = htmlspecialchars($_POST['planta']);
        $aula_mod = htmlspecialchars($_POST['aula']);
        $aula_mod = strtolower($aula_mod);

        $query = "UPDATE aulas2 SET idplanta={$idplanta_mod} WHERE idaula={$idaula_actual}";
        $resultado = mysqli_query($enlace,$query);
        if (!$resultado)
        {
            echo "Error al actualizar el aula".mysqli_error($enlace);
        }else
        {
            $query = "UPDATE aulas2 SET aula='{$aula_mod}' WHERE idaula={$idaula_actual}";
            $resultado = mysqli_query($enlace,$query);
            if (!$resultado)
            {
                echo "Error al actualizar el aula".mysqli_error($enlace);
            }else{
                echo "<script type='text/javascript'>alert('¡Aula actualizada!')</script>";
            }
        }


    }
}
mysqli_close($enlace);     
include "cabecera.php";
?>

<h1 class="text-center">Panel Gestión (CRU) - Actualizar Aula</h1>
<div>
    <p class="usuario"><?php echo"Usuario en uso: ".$nombreusuario; ?></p>
</div>
<div class="container2">
<div class="container">
    <p><h3> Datos actuales del aula</h3></p>
    <div class="form-group">
            
        <label for="planta_actual">Planta
            <input type="text" name="planta_actual" disabled id="planta_actual" class="form-control" value="<?php echo $planta_actual?>">
        </label>
        <label for="aula_nueva">Aula nueva
            <input type="text" name="aula_nueva" disabled id="aula_nueva" class="form-control" value="<?php echo $aula_actual?>">
        </label>
             
    </div>    
</div>

<div class="container ">
    <form action="" method="post">
        <div class="form-group">
            <p><h3>Datos del aula nueva</h3></p>
            <label for="planta">Planta</label>
            <select name="planta" id="planta" class="form-control">
                <option value="1">Baja</option>
                <option value="2">Primera</option> 
                <option value="3">Segunda</option>           
            </select> 
            <label for="aula">Aula</label>
                <input type="text" name="aula" id="aula" class="form-control">
            </label>            
        </div>
        <div class="form-group">
            <input type="submit"  name="editar" class="btn btn-primary mt-2" value="editar aula">
        </div>
    </form>    
    <p>Los datos del aula actual se cambiarán por los que elijas en nueva aula (seguirán existiendo el mismo número de aulas)</p>
</div>

<div class="container text-center mt-5">
  <a href="gestionaraulas.php" class="btn btn-warning mt-5"> Volver </a>
</div>

<?php include "pie.php" ?>