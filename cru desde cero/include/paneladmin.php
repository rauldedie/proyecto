<?php
    
    if(isset($_GET['rol']))
    {
        $rol=htmlspecialchars($_GET['rol']);
        echo $rol;        
    }
?>