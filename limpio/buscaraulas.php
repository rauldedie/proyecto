    <?php
    include "conexion.php";
    $html = "";
    if ($_POST["plantaelegida"]) {

        $plantaselec = htmlspecialchars($_POST['plantaelegida']);
        $query = "SELECT * FROM aulas2 WHERE idplanta={$plantaselec}";
        $resultado = mysqli_query($enlace,$query);
        //$fila = mysqli_fetch_array($resultado);
        $id=1;
        if($resultado)
        {
            while ($fila = mysqli_fetch_assoc($resultado))
            {
                $html .= '<option value='.$fila['idaula'].'>'.$fila['aula'].'</option>';
                $id= $id+1;
            }
        }
    }
 
    echo $html;	
    ?>