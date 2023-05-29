</tr>  
            </tbody>
        </table>
        <div class="form-group">
          <?php 
            include "conexion.php";
            $query = "SELECT count(*) numero from incidencias2 WHERE fecha_resol is not null";
            $resultado = mysqli_query($enlace,$query);
            $sinresolver = mysqli_fetch_array($resultado);
            $query = "SELECT count(*) numero from incidencias2 WHERE fecha_resol is null";
            $resultado = mysqli_query($enlace,$query);
            $resueltas = mysqli_fetch_array($resultado);
          ?>
          <p>Incidencias resueltas: <?php $resueltas['numero'] ?></p>
          <p>Incidencias pendientes de resolver: <?php $sinresolver['numero'] ?></p>
        </div>
    </div>
    <div class="container text-center mt-5">
      <a href="logout.php" class="btn btn-warning mt-5"> Salir </a>
    </div>
<?php include "pie.php" ?>