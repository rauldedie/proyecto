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


$idusuarioenuso = $_SESSION['usuario_id'];
$nombreusuario = $_SESSION['usuario_nombre'];
$rolenuso = $_SESSION['usuario_rol'];

include "conexion.php";
$query = "SELECT * FROM usuarios2 WHERE idusuario={$idusuarioenuso}";               
$vista_usuario = mysqli_query($enlace,$query);
if ($vista_usuario)
{
    $fila = mysqli_fetch_array($vista_usuario);
    $rol = $fila['rol'];
}

$query = "SELECT * FROM plantas2";               
$vista_planta = mysqli_query($enlace,$query);
//echo $query."<br>";
/*if ($vista_planta)
{
    $plantas = mysqli_fetch_array($vista_planta);
    //$fin = count($plantas);
}*/

include "cabecera.php";

if(strcmp($rolenuso,"administrador")==0 && strcmp($rolenuso,$rol)==0)
{
    
    echo "<div class='form-group'>";

        echo "<h1 class='text-center' >Gestión de incidencias (CRUD). Panel Administrador - Gestión de Aulas y Plantas del Edificio.</h1>";
        echo "<div>";
            echo "<p class='usuario'>Usuario: ".$nombreusuario."</p>";
        echo "</div>";
        echo "<div>";
            //echo "<a href='creararaulas.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Gestionar Aulas</a>";
            //echo "<a href='crearplanta.php?planta' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Gestionar Plantas</a>";

                    while ($plantas = mysqli_fetch_assoc($vista_planta))
                    {
                        echo "<table class='table table-striped table-bordered table-hover'>";
                        echo "<thead class='table table-striped'>";
                            echo "<tr>";
                                echo "<th class='table-dark' scope='col'>Planta: ".$plantas['planta']." </th>";
                                echo "<th class='table-dark' scope='col' colspan='3' class='text-center'>Operaciones</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        echo "<tr >";
                            $idplanta = $plantas['idplanta'];
                            $query2 = "SELECT * FROM aulas2 WHERE idplanta={$idplanta} order by aula asc";
                            $vista_aulas = mysqli_query($enlace,$query2);
                            
                            while ($aulas = mysqli_fetch_assoc($vista_aulas))
                            {
                                $aula = $aulas['aula'];
                                $id = $aulas['idaula'];
                                echo "<tr >";
                                    echo " <th scope='row' >{$aula}</th>";
                                    echo " <td class='text-center' > <a href='editaraula.php?editar&aula_id={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
                                    //echo " <td class='text-center'>  <a href='borrarusuario.php?eliminar={$idaula}' class='btn btn-danger' > <i class='bi bi-trash'></i> Eliminar</a> </td>";
                                echo "</tr>";
                                
                            }
                        echo "</tr>";
                        echo "</tbody>";
                        echo "</table>";
                    }                            
       
        echo "</div>";
    echo "</div>";
}else
{
    echo "<p><h1>lO SIENTO NO ESTAS AUTORIZADO A VER EST INFORMCIÓN</h1></p>";
    echo "<div class='container text-center mt-5'>";
        echo "<a href='logout.php' class='btn btn-warning mt-5'> SALIR </a>";
    echo "</div>";
}
mysqli_close($enlace);
    //echo "<p class='usuario'>Ojo! Si eliminas un usuario, eliminarás las incidencias asociadas al mismo.</p>";
echo "<div class='container text-center mt-5'>";
    echo "<a href='panelgestion.php?usuario={$idusuarioenuso}' class='btn btn-warning mt-5'> Volver </a>";
echo "</div>";

include "pie.php"; ?>