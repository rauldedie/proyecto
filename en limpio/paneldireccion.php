<?php include "cabecera.php"?>
<div class="form-group">
        <h1 class="text-center" >Gestión de incidencias (CRUD).</h1>
        <a href="creaincidencia.php" class='btn btn-outline-dark mb-2'> <i class="bi bi-person-plus"></i> Añadir Incidencia</a>
        <table class="table table-striped table-bordered table-hover">
            <thead class="table table-striped">
                <tr>
                    
                    <th class="table-dark" scope="col">Usuario</th>
                    <th class="table-dark" scope="col">Planta</th>
                    <th class="table-dark" scope="col">Aula</th>
                    <th class="table-dark" scope="col">Descripción</th>
                    <th class="table-dark" scope="col">Fecha alta</th>
                    <th class="table-dark" scope="col">Fecha revisión</th>
                    <th class="table-dark" scope="col">Fecha solución</th>
                    <th class="table-dark" scope="col">Comentario</th>
                    <th class="table-dark" scope="col" colspan="3" class="text-center">Operaciones</th>
                </tr>  
            </thead>
            <tbody>
                <tr>