<?php
    session_start();
    $tiempo_inactivo = 10 * 60;
    if (!array_key_exists("usuario_id",$_SESSION))
    {
        // Si no tenia la sesion iniciada
        header("Location:logout.php");
    }//DE ESTA FORMA FUNCIONA
    if (isset($_SESSION['inactivo']) && (time() - $_SESSION['inactivo']) > $tiempo_inactivo) 
    {
        session_unset();
        session_destroy();

        //Redireccionamos el usuario a logout
        header("Location: logout.php");
        exit();
    }else
    {
        // Regenera nueva sesion y fija de nuevo el tiempo
        session_regenerate_id(true);

        // Update the last timestamp
        $_SESSION['inactivo'] = time();
    }

    include "conexion.php";
    $nombreusuario = $_SESSION['usuario_nombre'];
    $idenuso = $_SESSION['usuario_id'];
    $rolenuso = $_SESSION['usuario_rol'];

    /*if (isset($_GET['usuario']))
    {
    $idusuario = htmlspecialchars(stripslashes(trim($_GET['usuario'])));
    if(isset ($_GET['rol']))
    {
        $rol=htmlspecialchars(stripslashes(trim($_GET['rol'])));
        $query = "SELECT t.tipousuario tipo FROM usuarios u, tipo_usuario t WHERE idusuario={$idusuario} and u.tipousuario={$rol} and u.estado='alta'";
        $fila = mysqli_fetch_array(mysqli_query($enlace,$query));
        if (strcmp($fila['tipo'],"administrador")!=0)
        {
        echo "<script>window.location='logout.php;</script>";
        }
    }else
    {
        echo "<script>window.location='logout.php;</script>";
    }
    
    }*/

    include "cabecera.php";
    //Muestro menu de la pagina
    echo "<nav class='navbar navbar-expand-lg navbar-light bg-dark'>
        <p><img class='logo' src='logolitho.jpg'></p>
        <label class='navbar-brand'><span class='text-light bg-dark'>PANEL PRINCIPAL</span></label>
        <div class='collapse navbar-collapse' id='navbarSupportedContent'>
            <ul class='navbar-nav mr-auto'>
               
                <li></li>
                <li></li>
                <li class='nav-item'>
                    <a class='navbar-brand' href='panelprincipal.php?rol={$rolenuso}&&usuario={$idenuso}'><span class='text-primary'>INICIO</span></a>
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
    echo "<div class='table-dark'>";
        echo "<p> Nombre de la empresa</p>";
        echo "<p> Dirección de la empresa</p>";
        echo "<p> Telefono de la empresa</p>";
        echo "<p> Cif de la empresa</p>";
        echo "<p> Mail de la empresa</p>";
        echo "<p>Ley 34/2002, de 11 de julio, de servicios de la sociedad de la información y de comercio electrónico (LSSI)</p>";
        echo "<p>Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y garantía de los derechos digitales (LOPDGDD)</p>";
        echo "<p>Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo, de 27 de abril de 2016, relativo a la protección de las personas físicas en lo que respecta al tratamiento de datos personales y a la libre circulación de estos datos</p>";
    echo "</div>";

    include "pie.php";
?>