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

if(isset($_GET['ord']))
{
    $ord = htmlspecialchars($_GET['ord']);
}else
{
    $ord = "asc";
}
if(isset($_GET['campo']))
{
    $campo = htmlspecialchars($_GET['campo']);
}else
{
    $campo = "idusuario";
}

if (strcmp($ord,"asc")==0)
{
    $ord="desc";
}else
{
    $ord="asc";
} 

include "conexion.php";
$query = "SELECT * FROM usuarios2 WHERE idusuario={$idusuarioenuso}";               
$vista_usuario = mysqli_query($enlace,$query);
//echo $query."<br>";
if ($vista_usuario)
{
    $fila = mysqli_fetch_array($vista_usuario);
    $rol = $fila['rol'];
}

include "cabecera.php";

if(strcmp($rolenuso,"administrador")==0 && strcmp($rolenuso,$rol)==0)
{
    
    echo "<div class='form-group'>";

        echo "<h1 class='text-center' >Gestión de incidencias (CRUD). Gestión de Usuarios.</h1>";
        echo "<div>";
            echo "<p class='usuario'>Usuario: ".$nombreusuario."</p>";
        echo "</div>";
        echo "<a href='crearusuario.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Añadir Usuario</a>";
        echo "<a href='gestionarusuario.php?campo=idusuario&&ord={$ord}' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Ordenar usuarios por antiguedad</a>";
        echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<thead class='table table-striped'>";
                echo "<tr>";
                
                    echo "<th class='table-dark' scope='col'><a href='gestionarusuario.php?ord={$ord}&&campo=nombreusuario' class='btn btn-secondary'>Usuario</a></th>";
                    //echo "<th class='table-dark' scope='col'>ID</th>";
                    echo "<th class='table-dark' scope='col'><a href='gestionarusuario.php?ord={$ord}&&campo=nombre' class='btn btn-secondary'>Nombre</a></th>";
                    echo "<th class='table-dark' scope='col'><a href='gestionarusuario.php?ord={$ord}&&campo=apellidos' class='btn btn-secondary'>Apelllidos</a></th>";
                    echo "<th class='table-dark' scope='col'>Teléfono</th>";
                    echo "<th class='table-dark' scope='col'><a href='gestionarusuario.php?ord={$ord}&&campo=mail' class='btn btn-secondary'>Email</a></th>";
                    echo "<th class='table-dark' scope='col'><a href='gestionarusuario.php?ord={$ord}&&campo=rol' class='btn btn-secondary'>Rol</a></th>";
                    echo "<th class='table-dark' scope='col' colspan='3' class='text-center'>Operaciones</th>";
            
                echo "</tr>";  
            echo "</thead>";
            echo "<tbody>";
                echo "<tr>";
                    //SELECT DE INCIDENCIAS no resueltas Y MOSTRARLAS
                    $query = "SELECT * FROM usuarios2 WHERE idusuario<>{$idusuarioenuso} order by {$campo} {$ord}";               
                    $vista_usuarios = mysqli_query($enlace,$query);

                    while($row = mysqli_fetch_assoc($vista_usuarios))
                    {

                        $id = $row['idusuario'];

                        $usuario = $row['nombreusuario'];
                        $nombre = $row['nombre'];
                        $apellidos = $row['apellidos'];
                        $telefono = $row['telefono'];     
                        $email = $row['mail'];        
                        $rol = $row['rol'];          

                        echo "<tr >";
                            echo " <th scope='row' >{$usuario}</th>";
                            //echo " <td > {$id}</td>";
                            echo " <td > {$nombre}</td>";
                            echo " <td > {$apellidos}</td>";
                            echo " <td >{$telefono} </td>";
                            echo " <td >{$email} </td>";
                            echo " <td >{$rol} </td>";
                            //echo " <td class='text-center'> <a href='verusuario.php?incidencia_id={$id}' class='btn btn-primary'> <i class='bi bi-eye'></i> Ver</a> </td>";

                            if(strcmp($rolenuso,"administrador")==0)
                            {
                                echo " <td class='text-center' > <a href='editarusuario.php?editar&usuarioid={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
                                echo " <td class='text-center'>  <a href='borrarusuario.php?eliminar={$id}' class='btn btn-danger' > <i class='bi bi-trash'></i> Eliminar</a> </td>";
                            
                            }
                            
                        echo " </tr> ";
                        
                    }
                echo "</tr>";  
            echo "</tbody>";
        echo "</table>";
    echo "</div>";
    mysqli_close($enlace);
    echo "<p class='usuario'>Ojo! Si eliminas un usuario, eliminarás las incidencias asociadas al mismo.</p>";
    echo "<div class='container text-center mt-5'>";
        echo "<a href='panelgestion.php?usuario={$idusuarioenuso}' class='btn btn-warning mt-5'> Volver </a>";
    echo "</div>";



}else

{
    echo "<p><h1>lO SIENTO NO ESTAS AUTORIZADO A VER EST INFORMCIÓN</h1></p>";
    echo "<div class='container text-center mt-5'>";
        echo "<a href='logout.php' class='btn btn-warning mt-5'> SALIR </a>";
    echo "</div>";
}

include "pie.php"; ?>