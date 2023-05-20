<?php  include 'cabecerapanel.php';
    $servidor = "217.76.150.73";
    $usuario = "qahx080"; 
    $passwd = "1smer1l10N"; 
    $bd = "qahx080"; 
    $enlace = mysqli_connect($servidor,$usuario,$passwd,$bd);

    if(!$enlace)
    {
        echo "Conexion fallida: ".mysqli_connect_error();

    }
    ?>
<h1 class="text-center">Detalles de incidencia</h1>
<div class="container">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">Usuario</th>
                <th  scope="col">Planta</th>
                <th  scope="col">Aula</th>
                <th  scope="col">Descripción</th>
                <th  scope="col">Fecha alta</th>
                <th  scope="col">Fecha revisión</th>
                <th  scope="col">Fecha solución</th>
                <th  scope="col">Comentario</th>
            </tr>  
        </thead>
        <tbody>
            <tr>
               
                <?php
                    if (isset($_GET['incidencia_id'])) 
                    {
                        $incidenciaid = htmlspecialchars($_GET['incidencia_id']); 
                        $query="SELECT * FROM incidencias2 WHERE idincidencias = {$incidenciaid} LIMIT 1";  
                        $vista_incidencias= mysqli_query($enlace,$query);            

                        while($row = mysqli_fetch_assoc($vista_incidencias))
                        {
                            $id = $row['id'];

                            $query2 = sprintf("SELECT * FROM usuarios2 WHERE idusuario='%s'",$row['idusuario']);
                            $usuario = mysqli_fetch_array(mysqli_query($enlace,$query2));
                            $usuario_inc = $usuario['nombre'];

                            $query2 = sprintf("SELECT * FROM aulas2 WHERE idaula='%s'",$row['idaula']);
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

                            echo "<tr >";
                                echo " <td >{$usuario_inc}</td>";
                                echo " <td > {$planta_inc}</td>";
                                echo " <td > {$aula_inc}</td>";
                                echo " <td >{$descripcion} </td>"; 
                                echo " <td >{$fecha_alta} </td>";
                                echo " <td >{$fecha_rev} </td>";
                                echo " <td >{$fecha_sol} </td>";
                                echo " <td >{$comentario} </td>";
                            echo " </tr> ";
                        }
                    }
                ?>
            </tr>  
        </tbody>
    </table>
</div>

<div class="container text-center mt-5">
    <a href="paneladmin.php" class="btn btn-warning mt-5"> Volver </a>
</div>

<?php include "piepanel.php" ?>