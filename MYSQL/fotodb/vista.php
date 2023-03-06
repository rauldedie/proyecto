<?php
//include ("ver.php");

if(!empty($_GET['id'])){
    //Credenciales de conexion
    $Host = "sdb-53.hosting.stackcp.net";
    $Username = "rauldedie";
    $Password = "lince123";
    $dbName = "bdpruebas-353030355619";
    
    //Crear conexion mysql
    $db = new mysqli($Host, $Username, $Password, $dbName);
    
    //revisar conexion
    if($db->connect_error){
       die("Connection failed: " . $db->connect_error);
    }
    
    //Extraer imagen de la BD mediante GET
    $result = $db->query("SELECT imagenes FROM images_tabla WHERE id = 2");
    
    if($result->num_rows > 0){
        $imgDatos = $result->fetch_assoc();
        
        //Mostrar Imagen
        header("Content-type: image/jpg"); 
        echo $imgDatos['imagenes']; 
    }else{
        echo 'Imagen no existe...';
    }
}
?>