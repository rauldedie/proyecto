
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

$nombreusuario = $_SESSION['usuario_nombre'];
$idenuso = $_SESSION['usuario_id'];
$rolenuso = $_SESSION['usuario_rol'];
$rol=$rolenuso;

include "conexion.php"; 


if (isset($_GET['usuario']))
{
    $idusuario = htmlspecialchars(stripslashes($_GET['usuario']));

    /*if (isset($_GET['dojo']))
    {
        $iddojo = htmlspecialchars(stripslashes($_GET['dojo']));

    }else $iddojo = 1;*/

    if($idusuario == $idenuso && $rolenuso==1)
    {
      $query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idenuso} and u.tipousuario=t.idtipo and u.estado='alta'";
      $fila = mysqli_fetch_array(mysqli_query($enlace,$query));
      if (strcmp($fila['tipo'],"administrador")!=0)
      {
        echo "<script>window.location='logout.php;</script>";
      }
    }else
    {
      echo "<script>window.location='logout.php;</script>";
    }

    if(isset($_GET['estado']))
    {
        $estado = htmlspecialchars(stripslashes($_GET['estado']));

    }else $estado='alta';

    if(isset($_GET['mostrar']))
    {
        $mostrar = htmlspecialchars($_GET['mostrar']);
    
    }else $mostrar='all';
    //echo $mostrar;
    //establezco campo y ordenacion 
    //la primera vez, al hacer login viene establecido, el resto segun decida el usuario
    //de vuelta de otra pagina el orden siempre sera asc y por el campo nombre
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
        $campo = "nombre";
    }
    
    $query = "SELECT tipousuario from tipo_usuario WHERE idtipo={$idusuario}";
    $fila = mysqli_fetch_array(mysqli_query($enlace,$query));
    $rolenuso = $fila['tipousuario'];

    /*$query = "SELECT nombre FROM dojo WHERE iddojo={$iddojo}";
    $nombredojo = mysqli_fetch_array(mysqli_query($enlace,$query));
    $dojo = $nombredojo['nombre'];*/
    include "cabecera.php";
    echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>
            <p><img class='logo' src='logolitho.jpg'></p>
            <label class='navbar-brand'><span class='text-light bg-dark'>GESTIÓN MENSUALIDADES</span></label>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav mr-auto'>

                    <li></li>
                    <li></li>
                    <li class='nav-item'>
                        <a class='navbar-brand' href='panelprincipal.php?rol={$rol}&&usuario={$idenuso}'><span class='text-primary'>VOLVER</span></a>
                    </li>
                    <li class='nav-item'>
                        <a class='navbar-brand' href='avisolegal.php'><span class='text-warning'>AVISO LEGAL</span></a>
                    </li>
                    <li class='nav-item'>
                        <a class='navbar-brand' href='logout.php'><span class='text-warning'>SALIR</span></a>
                    </li>

                </ul>

            </div>
        </nav>";
    
    echo "<div class='form-group'>";
    echo "<br>";
    echo "<label class='nav-item'><h6>Usuario: ".$nombreusuario."</h6></label><br>"; 
    
        if(strcmp($rolenuso,"administrador")==0)//añadir oficina
        {   
            /*ESTA PARA EN EL FUTURO GESTIONAR MENSUALIDADES DE GENTE DE BAJA
            if($estado=="alta")
            {
                echo " <a href='gestionardojo.php?dojo={$iddojo}&&usuario={$idusuario}&&estado=baja' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Alumnos de baja</a>";
                //echo "<a href='gestionarusuario.php' class='btn btn-outline-dark mb-2'> <i class='bi bi-person-plus'></i> Gestionar Clases</a>";

            }
            ESTO ES PARA GESTIONAR POR DOJO LAS MENSUALIDADES AHORA SE HACEN TODOS JUNTOS
            $query = "SELECT iddojo FROM dojo where iddojo<>{$iddojo}";
            //echo $query;
            $resp = mysqli_fetch_array(mysqli_query($enlace,$query));
            $cambiodojo = $resp['iddojo'];*/

            echo "<a href='cuotasmes.php?usuario={$idenuso}&&ord=asc' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> AÑADIR CUOTAS DEL MES</a>";
           
            echo "<a href='gestionbancaria.php?usuario={$rolenuso}&&ord={$ord}&&campo=nombre&&mostrar=all' class='btn btn-outline-dark mb-2'> <i class='bi bi-person'></i> Comprobacion Cuentas</a>";

            
            
        }
        if (strcmp($ord,"desc")==0)
        {
            $ord="asc";
        }else
        {
            $ord="desc";
        }   
        
        echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<thead class='table table-striped'>";
                echo "<tr>";                   
                    echo "<th class='table-dark' scope='col'colspan='3'><a href='gestionarmensualidad.php?dojo={$iddojo}&&usuario={$idusuario}&&ord={$ord}&&campo=nombre' class='btn btn-secondary'>Alumno</a></th>";
                    //echo "<th class='table-dark' scope='col'><a href='gestionardojo.php?dojo={$iddojo}&&usuario={$idusuario}&&ord={$ord}&&campo=idnivel' class='btn btn-secondary'>Nivel (Kyu)</a></th>";
                    echo "<th class='table-dark' scope='col'>mes cuota</th>";
                    echo "<th class='table-dark' scope='col'>año</th>";
                    echo "<th class='table-dark' scope='col'>estado</th>";
                    echo "<th class='table-dark' scope='col' colspan='3' class='text-center'>Operaciones</th>";
                echo "</tr>";  
            echo "</thead>";
            echo "<tbody>";
                echo "<tr>";

                    $mesActual = date("m");
                    $anioActual = date("Y");

                    //SELECT DEPORTISTAS
                    $query = "SELECT a.idalumno,a.nombre,a.apellido1,a.apellido2, c.estado,c.mes,c.anio,c.idcuota
                    from alumnos a, cuotas c
                    WHERE a.idalumno=c.idalumno and c.mes='{$mesActual}' and c.anio='{$anioActual}' ORDER BY {$campo} asc";
                    //echo $query;
                    $respuesta = mysqli_query($enlace,$query);
                    
                    while($row = mysqli_fetch_assoc($respuesta))
                    {

                        $id = $row['idalumno'];
                        $id_cuota = $row['idcuota'];
                        $usuario = $row['nombre']." ".$row['apellido1']." ".$row['apellido2'];
                        $mes_int = intval($row['mes']);

                        switch ($mes_int)
                        {
                            case 1:
                                {
                                    $mes="ENERO";
                                    break;
                                }
                            case 2:
                                {
                                    $mes="FEBRERO";
                                    break;
                                }
                            case 3:
                                {
                                    $mes="MARZO";
                                    break;
                                }
                            case 4:
                                {
                                    $mes="ABRIL";
                                    break;
                                }
                            case 5:
                                {
                                    $mes="MAYO";
                                    break;
                                }
                            case 6:
                                {
                                    $mes="JUNIO";
                                    break;
                                }
                            case 7:
                                {
                                    $mes="JULIO";
                                    break;
                                }
                            case 8:
                                {
                                    $mes="AGOSTO";
                                    break;
                                }
                            case 9:
                                {
                                    $mes="SEPTIEMBRE";
                                    break;
                                }
                            case 10:
                                {
                                    $mes="OCTUBRE";
                                    break;
                                }
                            case 11:
                                {
                                    $mes="NOVIEMBRE";
                                    break;
                                }
                            case 12:
                                {
                                    $mes="DICIEMBRE";
                                    break;
                                }
                        }
                    
                        //$mes = intval($row['mes']);
                        $anio = $row['anio'];
                        $estado_int = intval($row['estado']);
                        if ($estado_int == 0)
                        {
                            $estado = "Pendiente" ;
                        }else
                        {
                            $estado = "Pagado" ;
                        }
                        
                        echo "<tr >";
                            echo " <th scope='row' colspan='3'>{$usuario}</th>";
                            echo " <td class='table-dark'> {$mes}</td>";
                            echo " <td class='table-dark'> {$anio}</td>";
                            echo " <td class='table-dark'>{$estado} </td>";
                            
                            if ($row['estado'] == 0)
                            {
                                echo " <td class='text-center'> <a href='pagarcuotas.php?idelemento={$id_cuota}&&usuario={$idenuso}' class='btn btn-primary'> <i class='bi bi-eye'></i> Pagar Mes </a> </td>";
                            
                            }else
                            {
                                $query2 = "SELECT idcuota FROM cuotas WHERE idalumno={$id} and estado=0";
                                //echo $query2."<br>";
                                $pendientes2 =  mysqli_query($enlace,$query2);

                                if (mysqli_num_rows($pendientes2) > 0)
                                {
                                    $allok = "Tiene cuotas pendientes";
                                }else
                                {
                                    $allok = "No tiene cuotas pendientes";
                                }
                                echo " <td class='text-center'> <a> $allok </a> </td>";
                            }
                            echo " <td class='text-center' > <a href='historicocuotas.php?idalumno={$id}&&usuario={$idenuso}' class='btn btn-secondary' ><i class='bi bi-pencil'></i>Ver histórico coutas</a> </td>";

                            
                        echo " </tr> ";
                           
                    }
                    
                echo "</tr>";  
            echo "</tbody>";
        echo "</table>";
    echo "</div>";
    mysqli_close($enlace);
     
}

include "pie.php";

?>

