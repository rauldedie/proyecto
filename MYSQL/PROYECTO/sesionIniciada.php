<?php

session_start();
if (array_key_exists("id",$_COOKIE) && $_COOKIE['id'])
{
    $_SESSION["id"] = $_COOKIE['id'];

}
if (array_key_exists("id",$_SESSION) && $_SESSION['id'])
{
    include("conexion.php");
    $query = sprintf("SELECT * FROM incidencias");
    $resultado=mysqli_query($enlace,$query);
    while ($fila=mysqli_fetch_array($resultado))
    {
        $planta = $fila['planta'];
        $aula = $fila ['aula'];
        $averia = $fila['descripcion'];
        $fecha_alta = $fila['fecha_alta'];
        $fecha_rev = $fila['fecha_revision'];
        $fecharesol = $fila['fecha_resolucion'];
        $comentario = $fila ['comentario'];
    
    }


}else{
    header ("Location: index.php");
}
include ("header.php");
?>
<div class="container-fluid" id="contenedorSesionIniciada">
    <!--TENGO QUE MOSTRAR LAS AVERIAS ACTIVAS
    CON TRES ICONOS AL FINAL DE ELIMINAR-MODIFICAR-RESOLVER
    CAMPOS A MOSTRAR:
    PLANTA, AULA, DESCRIPCION_AVERIA, FECHA_ALTA, fECHA_REVISION, FECHA RESOLUCION, COMENTARIO
    ELIMINAR BORRA LA AVERIA ELIMINANDOLA DE LA TABLA
    MODIFICAR MODIFICA FECHA_REVISION, COMENTARIO Y DESCRIPCION EL RESTO NO SE PUEDE MODIFICAR
    RESOLVER PONE FECHA DE RESOLUCION A LA AVERIA
    DEBE APARECER UN FORMULARIO DE NUEVA AVERIA-ISERT INTO
    ALMACENAR LOS ID DE LAS AVERIAS PARA SABER CUAL MODIFICAR/ELIMINAR SE HARA UPDATE O DELETE


echo '<table border="0" cellspacing="2" cellpadding="2"> 
      <tr> 
          <td> <font face="Arial">Planta</font> </td> 
          <td> <font face="Arial">Aula</font> </td> 
          <td> <font face="Arial">Descripcion Averia</font> </td> 
          <td> <font face="Arial">Fecha alta</font> </td> 
          <td> <font face="Arial">Fecha Revision</font> </td>
          <td> <font face="Arial">Fecha Resolucion</font> </td>
          <td> <font face="Arial">Comentario</font> </td>  
      </tr>';

    while ($fila=mysqli_fetch_array($resultado))
    {
        $field1name = $row["col1"];
        $field2name = $row["col2"];
        $field3name = $row["col3"];
        $field4name = $row["col4"];
        $field5name = $row["col5"]; 

        echo '<tr> 
                  <td>'.$field1name.'</td> 
                  <td>'.$field2name.'</td> 
                  <td>'.$field3name.'</td> 
                  <td>'.$field4name.'</td> 
                  <td>'.$field5name.'</td> 
              </tr>';
    }
} 
?>
</body>
</html>





-->
</div>