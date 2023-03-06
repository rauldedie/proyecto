<?php
$servidor = "sdb-58.hosting.stackcp.net";
$usuario = "examen-recuperacion-353031374fb0";
$password = "recuperacion-asir";
$nombrebd = "examen-recuperacion-353031374fb0";

/*$servidor= "sdb-53.hosting.stackcp.net";
$usuario= "rauldedie";
$password = "lince123";
$nombrebd= "bdpruebas-353030355619";*/

$enlace = mysqli_connect($servidor,$usuario,$password,$nombrebd);

        
if(!$enlace)
{
    echo "Conexion fallida: ".mysqli_connect_error();
    
}else
{ 
    //$query = "SELECT email FROM mails";
    $query = "SELECT * FROM mails";
    $resultado = mysqli_query($enlace,$query);
    
    if (!$resultado)
    {
        echo "Hay algun error";

    }else
    {
        while ($fila = mysqli_fetch_array($resultado));
        {
        
                $destino = $fila[0];
                $asunto = "Examen"; 
                $cuerpo = '<html><h1>Prueba Superada</h1></html>';
   
                //para el envío en formato HTML 
                $headers = "MIME-Version: 1.0\r\n"; 
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

                //dirección del remitente 
                $headers .= "From: Raul de Diego <raul@examen.com>\r\n"; 

                //dirección de respuesta, si queremos que sea distinta que la del remitente 
                //$headers .= "Reply-To: mariano@desarrolloweb.com\r\n"; 

                //ruta del mensaje desde origen a destino 
                //$headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 
                //direcciones que recibián copia 
                //headers .= "Cc: maria@desarrolloweb.com\r\n"; 

                //direcciones que recibirán copia oculta 
                //$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

                //mail($destinatario,$asunto,$cuerpo,$headers);
                echo "$destino, $asunto, $cuerpo, $headers";
            
        }
   
        mysqli_close($enlace); 
    }
}

 
?>