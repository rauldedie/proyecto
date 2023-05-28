<?php //include "./acciones/header.php";
//SEGUN EL ROL QUE ME ENVIA EN EL LOCATION CARGAMOS UNA U OTRO PANEL
include "conexion.php";
if (isset($_GET['usuario']))
{
    $idusuario = htmlspecialchars($_GET['usuario']);
    $query="SELECT rol,idusuario from usuarios2 WHERE idusuario={$idusuario}";
    $resultado=mysqli_query($enlace,$query);

    //$idhass = md5(md5('k$10pe1').$idusuario);
    $fila = mysqli_fetch_array($resultado);
    //$idhass2 = md5(md5('k$10pe1').$fila['idusuario']);
    
    /*if($idhass2!=$idhass)
    {
        include "logout.php";
    }*/
    
    switch ($fila['rol'])
    {
        case 'administrador' :
        {
            include "headadmin.php";
            
            break;
        }
        case "direccion"://NO ESTAN HECHOS SIN SESIONS NI COOKIES TENDRIA QUE REPTIR MUCHO CODIGO
        {
            include "headdireccion.php";
            break;
        }
        case "profesorado":
        {
            include "headprofesorado.php";
            break;
        }
    }

    //SELECT DE INCIDENCIAS Y MOSTRARLAS
    $query = "SELECT * FROM incidencias";               
    $vista_incidencias = mysqli_query($enlace,$query);

    //print_r($vista_incidencias);

    while($row = mysqli_fetch_assoc($vista_incidencias))
    {

        $id = $row['idincidencias'];
                           
        $query = "SELECT * FROM usuarios2 WHERE idusuario =".$row['idusuario'];
        $usuario_inci = mysqli_fetch_array(mysqli_query($enlace,$query));                  
                            
        $query = "SELECT * FROM aulas WHERE idaula =".$row['idaula'];                        
        $aula_inci =  mysqli_fetch_array(mysqli_query($enlace,$query));
                            
        $query = "SELECT * FROM plantas2 WHERE idplanta =".$aula_inci['idplanta'];                            
        $planta_inci = mysqli_fetch_array(mysqli_query($enlace,$query));

        $usuario = $usuario_inci['nombre']." ".$usuario_inci['apellidos'];
        $aula = $aula_inci['aula'];
        $planta = $planta_inci['planta'];      
        $descripcion = $row['descripcion'];        
        $fecha_alta = $row['fecha_alta'];        
        $fecha_rev = $row['fecha_mod'];        
        $fecha_sol = $row['fecha_resol'];        
        $comentario = $row['comentario']; 
                  

        echo "<tr >";
            echo " <th scope='row' >{$usuario}</th>";
            echo " <td > {$planta}</td>";
            echo " <td > {$aula}</td>";
            echo " <td >{$descripcion} </td>";
            echo " <td >{$fecha_alta} </td>";
            echo " <td >{$fecha_rev} </td>";
            echo " <td >{$fecha_sol} </td>";
            echo " <td >{$comentario} </td>";
            echo " <td class='text-center'> <a href='./acciones/viewadmin.php?incidencia_id={$id}' class='btn btn-primary'> <i class='bi bi-eye'></i> Ver</a> </td>";
            echo " <td class='text-center' > <a href='./acciones/update.php?editar&incidencia_id={$id}' class='btn btn-secondary' ><i class='bi bi-pencil'></i> Editar</a> </td>";
            echo " <td class='text-center'>  <a href='./acciones/borrarincidencia.php?eliminar={$id}' class='btn btn-danger' > <i class='bi bi-trash'></i> Eliminar</a> </td>";
            echo " </tr> ";
                            
        }
}
switch ($fila['rol'])
{
    case 'administrador' :
    {
        include "footadmin.php";
        
        break;
    }
    case "direccion"://NO ESTAN HECHOS SIN SESIONS NI COOKIES TENDRIA QUE REPTIR MUCHO CODIGO
    {
        include "footdireccion.php";
        break;
    }
    case "profesorado":
    {
        include "footprofesorado.php";
        break;
    }
}

//include "./acciones/footer.php"; ?>



   