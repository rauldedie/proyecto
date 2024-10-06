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


include "conexion.php"; 
include "cabecera.php";

//echo $rolenuso;

if (isset($_GET['usuario']))
{
    $tipousuario = htmlspecialchars(stripslashes($_GET['usuario']));

    //echo $tipousuario;
    //echo $rolenuso;
    //echo $idenuso;

    if( strcmp($tipousuario,'administrador') == 0 && $idenuso==1 && $rolenuso==1)
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
    
    /*if(isset($_GET['estado']))
    {
        $estado = htmlspecialchars(stripslashes($_GET['estado']));

    }else $estado='alta';*/

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


    //echo $rolenuso;
    echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>";
    echo"<p><img class='logo' src='logolitho.jpg'></p>";
    echo "<label class='navbar-brand'><span class='text-light bg-dark'>GESTION DEPORTISTAS (Comprobación de Cuentas)</span></label>
        <div class='collapse navbar-collapse' id='navbarSupportedContent'>
            <ul class='navbar-nav mr-auto'>
                    
                <li class='nav-item'>
                    <a class='navbar-brand' href='panelprincipal.php?rol={$idenuso}&&usuario={$idenuso}'><span class='text-primary'>VOLVER</span></a>
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

        echo "<form  name='conciliacion' action='' method='POST'> 

            <div class='row g-2'>
                <div class='col-md'>
                    <div class='mb-3'>
                        <label for='validationCustom03' class='form-label'><span class='obligado'>Nombre</span></label>
                        <input type='text' class='form-control' id='validationCustom03' name='nombre' placeholder='Nombre'>
                        <div class='valid-feedback'>
                            ¡Correcto!
                        </div>
                    </div>
                </div>

                <div class='col-md'>
                    <div class='mb-3'>
                        <label for='validationCustom03' class='form-label'><span class='obligado'>Primer apellido</span></label>
                        <input type='text' class='form-control' id='validationCustom03' name='apellido1' placeholder='Primer apellido'>
                        <div class='valid-feedback'>
                            ¡Correcto!
                        </div>
                    </div>
                </div>

                <div class='col-md'>
                    <div class='mb-3'>
                        <label for='validationCustom03' class='form-label'><span class='obligado'>Segundo apellido</span></label>
                        <input type='text' class='form-control' id='validationCustom03' name='apellido2' placeholder='Segundo apellido'>
                        <div class='valid-feedback'>
                            ¡Correcto!
                        </div>
                    </div>
                </div>

                <div class='col-md'>
                    <div class='mb-3'>
                        <label for='validationCustom03' class='form-label'><span class='obligado'>Número de cuenta</span></label>
                        <input type='text' class='form-control' id='validationCustom03' name='cuenta' placeholder='Cuenta bancaria'>
                        <div class='valid-feedback'>
                            ¡Correcto!
                        </div>
                    </div>
                </div>
            </div>

            <div  class='container text-center mt-5'>
                <button type='submit' name='buscacuenta' class='btn btn-primary'>Buscar Cuenta Bancaria</button>
            </div>
        </form><br>";

        if(isset($_POST['buscacuenta'])) 
        {
            $nombre = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['nombre']))));
            $apellido1 = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['apellido1']))));
            $apellido2 = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['apellido2']))));
            $cuenta = strtoupper(htmlspecialchars(mysqli_real_escape_string($enlace,stripslashes($_POST['cuenta']))));
            //echo $cuenta;
            
            if ( empty($nombre) && empty($apellido1) && empty($apellido2) && empty($cuenta))
            {
                echo "Demasiados campos vacíos. Al menos debe de proporcionar un dato de búsqueda.<br>";

            }else
            {
                if (!empty($cuenta))
                {
                    if (verificarCadena($cuenta)) 
                    {

                        $query = "SELECT idalumno, nombre, apellido1, apellido2, cuenta FROM alumnos WHERE cuenta='{$cuenta}' ORDER BY {$campo} {$ord}";
                        echo $query;

                        /*if ($stmt = mysqli_prepare($enlace, $query)) {
                            mysqli_stmt_bind_param($stmt, 's', $cuenta);
                            mysqli_stmt_execute($stmt);
                            $respuesta = mysqli_stmt_get_result($stmt);
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "Error en la preparación de la consulta.";
                        }*/
                        $respuesta = mysqli_query($enlace,$query);
                        echo $respuesta

                    } else {
                        
                        echo "<label for='validationCustom03' class='form-label'><span>La cuenta no es válida. Introduzca una cuenta válida con formato:</span></label><br>
                        <label for='validationCustom03' class='form-label'><span class='obligado'>Dos letras y 22 numeros, sin espacios (ESxxxxxxxxxxxxxxxxxxxxxxxx).</span></label><br>";

                    }

                }else
                {
                    
                    if (!empty($nombre))
                    {
                        if (!empty($apellido1))
                        {
                            if(!empty($apellido2))
                            {
                                $query = "SELECT idalumno,nombre,apellido1,apellido2,cuenta
                                FROM alumnos WHERE nombre='{$nombre}' and apellido1='{$apellido1}' and apellido2='{$apellido2}' ORDER BY {$campo} {$ord}";
                                $respuesta = mysqli_query($enlace,$query);

                            }else
                            {
                                $query = "SELECT idalumno,nombre,apellido1,apellido2,cuenta
                                FROM alumnos WHERE nombre='{$nombre}' and apellido1='{$apellido1}' ORDER BY {$campo} {$ord}";
                                $respuesta = mysqli_query($enlace,$query);
                            }

                        }else
                        {
                            //echo "hola";
                            $query = "SELECT idalumno,nombre,apellido1,apellido2,cuenta
                            FROM alumnos a WHERE nombre='{$nombre}' ORDER BY {$campo} {$ord}";
                            //echo $query;
                            $respuesta = mysqli_query($enlace,$query);
                            //echo $respuesta;
                        }
                    }else
                    {
                        if (!empty($apellido1))
                        {
                            if (!empty($apellido2))
                            {
                                $query = "SELECT idalumno,nombre,apellido1,apellido2,cuenta
                                FROM alumnos WHERE apellido1='{$apellido1}' and apellido2='{$apellido2}' ORDER BY {$campo} {$ord}";
                                $respuesta = mysqli_query($enlace,$query);

                            }else
                            {
                                $query = "SELECT idalumno,nombre,apellido1,apellido2,cuenta
                                FROM alumnos a WHERE  apellido1='{$apellido1}' ORDER BY {$campo} {$ord}";
                                $respuesta = mysqli_query($enlace,$query);
                            }
                        }else
                        {
                            $query = "SELECT idalumno,nombre,apellido1,apellido2,cuenta
                            FROM alumnos WHERE apellido2='{$apellido2}' ORDER BY {$campo} {$ord}";
                            $respuesta = mysqli_query($enlace,$query);
                        }
                    }
                    echo "<table class='table table-striped table-bordered table-hover'>";
                    echo "<thead class='table table-striped'>";
                        echo "<tr>";                   
                            echo "<th class='table-dark' scope='col'><a>Alumno</a></th>";
                            echo "<th class='table-dark' scope='col'><a>Número de Cuenta</a></th>";
                            echo "<th class='table-dark' scope='col' colspan='3' class='text-center'>Operaciones</th>";
                        echo "</tr>";  
                    echo "</thead>";
                    echo "<tbody>";
                    
                            while($row = mysqli_fetch_assoc($respuesta))
                            {
                                $id = $row['idalumno'];
                                $alumno = $row['nombre'].' '.$row['apellido1'].' '.$row['apellido2'];
                                $cuenta = $row['cuenta'];
                                echo"<tr>";
                                        echo "<td>{$alumno}</td>";
                                        echo "<td class='obligado'>{$cuenta}</td>";
                                        echo "<td></td>";
                                echo "</tr>";
                            }

                    echo "</tbody>";
                    echo "</table>";
                }

            }

        }
    echo "</div>";
    mysqli_close($enlace);
     
}

include "pie.php";


function verificarCadena($cadena) 
{
    // Verificar longitud de la cadena
    if (strlen($cadena) !== 24) {
        return 0;
    }

    // Verificar si los primeros dos caracteres son letras
    $primerasDosLetras = substr($cadena, 0, 2);
    if (!ctype_alpha($primerasDosLetras)) {
        return 0;
    }

    // Verificar si los siguientes 22 caracteres son números
    $restoNumeros = substr($cadena, 2);
    if (!ctype_digit($restoNumeros)) {
        return 0;
    }

    return 1;
}
?>
