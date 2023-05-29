<?php
include "conexion.php";
$html = "";
if ($_POST["plantaelegida"]==1) {

    $plantaselec = htmlspecialchars($_POST['plantaelegida']);
    $query = "SELECT * FROM aulas WHERE planta={$plantaselec}";
    $resultado = mysqli_query($enlace,$query);
    $fila = mysqli_fetch_array($resultdo);
    $id=0;
    if($resultado)
    {
        while ($fila = mysqli_fetch_assoc($reaultado))
        {
            $html = '<option value='.$id.'>'.$fila ['aula'].'</opion>';
        }
    }
	/*$html = '
	<option value="1">Buenos Aires</option>
    <option value="2">Cordoba</option>
    <option value="3">Rosario</option>
    <option value="4">Salta</option>
	';	*/
}
if ($_POST["plantaelegida"]==2) {

    $plantaselec = htmlspecialchars($_POST['plantaelegida']);
    $query = "SELECT * FROM aulas WHERE planta={$plantaselec}";
    $resultado = mysqli_query($enlace,$query);
    $fila = mysqli_fetch_array($resultdo);
    $id=0;
    if($resultado)
    {
        while ($fila = mysqli_fetch_assoc($reaultado))
        {
            $html = '<option value='.$id.'>'.$fila ['aula'].'</opion>';
        }
    }

	/*$html = '
	<option value="1">Madrid</option>
    <option value="2">Barcelona</option>
    <option value="3">Sevilla</option>
    <option value="4">Bilbao</option>
	';*/
}
if ($_POST["plantaelegida"]==3) {

    $plantaselec = htmlspecialchars($_POST['plantaelegida']);
    $query = "SELECT * FROM aulas WHERE planta={$plantaselec}";
    $resultado = mysqli_query($enlace,$query);
    $fila = mysqli_fetch_array($resultdo);
    $id=0;
    if($resultado)
    {
        while ($fila = mysqli_fetch_assoc($reaultado))
        {
            $html = '<option value='.$id.'>'.$fila ['aula'].'</opion>';
        }
    }
	/*$html = '
	<option value="1">CDMX</option>
    <option value="2">Monterrey</option>
    <option value="3">Guadalajara</option>
    <option value="4">Tijuana</option>
	';	*/
}
echo $html;	
?>