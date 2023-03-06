<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Almacenar imagen en la base de datos MySQL usando PHP</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">
*{ font-family:Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif}
.main{ margin:auto; border:1px solid #7C7A7A; width:60%; text-align:left; padding:30px; background:#85c587}
input[type=submit]{ background:#6ca16e; width:100%;
    padding:5px 15px; 
    background:#ccc; 
    cursor:pointer;
	font-size:16px;
   
}
input[type=text]{  width:40%;
    padding:5px 15px; height:25px;
	font-size:16px;
   
}
.form-control {
	padding: 0px 0px;
}
</style>
</head>
<body bgcolor="#bed7c0">
<bR>
<div class="main">
<h1>Cargar y Almacenar imagen en MySQL PHP</h1>
  <div class="panel panel-primary">
    <div class="panel-body">

      <form name="MiForm" id="MiForm" method="post" action="cargar.php" enctype="multipart/form-data">
        <h4 class="text-center">Seleccione imagen a cargar</h4>
        <div class="form-group">
          <label class="col-sm-2 control-label">Archivos</label>
          <div class="col-sm-8">
            <input type="file" class="form-control" id="image" name="image" multiple>
          </div>
          <button name="submit" class="btn btn-primary">Cargar Imagen</button>
        </div>
      </form>
      
      
 	  </div> 
    </div>
 </div>
 
</body>
</html>